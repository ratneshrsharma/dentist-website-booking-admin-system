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
                'last_name' => 'Miller',
                'phone' => '+1 (555) 010-0002',
                'password' => Hash::make('Admin@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        // 3. Lead Doctor 1: Dr. Ethan Caldwell (Prosthodontics & Guided Implant Surgery)
        $doc1User = User::updateOrCreate(
            ['email' => 'dr.caldwell@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Ethan',
                'last_name' => 'Caldwell',
                'phone' => '+1 (555) 010-0101',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc1User->id],
            [
                'license_number' => 'DDS-DEMO-00101',
                'specialization' => 'Prosthodontics & Guided Implant Surgery',
                'qualifications' => 'DDS, Board Certified Prosthodontist',
                'years_of_experience' => 16,
                'biography' => 'Dr. Ethan Caldwell specializes in computer-guided dental implants, bone regeneration, and full-mouth aesthetic smile reconstructions with 16+ years of clinical mastery.',
                'consultation_fee' => 150.00,
                'calendar_color_code' => '#0D9488',
                'is_accepting_new_patients' => true,
            ]
        );

        // 4. Lead Doctor 2: Dr. Maya Lin (Orthodontics & Clear Aligners)
        $doc2User = User::updateOrCreate(
            ['email' => 'dr.lin@example.com'],
            [
                'clinic_id' => $westsideClinic?->id ?? $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Maya',
                'last_name' => 'Lin',
                'phone' => '+1 (555) 010-0102',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc2User->id],
            [
                'license_number' => 'DMD-DEMO-00202',
                'specialization' => 'Orthodontics & Clear Aligners',
                'qualifications' => 'DMD, MS Orthodontics',
                'years_of_experience' => 12,
                'biography' => 'Dr. Maya Lin is a premier clear aligner provider specializing in digital 3D orthodontic planning, accelerated tooth alignment, and bite correction for teens and adults.',
                'consultation_fee' => 120.00,
                'calendar_color_code' => '#6366F1',
                'is_accepting_new_patients' => true,
            ]
        );

        // 5. Doctor 3: Dr. Marcus Vance (Microscopic Endodontics & Root Canal Care)
        $doc3User = User::updateOrCreate(
            ['email' => 'dr.vance@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Marcus',
                'last_name' => 'Vance',
                'phone' => '+1 (555) 010-0103',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc3User->id],
            [
                'license_number' => 'DDS-DEMO-00303',
                'specialization' => 'Microscopic Endodontics & Conservative Restorations',
                'qualifications' => 'DDS, Certified Specialist in Endodontics',
                'years_of_experience' => 10,
                'biography' => 'Dr. Marcus Vance utilizes high-magnification surgical operating microscopes to deliver gentle, single-visit root canal treatments, trauma rehabilitation, and natural tooth preservation.',
                'consultation_fee' => 100.00,
                'calendar_color_code' => '#0284C7',
                'is_accepting_new_patients' => true,
            ]
        );

        // 5b. Doctor 4: Dr. Olivia Harper (Pediatric Dentistry & Family Dental Wellness)
        $doc4User = User::updateOrCreate(
            ['email' => 'dr.harper@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Olivia',
                'last_name' => 'Harper',
                'phone' => '+1 (555) 010-0104',
                'password' => Hash::make('Doctor@DemoPass2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc4User->id],
            [
                'license_number' => 'DDS-DEMO-00404',
                'specialization' => 'Pediatric Dentistry & Family Dental Wellness',
                'qualifications' => 'DDS, Certificate in Pediatric Dentistry',
                'years_of_experience' => 8,
                'biography' => 'Dr. Olivia Harper is dedicated to calm, positive dental visits for young children and teens, specializing in pain-free preventative fluoride therapies, fissure sealants, and gentle care.',
                'consultation_fee' => 90.00,
                'calendar_color_code' => '#EC4899',
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
