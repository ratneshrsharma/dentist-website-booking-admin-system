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
                'name' => 'Advanced Dental Clinic (Central Practice)',
                'slug' => 'advanced-dental-central',
                'branch_code' => 'ADC-001',
                'tagline' => 'Comprehensive Multi-Specialty Dental Center & Restorations',
                'address_line1' => '100 Healthcare Boulevard, Suite 400',
                'city' => 'Austin',
                'state_province' => 'TX',
                'postal_code' => '78701',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 019-2830',
                'secondary_phone' => '+1 (555) 019-2831',
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'central@advanceddental-demo.com',
                'timezone' => 'America/Chicago',
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
                'name' => 'Advanced Dental Clinic (Westside Studio)',
                'slug' => 'advanced-dental-westside',
                'branch_code' => 'ADC-002',
                'tagline' => 'Cosmetic Smile Makeover & Orthodontic Studio',
                'address_line1' => '500 Medical Center Parkway, Suite 250',
                'city' => 'Denver',
                'state_province' => 'CO',
                'postal_code' => '80202',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 024-5820',
                'secondary_phone' => null,
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'westside@advanceddental-demo.com',
                'timezone' => 'America/Denver',
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
                'name' => 'Advanced Dental Clinic (Northside Family)',
                'slug' => 'advanced-dental-eastside',
                'branch_code' => 'ADC-003',
                'tagline' => 'Family Dental Wellness & Preventative Care',
                'address_line1' => '750 Wellness Way, Building B',
                'city' => 'Charlotte',
                'state_province' => 'NC',
                'postal_code' => '28202',
                'country_code' => 'US',
                'primary_phone' => '+1 (555) 038-7711',
                'secondary_phone' => null,
                'emergency_phone' => '+1 (555) 019-2830',
                'primary_email' => 'northside@advanceddental-demo.com',
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
