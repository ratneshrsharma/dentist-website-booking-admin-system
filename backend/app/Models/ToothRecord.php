<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ToothCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $dental_chart_id
 * @property int $tooth_number 1 to 32 (Universal System)
 * @property ToothCondition $condition_code
 * @property array<string>|null $affected_surfaces
 * @property array<int>|null $periodontal_pocket_depths
 * @property string|null $clinical_remarks
 */
final class ToothRecord extends Model
{
    use HasFactory;

    protected $table = 'tooth_records';

    protected $fillable = [
        'dental_chart_id',
        'tooth_number',
        'condition_code',
        'affected_surfaces',
        'periodontal_pocket_depths',
        'clinical_remarks',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tooth_number' => 'integer',
            'condition_code' => ToothCondition::class,
            'affected_surfaces' => 'array',
            'periodontal_pocket_depths' => 'array',
        ];
    }

    public function dentalChart(): BelongsTo
    {
        return $this->belongsTo(DentalChart::class, 'dental_chart_id');
    }
}
