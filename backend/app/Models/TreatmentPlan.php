<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $plan_code
 * @property int $patient_profile_id
 * @property int $clinic_id
 * @property int $doctor_profile_id
 * @property string $title
 * @property string $diagnosis_summary
 * @property string $status draft, presented, accepted, in_progress, completed, declined
 * @property float $total_estimated_amount
 * @property string|null $accepted_at
 */
final class TreatmentPlan extends Model
{
    use HasFactory;

    protected $table = 'treatment_plans';

    protected $fillable = [
        'plan_code',
        'patient_profile_id',
        'clinic_id',
        'doctor_profile_id',
        'title',
        'diagnosis_summary',
        'status',
        'total_estimated_amount',
        'accepted_at',
        'patient_signature_hash',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_estimated_amount' => 'float',
            'accepted_at' => 'datetime',
        ];
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
    }

    public function procedures(): HasMany
    {
        return $this->hasMany(TreatmentProcedure::class, 'treatment_plan_id')->orderBy('sequence_order');
    }
}
