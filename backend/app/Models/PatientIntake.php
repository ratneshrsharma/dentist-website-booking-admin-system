<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $appointment_id
 * @property int $patient_profile_id
 * @property string $chief_complaint
 * @property int $pain_level_1_to_10
 * @property string $last_dental_visit_interval
 * @property bool $is_experiencing_sensitivity
 * @property bool $has_bleeding_gums
 * @property bool $has_jaw_clicking_or_pain
 * @property bool $is_pregnant_or_nursing
 * @property bool $has_pacemaker_or_heart_valve
 * @property string $digital_signature_hash
 * @property string $consent_acknowledged_at
 */
final class PatientIntake extends Model
{
    use HasFactory;

    protected $table = 'patient_intakes';

    protected $fillable = [
        'appointment_id',
        'patient_profile_id',
        'chief_complaint',
        'pain_level_1_to_10',
        'last_dental_visit_interval',
        'is_experiencing_sensitivity',
        'has_bleeding_gums',
        'has_jaw_clicking_or_pain',
        'is_pregnant_or_nursing',
        'has_pacemaker_or_heart_valve',
        'digital_signature_hash',
        'consent_acknowledged_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pain_level_1_to_10' => 'integer',
            'is_experiencing_sensitivity' => 'boolean',
            'has_bleeding_gums' => 'boolean',
            'has_jaw_clicking_or_pain' => 'boolean',
            'is_pregnant_or_nursing' => 'boolean',
            'has_pacemaker_or_heart_valve' => 'boolean',
            'consent_acknowledged_at' => 'datetime',
        ];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }
}
