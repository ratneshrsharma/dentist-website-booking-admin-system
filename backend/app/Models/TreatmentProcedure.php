<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $treatment_plan_id
 * @property int $service_id
 * @property int|null $tooth_number
 * @property int $phase_number
 * @property int $sequence_order
 * @property float $estimated_cost
 * @property float|null $actual_cost
 * @property string $status planned, scheduled, in_progress, completed, cancelled
 */
final class TreatmentProcedure extends Model
{
    use HasFactory;

    protected $table = 'treatment_procedures';

    protected $fillable = [
        'treatment_plan_id',
        'service_id',
        'tooth_number',
        'phase_number',
        'sequence_order',
        'estimated_cost',
        'actual_cost',
        'status',
        'linked_appointment_id',
        'completed_at',
        'completed_by_doctor_id',
        'clinical_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tooth_number' => 'integer',
            'phase_number' => 'integer',
            'sequence_order' => 'integer',
            'estimated_cost' => 'float',
            'actual_cost' => 'float',
            'completed_at' => 'datetime',
        ];
    }

    public function treatmentPlan(): BelongsTo
    {
        return $this->belongsTo(TreatmentPlan::class, 'treatment_plan_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'linked_appointment_id');
    }
}
