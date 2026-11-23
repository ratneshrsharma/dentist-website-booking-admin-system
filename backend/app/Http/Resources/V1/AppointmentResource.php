<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Appointment
 */
final class AppointmentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'booking_reference' => $this->booking_reference,
            'clinic' => [
                'id' => $this->clinic_id,
                'name' => $this->clinic?->name,
                'phone' => $this->clinic?->primary_phone,
            ],
            'doctor' => [
                'id' => $this->doctor_profile_id,
                'name' => $this->doctorProfile && $this->doctorProfile->user
                    ? 'Dr. ' . $this->doctorProfile->user->first_name . ' ' . $this->doctorProfile->user->last_name
                    : null,
                'specialization' => $this->doctorProfile?->specialization,
            ],
            'service' => [
                'id' => $this->service_id,
                'name' => $this->service?->name,
                'duration_minutes' => $this->service?->standard_duration_minutes,
                'cost' => (float) ($this->service?->base_cost ?? 0),
            ],
            'schedule' => [
                'date' => $this->appointment_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ],
            'status' => $this->status->value,
            'patient' => [
                'first_name' => $this->patientProfile?->first_name,
                'last_name' => $this->patientProfile?->last_name,
                'phone' => $this->patientProfile?->phone,
                'email' => $this->patientProfile?->email,
            ],
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
