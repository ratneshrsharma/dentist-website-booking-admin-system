<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string $phone
 * @property string $email
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string $timezone
 * @property bool $is_headquarters
 * @property bool $is_active
 */
final class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinics';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'phone',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'timezone',
        'is_headquarters',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_headquarters' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'clinic_id');
    }

    public function doctorSchedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'clinic_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'clinic_id');
    }

    public function patientProfiles(): HasMany
    {
        return $this->hasMany(PatientProfile::class, 'primary_clinic_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ClinicStock::class, 'clinic_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'clinic_id');
    }
}
