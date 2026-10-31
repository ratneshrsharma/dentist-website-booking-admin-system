<?php

declare(strict_types=1);

namespace App\Actions\Appointments;

use App\DTOs\AppointmentBookingDTO;
use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\NotificationLog;
use App\Models\PatientIntake;
use App\Models\PatientProfile;
use App\Models\Service;
use App\Models\SystemAuditLog;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateAppointmentAction
{
    public function __construct(
        private readonly BookingAvailabilityService $availabilityService
    ) {}

    /**
     * Execute transactional 5-step appointment booking.
     */
    public function execute(AppointmentBookingDTO $dto): Appointment
    {
        return DB::transaction(function () use ($dto): Appointment {
            // 1. Double-booking check: Ensure selected slot is currently free
            $availableSlots = $this->availabilityService->getAvailableSlots(
                $dto->clinicId,
                $dto->doctorProfileId,
                $dto->serviceId,
                $dto->appointmentDate
            );

            $selectedSlot = null;
            foreach ($availableSlots as $slot) {
                if ($slot['time'] === $dto->startTime && $slot['available']) {
                    $selectedSlot = $slot;
                    break;
                }
            }

            if (! $selectedSlot) {
                throw new RuntimeException("Selected time slot {$dto->startTime} on {$dto->appointmentDate} is no longer available.");
            }

            // 2. Resolve or create patient profile (De-duplication by phone/email)
            $patient = PatientProfile::where('primary_clinic_id', $dto->clinicId)
                ->where(function ($query) use ($dto): void {
                    $query->where('phone', $dto->phone);
                    if ($dto->email) {
                        $query->orWhere('email', $dto->email);
                    }
                })
                ->first();

            if (! $patient) {
                $mrn = 'MRN-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(3)));

                $patient = PatientProfile::create([
                    'primary_clinic_id' => $dto->clinicId,
                    'medical_record_number' => $mrn,
                    'first_name' => $dto->firstName,
                    'last_name' => $dto->lastName,
                    'phone' => $dto->phone,
                    'email' => $dto->email,
                    'date_of_birth' => '1990-01-01', // Default until detailed demographic update
                    'allergies' => $dto->hasAllergies ? $dto->allergyDetails : null,
                ]);
            }

            // 3. Compute appointment end time
            $service = Service::findOrFail($dto->serviceId);
            $start = Carbon::parse($dto->appointmentDate . ' ' . $dto->startTime);
            $end = $start->copy()->addMinutes($service->standard_duration_minutes);

            $bookingReference = 'SCD-' . strtoupper(bin2hex(random_bytes(4)));

            // 4. Create appointment
            $appointment = Appointment::create([
                'booking_reference' => $bookingReference,
                'clinic_id' => $dto->clinicId,
                'doctor_profile_id' => $dto->doctorProfileId,
                'patient_profile_id' => $patient->id,
                'service_id' => $dto->serviceId,
                'appointment_date' => $dto->appointmentDate,
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'status' => AppointmentStatus::CONFIRMED,
                'booking_channel' => 'website_wizard',
                'patient_notes' => $dto->patientNotes,
            ]);

            // 5. Record medical intake questionnaire & digital signature
            PatientIntake::create([
                'appointment_id' => $appointment->id,
                'patient_profile_id' => $patient->id,
                'chief_complaint' => $dto->chiefComplaint,
                'pain_level_1_to_10' => $dto->painLevel,
                'last_dental_visit_interval' => $dto->lastVisit,
                'digital_signature_hash' => hash('sha256', $dto->digitalSignature . $appointment->booking_reference),
                'consent_acknowledged_at' => now(),
            ]);

            // 6. Queue automated WhatsApp and Email notifications
            NotificationLog::create([
                'clinic_id' => $dto->clinicId,
                'appointment_id' => $appointment->id,
                'recipient_phone' => $dto->phone,
                'recipient_email' => $dto->email,
                'channel' => 'whatsapp',
                'template_code' => 'booking_confirmed',
                'message_content' => "Hello {$dto->firstName}, your dental appointment with reference {$appointment->booking_reference} is confirmed for {$dto->appointmentDate} at {$dto->startTime}.",
                'delivery_status' => 'pending',
            ]);

            // 7. Immutable audit logging
            SystemAuditLog::create([
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'user_agent' => request()->userAgent() ?? 'NextJS-BookingClient',
                'action' => 'appointment.booked',
                'auditable_type' => Appointment::class,
                'auditable_id' => $appointment->id,
                'new_values' => [
                    'reference' => $appointment->booking_reference,
                    'date' => $dto->appointmentDate,
                    'time' => $dto->startTime,
                    'patient_id' => $patient->id,
                ],
            ]);

            return $appointment;
        });
    }
}
