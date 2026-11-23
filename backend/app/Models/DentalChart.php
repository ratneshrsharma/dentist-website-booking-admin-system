<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $patient_profile_id
 * @property int $clinic_id
 * @property int $examined_by_doctor_id
 * @property string $chart_system
 * @property string $chart_date
 * @property string|null $clinical_notes
 */
final class DentalChart extends Model
{
    use HasFactory;

    protected $table = 'dental_charts';

    protected $fillable = [
        'patient_profile_id',
        'clinic_id',
        'examined_by_doctor_id',
        'chart_system',
        'chart_date',
        'clinical_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'chart_date' => 'date:Y-m-d',
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

    public function examinedByDoctor(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'examined_by_doctor_id');
    }

    public function toothRecords(): HasMany
    {
        return $this->hasMany(ToothRecord::class, 'dental_chart_id');
    }
}
