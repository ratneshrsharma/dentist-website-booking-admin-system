<?php

declare(strict_types=1);

namespace App\Actions\Appointments;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\NotificationLog;
use App\Models\SystemAuditLog;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class RescheduleAppointmentAction
{
    public function __construct(
        private readonly BookingAvailabilityService $availabilityService
    ) {}

    /**
     * Reschedule an existing appointment to a new date and time slot.
     */
    public function execute(Appointment $appointment, string $newDate, string $newStartTime, ?string $reason = null): Appointment
    {
        return DB::transaction(function () use ($appointment, $newDate, $newStartTime, $reason): Appointment {
            // Check availability of new slot
            $availableSlots = $this->availabilityService->getAvailableSlots(
                $appointment->clinic_id,
                $appointment->doctor_profile_id,
                $appointment->service_id,
                $newDate
            );

            $selectedSlot = null;
            foreach ($availableSlots as $slot) {
                if ($slot['time'] === $newStartTime && $slot['available']) {
                    $selectedSlot = $slot;
                    break;
                }
            }

            if (! $selectedSlot) {
                throw new RuntimeException("Target slot {$newStartTime} on {$newDate} is unavailable.");
            }

            $serviceDuration = $appointment->service->standard_duration_minutes ?? 30;
            $start = Carbon::parse($newDate . ' ' . $newStartTime);
            $end = $start->copy()->addMinutes($serviceDuration);

            $oldValues = [
                'date' => $appointment->appointment_date,
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'status' => $appointment->status->value,
            ];

            $appointment->update([
                'appointment_date' => $newDate,
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'status' => AppointmentStatus::RESCHEDULED,
                'internal_staff_notes' => trim(($appointment->internal_staff_notes ?? '') . "\n[Rescheduled]: " . ($reason ?? 'Patient requested')),
            ]);

            // Notification
            if ($appointment->patientProfile && $appointment->patientProfile->phone) {
                NotificationLog::create([
                    'clinic_id' => $appointment->clinic_id,
                    'appointment_id' => $appointment->id,
                    'recipient_phone' => $appointment->patientProfile->phone,
                    'recipient_email' => $appointment->patientProfile->email,
                    'channel' => 'whatsapp',
                    'template_code' => 'appointment_rescheduled',
                    'message_content' => "Your appointment {$appointment->booking_reference} has been rescheduled to {$newDate} at {$newStartTime}.",
                    'delivery_status' => 'pending',
                ]);
            }

            // Audit
            SystemAuditLog::create([
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'user_agent' => request()->userAgent() ?? 'ClinicAdmin',
                'action' => 'appointment.rescheduled',
                'auditable_type' => Appointment::class,
                'auditable_id' => $appointment->id,
                'old_values' => $oldValues,
                'new_values' => [
                    'date' => $newDate,
                    'start_time' => $newStartTime,
                    'reason' => $reason,
                ],
            ]);

            return $appointment;
        });
    }
}
