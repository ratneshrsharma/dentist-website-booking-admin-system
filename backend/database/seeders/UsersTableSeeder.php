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
        $hqClinic = Clinic::where('slug', 'smile-care-central-hq')->first();
        $westsideClinic = Clinic::where('slug', 'smile-care-westside-studio')->first();

        // 1. Super Admin (Full Governance)
        User::updateOrCreate(
            ['email' => 'superadmin@dentaflow.io'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::SUPER_ADMIN,
                'first_name' => 'Alexander',
                'last_name' => 'Vance',
                'phone' => '+1 (555) 010-0001',
                'password' => Hash::make('Admin@DentaFlow2026!'),
                'is_active' => true,
            ]
        );

        // 2. Head Clinic Admin (HQ)
        User::updateOrCreate(
            ['email' => 'admin.hq@smilecarecentral.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::ADMIN,
                'first_name' => 'Sarah',
                'last_name' => 'Jenkins',
                'phone' => '+1 (555) 010-0002',
                'password' => Hash::make('Admin@SmileCare2026!'),
                'is_active' => true,
            ]
        );

        // 3. Lead Doctor 1: Dr. Marcus Sterling (Prosthodontics & Oral Surgery)
        $doc1User = User::updateOrCreate(
            ['email' => 'dr.sterling@smilecarecentral.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Marcus',
                'last_name' => 'Sterling',
                'phone' => '+1 (555) 010-0101',
                'password' => Hash::make('Doctor@Sterling2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc1User->id],
            [
                'license_number' => 'DDS-NY-98241',
                'specialization' => 'Prosthodontics & Implant Surgery',
                'qualifications' => 'DDS (Columbia University), FACP (Board Certified Prosthodontist)',
                'years_of_experience' => 16,
                'biography' => 'Dr. Marcus Sterling specializes in full-arch dental implants, bone grafting, and complex restorative smile reconstructions with over 16 years of surgical experience.',
                'consultation_fee' => 150.00,
                'calendar_color_code' => '#0D9488',
                'is_accepting_new_patients' => true,
            ]
        );

        // 4. Lead Doctor 2: Dr. Elena Rostova (Orthodontics & Clear Aligners)
        $doc2User = User::updateOrCreate(
            ['email' => 'dr.rostova@smilecarecentral.com'],
            [
                'clinic_id' => $westsideClinic?->id ?? $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'Elena',
                'last_name' => 'Rostova',
                'phone' => '+1 (555) 010-0102',
                'password' => Hash::make('Doctor@Rostova2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc2User->id],
            [
                'license_number' => 'DMD-NY-77312',
                'specialization' => 'Orthodontics & Dentofacial Orthopedics',
                'qualifications' => 'DMD (Harvard School of Dental Medicine), MS Orthodontics',
                'years_of_experience' => 12,
                'biography' => 'Dr. Elena Rostova is a Diamond Plus Invisalign Provider known for gentle, accelerated orthodontic treatments for children, teens, and adults.',
                'consultation_fee' => 120.00,
                'calendar_color_code' => '#6366F1',
                'is_accepting_new_patients' => true,
            ]
        );

        // 5. Doctor 3: Dr. James Chen (Endodontics & Restorative Care)
        $doc3User = User::updateOrCreate(
            ['email' => 'dr.chen@smilecarecentral.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::DOCTOR,
                'first_name' => 'James',
                'last_name' => 'Chen',
                'phone' => '+1 (555) 010-0103',
                'password' => Hash::make('Doctor@Chen2026!'),
                'is_active' => true,
            ]
        );

        DoctorProfile::updateOrCreate(
            ['user_id' => $doc3User->id],
            [
                'license_number' => 'DDS-NY-61294',
                'specialization' => 'Microscopic Endodontics & Conservative Dentistry',
                'qualifications' => 'DDS (NYU College of Dentistry), Cert. Endodontics',
                'years_of_experience' => 9,
                'biography' => 'Dr. James Chen utilizes high-magnification surgical operating microscopes to perform comfortable, single-visit root canal treatments and natural restorations.',
                'consultation_fee' => 100.00,
                'calendar_color_code' => '#0284C7',
                'is_accepting_new_patients' => true,
            ]
        );

        // 6. Receptionist Staff
        User::updateOrCreate(
            ['email' => 'reception.hq@smilecarecentral.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::RECEPTIONIST,
                'first_name' => 'Emily',
                'last_name' => 'Watson',
                'phone' => '+1 (555) 010-0201',
                'password' => Hash::make('Staff@Watson2026!'),
                'is_active' => true,
            ]
        );

        // 7. Billing Specialist
        User::updateOrCreate(
            ['email' => 'billing.hq@smilecarecentral.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::BILLING,
                'first_name' => 'Robert',
                'last_name' => 'Fox',
                'phone' => '+1 (555) 010-0301',
                'password' => Hash::make('Billing@Fox2026!'),
                'is_active' => true,
            ]
        );

        // 8. Sample Registered Patient Profile
        $patientUser = User::updateOrCreate(
            ['email' => 'patient.smith@example.com'],
            [
                'clinic_id' => $hqClinic?->id,
                'role' => UserRole::PATIENT,
                'first_name' => 'David',
                'last_name' => 'Smith',
                'phone' => '+1 (555) 948-2201',
                'password' => Hash::make('Patient@Smith2026!'),
                'is_active' => true,
            ]
        );

        PatientProfile::updateOrCreate(
            ['medical_record_number' => 'MRN-2026-0001'],
            [
                'user_id' => $patientUser->id,
                'primary_clinic_id' => $hqClinic?->id,
                'first_name' => 'David',
                'last_name' => 'Smith',
                'gender' => 'male',
                'date_of_birth' => '1988-04-14',
                'blood_group' => 'O+',
                'phone' => '+1 (555) 948-2201',
                'email' => 'patient.smith@example.com',
                'emergency_contact_name' => 'Laura Smith',
                'emergency_contact_phone' => '+1 (555) 948-2209',
                'allergies' => 'Penicillin (mild cutaneous rash)',
                'systemic_conditions' => 'Mild hypertension (well managed with ACE inhibitor)',
                'ongoing_medications' => 'Lisinopril 10mg daily',
                'insurance_provider' => 'Delta Dental Premier',
                'insurance_policy_number' => 'DD-981240-84',
            ]
        );
    }
}
