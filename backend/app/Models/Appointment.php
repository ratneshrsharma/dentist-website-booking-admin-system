<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $booking_reference
 * @property int $clinic_id
 * @property int $doctor_profile_id
 * @property int $patient_profile_id
 * @property int $service_id
 * @property string $appointment_date
 * @property string $start_time
 * @property string $end_time
 * @property AppointmentStatus $status
 * @property string $booking_channel
 * @property string|null $patient_notes
 * @property string|null $internal_staff_notes
 */
final class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'booking_reference',
        'clinic_id',
        'doctor_profile_id',
        'patient_profile_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'cancellation_reason',
        'booking_channel',
        'patient_notes',
        'internal_staff_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => AppointmentStatus::class,
            'appointment_date' => 'date:Y-m-d',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function intake(): HasOne
    {
        return $this->hasOne(PatientIntake::class, 'appointment_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PatientDocument::class, 'appointment_id');
    }
}
