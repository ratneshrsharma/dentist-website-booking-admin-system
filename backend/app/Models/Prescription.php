<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $prescription_code
 * @property int $patient_profile_id
 * @property int $doctor_profile_id
 * @property int $clinic_id
 * @property int|null $appointment_id
 * @property string $diagnosis_notes
 * @property string|null $doctor_advice
 * @property string $issued_date
 */
final class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    protected $fillable = [
        'prescription_code',
        'patient_profile_id',
        'doctor_profile_id',
        'clinic_id',
        'appointment_id',
        'diagnosis_notes',
        'doctor_advice',
        'issued_date',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issued_date' => 'date:Y-m-d',
        ];
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }
}
