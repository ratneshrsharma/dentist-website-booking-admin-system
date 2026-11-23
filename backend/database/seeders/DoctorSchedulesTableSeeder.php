<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

final class DoctorSchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $hqClinic = Clinic::where('slug', 'advanced-dental-central')->first();
        $westsideClinic = Clinic::where('slug', 'advanced-dental-westside')->first();

        if (! $hqClinic) {
            return;
        }

        $doctors = DoctorProfile::all();

        foreach ($doctors as $doctor) {
            // Monday through Friday (1 to 5)
            for ($day = 1; $day <= 5; $day++) {
                DoctorSchedule::updateOrCreate(
                    [
                        'doctor_profile_id' => $doctor->id,
                        'clinic_id' => $hqClinic->id,
                        'day_of_week' => $day,
                    ],
                    [
                        'shift_start_time' => '09:00:00',
                        'shift_end_time' => '17:00:00',
                        'slot_duration_minutes' => 30,
                        'max_parallel_chairs' => 1,
                        'is_available' => true,
                    ]
                );
            }

            // Saturday morning shift (6)
            DoctorSchedule::updateOrCreate(
                [
                    'doctor_profile_id' => $doctor->id,
                    'clinic_id' => $westsideClinic?->id ?? $hqClinic->id,
                    'day_of_week' => 6,
                ],
                [
                    'shift_start_time' => '09:30:00',
                    'shift_end_time' => '14:00:00',
                    'slot_duration_minutes' => 30,
                    'max_parallel_chairs' => 1,
                    'is_available' => true,
                ]
            );
        }
    }
}
