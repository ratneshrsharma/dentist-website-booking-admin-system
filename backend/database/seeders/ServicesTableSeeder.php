<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DoctorProfile;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

final class ServicesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Preventive & Diagnostic Dentistry',
                'slug' => 'preventive-diagnostic',
                'description' => 'Comprehensive clinical oral evaluations, digital low-radiation radiography, periodontal probing, and ultrasonic biofilm prophylaxis.',
                'icon_name' => 'ShieldCheck',
                'sort_order' => 1,
                'services' => [
                    [
                        'name' => 'Comprehensive Oral Exam & Cancer Screening',
                        'slug' => 'comprehensive-oral-exam',
                        'short_description' => 'Full dental chart inspection, digital intraoral camera tour, and Velscope soft-tissue screening.',
                        'detailed_description' => 'A thorough 45-minute dental wellness consultation covering 32 teeth, existing restorations, periodontal pocket probing, and head/neck lymphatic screening.',
                        'standard_duration_minutes' => 45,
                        'base_cost' => 95.00,
                        'requires_xray' => true,
                    ],
                    [
                        'name' => 'Ultrasonic Teeth Cleaning & Polishing (Prophylaxis)',
                        'slug' => 'ultrasonic-teeth-cleaning',
                        'short_description' => 'Gentle piezo ultrasonic scaling to eliminate calculus and bacterial biofilm.',
                        'detailed_description' => 'Deep hygienic cleaning with ultrasonic cavitation removing stubborn tartar, followed by diamond paste polishing and remineralizing fluoride therapy.',
                        'standard_duration_minutes' => 45,
                        'base_cost' => 120.00,
                        'requires_xray' => false,
                    ],
                    [
                        'name' => 'Digital Panoramic OPG & 3D CBCT Scan',
                        'slug' => 'panoramic-xray-cbct',
                        'short_description' => 'High-resolution full-arch scan providing sub-millimeter diagnostic precision.',
                        'detailed_description' => 'Ultra-low radiation 3D cone-beam computed tomography revealing bone density, nerve canals, and impacted wisdom teeth positions.',
                        'standard_duration_minutes' => 20,
                        'base_cost' => 150.00,
                        'requires_xray' => false,
                    ],
                ],
            ],
            [
                'name' => 'Cosmetic Smile Makeover',
                'slug' => 'cosmetic-dentistry',
                'description' => 'Porcelain ceramic veneers, laser teeth whitening, composite bonding, and digital smile design.',
                'icon_name' => 'Sparkles',
                'sort_order' => 2,
                'services' => [
                    [
                        'name' => 'In-Clinic Laser Teeth Whitening (Zoom 4)',
                        'slug' => 'laser-teeth-whitening',
                        'short_description' => 'Brighten teeth by up to 8 shades in a single comfortable 60-minute session.',
                        'detailed_description' => 'Medical-grade hydrogen peroxide gel activated with cold LED light. Includes desensitizing calcium phosphate treatment and take-home touch-up kit.',
                        'standard_duration_minutes' => 60,
                        'base_cost' => 399.00,
                        'requires_xray' => false,
                    ],
                    [
                        'name' => 'Handcrafted Porcelain Ceramic Veneer',
                        'slug' => 'porcelain-ceramic-veneer',
                        'short_description' => 'Ultra-thin custom porcelain facing designed to correct chips, gaps, and severe discoloration.',
                        'detailed_description' => 'Feldspathic or E-max lithium disilicate ceramic veneers tailored to your facial geometry and tooth shade preferences.',
                        'standard_duration_minutes' => 90,
                        'base_cost' => 950.00,
                        'requires_xray' => true,
                    ],
                ],
            ],
            [
                'name' => 'Orthodontics & Clear Aligners',
                'slug' => 'orthodontics',
                'description' => 'Invisalign clear aligners, ceramic clear braces, and dentofacial interceptive alignment.',
                'icon_name' => 'Smile',
                'sort_order' => 3,
                'services' => [
                    [
                        'name' => 'Invisalign Clear Aligner Consultation & 3D Simulation',
                        'slug' => 'invisalign-consultation',
                        'short_description' => 'iTero digital scan generating an immediate 3D simulation of your aligned smile.',
                        'detailed_description' => 'Includes digital optical impression, bite analysis, treatment duration timeline, and personalized aligner treatment plan.',
                        'standard_duration_minutes' => 45,
                        'base_cost' => 120.00,
                        'requires_xray' => true,
                    ],
                ],
            ],
            [
                'name' => 'Dental Implants & Restorative Surgery',
                'slug' => 'dental-implants',
                'description' => 'Permanent titanium implant placement, sinus lifts, bone grafting, and immediate load crowns.',
                'icon_name' => 'Anchor',
                'sort_order' => 4,
                'services' => [
                    [
                        'name' => 'Single Tooth Titanium Dental Implant & Abutment',
                        'slug' => 'titanium-dental-implant',
                        'short_description' => 'Permanent replacement root engineered with biocompatible medical titanium.',
                        'detailed_description' => 'Computer-guided surgical placement of premium Straumann/Nobel Biocare implant fixture under localized anesthesia.',
                        'standard_duration_minutes' => 60,
                        'base_cost' => 1750.00,
                        'requires_xray' => true,
                    ],
                ],
            ],
            [
                'name' => 'Emergency Dental Relief',
                'slug' => 'emergency-care',
                'description' => 'Same-day urgent interventions for severe toothache, dental trauma, pulpitis, or broken crowns.',
                'icon_name' => 'AlertCircle',
                'sort_order' => 5,
                'services' => [
                    [
                        'name' => 'Emergency Pain Relief & Pulpotomy / Trephination',
                        'slug' => 'emergency-pain-relief',
                        'short_description' => 'Immediate same-day clinical intervention to eliminate acute pulpitis or periapical abscess pain.',
                        'detailed_description' => 'Targeted diagnostic scan, localized profound anesthesia, pressure release, antimicrobial medication placement, and stabilizing temporary restoration.',
                        'standard_duration_minutes' => 45,
                        'base_cost' => 195.00,
                        'requires_xray' => true,
                    ],
                ],
            ],
        ];

        $doctors = DoctorProfile::all();

        foreach ($categories as $catData) {
            $serviceItems = $catData['services'];
            unset($catData['services']);

            $category = ServiceCategory::updateOrCreate(['slug' => $catData['slug']], $catData);

            foreach ($serviceItems as $svcData) {
                $service = Service::updateOrCreate(
                    ['slug' => $svcData['slug']],
                    array_merge($svcData, ['category_id' => $category->id])
                );

                // Attach to active doctors
                foreach ($doctors as $doctor) {
                    $doctor->services()->syncWithoutDetaching([$service->id => ['custom_fee' => null]]);
                }
            }
        }
    }
}
