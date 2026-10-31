<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Clinic;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $hqClinic = Clinic::where('slug', 'advanced-dental-central')->first();
        $westsideClinic = Clinic::where('slug', 'advanced-dental-westside')->first();

        // 1. Super Admin (Full Governance)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::SUPER_ADMIN,
                'first_name' => 'Demo',
                'last_name' => 'Administrator',
                'phone' => '+1 (555) 010-0001',
                'password' => Hash::make('Admin@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        // 2. Head Clinic Admin (HQ)
        User::updateOrCreate(
            ['email' => 'clinic.admin@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::ADMIN,
                'first_name' => 'Sarah',
                'last_name' => 'Jenkins',
                'phone' => '+1 (555) 010-0002',
                'password' => Hash::make('Admin@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        // 3. Lead Doctor 1: Dr. Alex Morgan (Prosthodontics & Restorations)
        $doc1User = User::updateOrCreate(
            ['email' => 'dr.morgan@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Alex',
                'last_name' => 'Morgan',
                'phone' => '+1 (555) 010-0101',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc1User->id],
            [
                'license_number' => 'DDS-DEMO-98241',
                'specialization' => 'Prosthodontics & Implant Surgery',
                'qualifications' => 'DDS, Board Certified Prosthodontist',
                'years_of_experience' => 16,
                'biography' => 'Dr. Alex Morgan specializes in dental implants, bone grafting, and complex restorative smile reconstructions with over 16 years of clinical experience.',
                'consultation_fee' => 150.00,
                'calendar_color_code' => '#0D9488',
                'is_accepting_new_patients' => true,
            ]
        );

        // 4. Lead Doctor 2: Dr. Sarah Jenkins (Orthodontics & Clear Aligners)
        $doc2User = User::updateOrCreate(
            ['email' => 'dr.jenkins@example.com'],
            [
                'clinic_id' => $westsideClinic?->id ?? $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Sarah',
                'last_name' => 'Jenkins',
                'phone' => '+1 (555) 010-0102',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc2User->id],
            [
                'license_number' => 'DMD-DEMO-77312',
                'specialization' => 'Orthodontics & Clear Aligners',
                'qualifications' => 'DMD, MS Orthodontics',
                'years_of_experience' => 12,
                'biography' => 'Dr. Sarah Jenkins is an experienced clear aligner provider known for gentle, accelerated orthodontic treatments for children, teens, and adults.',
                'consultation_fee' => 120.00,
                'calendar_color_code' => '#6366F1',
                'is_accepting_new_patients' => true,
            ]
        );

        // 5. Doctor 3: Dr. David Kim (Endodontics & Restorative Care)
        $doc3User = User::updateOrCreate(
            ['email' => 'dr.kim@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'David',
                'last_name' => 'Kim',
                'phone' => '+1 (555) 010-0103',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc3User->id],
            [
                'license_number' => 'DDS-DEMO-61294',
                'specialization' => 'Microscopic Endodontics & Conservative Dentistry',
                'qualifications' => 'DDS, Cert. Endodontics',
                'years_of_experience' => 9,
                'biography' => 'Dr. David Kim utilizes high-magnification surgical operating microscopes to perform comfortable, single-visit root canal treatments and natural restorations.',
                'consultation_fee' => 100.00,
                'calendar_color_code' => '#0284C7',
                'is_accepting_new_patients' => true,
            ]
        );

        // 6. Receptionist Staff
        User::updateOrCreate(
            ['email' => 'reception@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::RECEPTIONIST,
                'first_name' => 'Emily',
                'last_name' => 'Watson',
                'phone' => '+1 (555) 010-0201',
                'password' => Hash::make('Staff@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        // 7. Billing Specialist
        User::updateOrCreate(
            ['email' => 'billing@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::BILLING,
                'first_name' => 'Robert',
                'last_name' => 'Fox',
                'phone' => '+1 (555) 010-0301',
                'password' => Hash::make('Billing@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        // 8. Sample Registered Patient Profile
        $patientUser = User::updateOrCreate(
            ['email' => 'patient@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::PATIENT,
                'first_name' => 'David',
                'last_name' => 'Sample',
                'phone' => '+1 (555) 019-2830',
                'password' => Hash::make('Patient@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        PatientProfile::updateOrCreate(
            ['medical_record_number' => 'MRN-2026-0001'],
            [
                'user_id' => $patientUser->id,
                'primary_clinic_id' => $hqClinic?->id,
                'first_name' => 'David',
                'last_name' => 'Sample',
                'gender' => 'male',
                'date_of_birth' => '1988-04-14',
                'blood_group' => 'O+',
                'phone' => '+1 (555) 019-2830',
                'email' => 'patient@example.com',
                'emergency_contact_name' => 'Laura Sample',
                'emergency_contact_phone' => '+1 (555) 019-2831',
                'allergies' => 'Penicillin (mild cutaneous rash)',
                'systemic_conditions' => 'Mild hypertension (well managed)',
                'ongoing_medications' => 'Prescription maintenance',
                'insurance_provider' => 'Dental Care Network',
                'insurance_policy_number' => 'POL-981240-84',
            ]
        );
    }
}
