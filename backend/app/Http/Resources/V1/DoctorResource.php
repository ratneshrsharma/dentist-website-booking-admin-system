<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DoctorProfile
 */
final class DoctorResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => 'Dr. ' . ($this->user ? $this->user->first_name . ' ' . $this->user->last_name : 'Dental Specialist'),
            'license_number' => $this->license_number,
            'specialization' => $this->specialization,
            'qualifications' => $this->qualifications,
            'years_of_experience' => $this->years_of_experience,
            'biography' => $this->biography,
            'consultation_fee' => (float) $this->consultation_fee,
            'calendar_color' => $this->calendar_color_code,
            'is_accepting_new_patients' => $this->is_accepting_new_patients,
            'avatar_url' => $this->user?->avatar_url,
        ];
    }
}
