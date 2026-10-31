<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

final class ClinicsTableSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = [
            [
                'name' => 'Advanced Dental Practice (Central Branch)',
                'slug' => 'advanced-dental-central',
                'branch_code' => 'ADC-001',
                'tagline' => 'Comprehensive Multi-Specialty Dental Center & Restorations',
                'address_line1' => 'Suite 400, Sample Medical Plaza, 500 Healthcare Blvd',
                'city' => 'Metropolis',
                'state_province' => 'NY',
                'postal_code' => '10001',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 019-2830',
                'secondary_phone' => '+1 (555) 019-2831',
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'central@example.com',
                'timezone' => 'America/New_York',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'total_dental_chairs' => 8,
                'operating_hours' => [
                    'monday' => ['open' => '08:00', 'close' => '19:00'],
                    'tuesday' => ['open' => '08:00', 'close' => '19:00'],
                    'wednesday' => ['open' => '08:00', 'close' => '19:00'],
                    'thursday' => ['open' => '08:00', 'close' => '19:00'],
                    'friday' => ['open' => '08:00', 'close' => '18:00'],
                    'saturday' => ['open' => '09:00', 'close' => '15:00'],
                    'sunday' => ['open' => null, 'close' => null, 'closed' => true],
                ],
                'is_headquarters' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Advanced Dental Studio (Westside)',
                'slug' => 'advanced-dental-westside',
                'branch_code' => 'ADC-002',
                'tagline' => 'Cosmetic Smile Care & Orthodontic Studio',
                'address_line1' => '720 Sunset Boulevard, Suite 150',
                'city' => 'Metropolis',
                'state_province' => 'NY',
                'postal_code' => '10024',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 024-5820',
                'secondary_phone' => null,
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'westside@example.com',
                'timezone' => 'America/New_York',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'total_dental_chairs' => 4,
                'operating_hours' => [
                    'monday' => ['open' => '09:00', 'close' => '18:00'],
                    'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                    'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                    'thursday' => ['open' => '09:00', 'close' => '18:00'],
                    'friday' => ['open' => '09:00', 'close' => '17:00'],
                    'saturday' => ['open' => '09:00', 'close' => '14:00'],
                    'sunday' => ['open' => null, 'close' => null, 'closed' => true],
                ],
                'is_headquarters' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Advanced Dental Family Care (Eastside)',
                'slug' => 'advanced-dental-eastside',
                'branch_code' => 'ADC-003',
                'tagline' => 'Family Dental Wellness & Preventative Care',
                'address_line1' => '1440 Sample Avenue, Building B',
                'city' => 'Metropolis',
                'state_province' => 'NY',
                'postal_code' => '10128',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 038-7711',
                'secondary_phone' => null,
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'eastside@example.com',
                'timezone' => 'America/New_York',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'total_dental_chairs' => 5,
                'operating_hours' => [
                    'monday' => ['open' => '08:30', 'close' => '18:30'],
                    'tuesday' => ['open' => '08:30', 'close' => '18:30'],
                    'wednesday' => ['open' => '08:30', 'close' => '18:30'],
                    'thursday' => ['open' => '08:30', 'close' => '18:30'],
                    'friday' => ['open' => '08:30', 'close' => '17:30'],
                    'saturday' => ['open' => '09:00', 'close' => '13:00'],
                    'sunday' => ['open' => null, 'close' => null, 'closed' => true],
                ],
                'is_headquarters' => false,
                'is_active' => true,
            ],
        ];

        foreach ($clinics as $clinicData) {
            Clinic::updateOrCreate(['slug' => $clinicData['slug']], $clinicData);
        }
    }
}
