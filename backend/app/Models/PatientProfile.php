<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int $primary_clinic_id
 * @property string $medical_record_number
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $date_of_birth
 * @property string $blood_group
 * @property string $phone
 * @property string|null $email
 * @property string|null $allergies
 * @property string|null $systemic_conditions
 * @property string|null $ongoing_medications
 */
final class PatientProfile extends Model
{
    use HasFactory;

    protected $table = 'patient_profiles';

    protected $fillable = [
        'user_id',
        'primary_clinic_id',
        'medical_record_number',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'blood_group',
        'phone',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergies',
        'systemic_conditions',
        'ongoing_medications',
        'insurance_provider',
        'insurance_policy_number',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date:Y-m-d',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function primaryClinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'primary_clinic_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_profile_id');
    }

    public function dentalCharts(): HasMany
    {
        return $this->hasMany(DentalChart::class, 'patient_profile_id');
    }

    public function treatmentPlans(): HasMany
    {
        return $this->hasMany(TreatmentPlan::class, 'patient_profile_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'patient_profile_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'patient_profile_id');
    }
}
