<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string|null $detailed_description
 * @property int $standard_duration_minutes
 * @property float $base_cost
 * @property bool $requires_xray
 * @property bool $is_active
 */
final class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'detailed_description',
        'standard_duration_minutes',
        'base_cost',
        'requires_xray',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'standard_duration_minutes' => 'integer',
            'base_cost' => 'float',
            'requires_xray' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function cmsDetails(): HasOne
    {
        return $this->hasOne(CmsService::class, 'service_id');
    }
}
