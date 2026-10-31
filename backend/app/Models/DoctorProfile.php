<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $license_number
 * @property string $specialization
 * @property string $qualifications
 * @property int $years_of_experience
 * @property string|null $biography
 * @property float $consultation_fee
 * @property string $calendar_color_code
 * @property bool $is_accepting_new_patients
 */
final class DoctorProfile extends Model
{
    use HasFactory;

    protected $table = 'doctor_profiles';

    protected $fillable = [
        'user_id',
        'license_number',
        'specialization',
        'qualifications',
        'years_of_experience',
        'biography',
        'consultation_fee',
        'calendar_color_code',
        'is_accepting_new_patients',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'years_of_experience' => 'integer',
            'consultation_fee' => 'float',
            'is_accepting_new_patients' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_profile_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_profile_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'doctor_services', 'doctor_profile_id', 'service_id')
            ->withPivot('custom_fee');
    }
}
