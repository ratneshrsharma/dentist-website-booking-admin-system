<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property int|null $clinic_id
 * @property UserRole $role
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string|null $avatar_url
 * @property bool $is_active
 */
final class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'clinic_id',
        'role',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'avatar_url',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'is_active' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function doctorProfile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    public function patientProfile(): HasOne
    {
        return $this->hasOne(PatientProfile::class, 'user_id');
    }
}
