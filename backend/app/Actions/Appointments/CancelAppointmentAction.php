<?php

declare(strict_types=1);

namespace App\Actions\Appointments;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\NotificationLog;
use App\Models\SystemAuditLog;
use Illuminate\Support\Facades\DB;

final class CancelAppointmentAction
{
    /**
     * Cancel an appointment with structured reason tracking and notification.
     */
    public function execute(
        Appointment $appointment,
        string $reason,
        bool $cancelledByPatient = true
    ): Appointment {
        return DB::transaction(function () use ($appointment, $reason, $cancelledByPatient): Appointment {
            $newStatus = $cancelledByPatient
                ? AppointmentStatus::CANCELLED_BY_PATIENT
                : AppointmentStatus::CANCELLED_BY_CLINIC;

            $oldStatus = $appointment->status->value;

            $appointment->update([
                'status' => $newStatus,
                'cancellation_reason' => $reason,
            ]);

            // Notify patient
            if ($appointment->patientProfile && $appointment->patientProfile->phone) {
                NotificationLog::create([
                    'clinic_id' => $appointment->clinic_id,
                    'appointment_id' => $appointment->id,
                    'recipient_phone' => $appointment->patientProfile->phone,
                    'recipient_email' => $appointment->patientProfile->email,
                    'channel' => 'whatsapp',
                    'template_code' => 'appointment_cancelled',
                    'message_content' => "Your appointment {$appointment->booking_reference} has been cancelled. Reason: {$reason}",
                    'delivery_status' => 'pending',
                ]);
            }

            // Audit
            SystemAuditLog::create([
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'user_agent' => request()->userAgent() ?? 'System',
                'action' => 'appointment.cancelled',
                'auditable_type' => Appointment::class,
                'auditable_id' => $appointment->id,
                'old_values' => ['status' => $oldStatus],
                'new_values' => ['status' => $newStatus->value, 'reason' => $reason],
            ]);

            return $appointment;
        });
    }
}
