<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Service
 */
final class ServiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category_name' => $this->category?->name,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'detailed_description' => $this->detailed_description,
            'duration_minutes' => $this->standard_duration_minutes,
            'base_cost' => (float) $this->base_cost,
            'requires_xray' => $this->requires_xray,
        ];
    }
}
