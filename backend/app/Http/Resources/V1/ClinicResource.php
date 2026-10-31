<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Clinic
 */
final class ClinicResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'branch_code' => $this->branch_code,
            'tagline' => $this->tagline,
            'address' => [
                'line1' => $this->address_line1,
                'city' => $this->city,
                'state' => $this->state_province,
                'postal_code' => $this->postal_code,
                'country' => $this->country_code,
            ],
            'contact' => [
                'phone' => $this->primary_phone,
                'emergency_phone' => $this->emergency_phone,
                'email' => $this->primary_email,
            ],
            'currency' => [
                'code' => $this->currency_code,
                'symbol' => $this->currency_symbol,
            ],
            'total_chairs' => $this->total_dental_chairs,
            'operating_hours' => $this->operating_hours,
            'is_headquarters' => $this->is_headquarters,
        ];
    }
}
