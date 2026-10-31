<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $doctor_profile_id
 * @property int $clinic_id
 * @property int $day_of_week 0 (Sunday) to 6 (Saturday)
 * @property string $shift_start_time
 * @property string $shift_end_time
 * @property int $slot_duration_minutes
 * @property int $max_parallel_chairs
 * @property bool $is_available
 */
final class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_profile_id',
        'clinic_id',
        'day_of_week',
        'shift_start_time',
        'shift_end_time',
        'slot_duration_minutes',
        'max_parallel_chairs',
        'is_available',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'slot_duration_minutes' => 'integer',
            'max_parallel_chairs' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
