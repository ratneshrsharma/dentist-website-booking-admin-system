<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * Service to manage CMS Pages and Dynamic Homepage Content & Images
 */
class CmsService
{
    private static function getHomeStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_home.json';
    }

    public static function getPages(): array
    {
        $homeData = self::getHomePageData();
        $updatedAt = $homeData['_updated_at'] ?? '2026-11-24 10:00:00';

        return [
            [
                'id' => 1,
                'title' => 'Home Page',
                'slug' => 'home',
                'route' => '/',
                'status' => 'published',
                'sections_count' => 7,
                'updated_at' => $updatedAt,
                'is_editable' => true,
            ],
            [
                'id' => 2,
                'title' => 'About Our Practice & Team',
                'slug' => 'about-us',
                'route' => '/about-us',
                'status' => 'published',
                'sections_count' => 4,
                'updated_at' => '2026-11-20 14:30:00',
                'is_editable' => false,
            ],
            [
                'id' => 3,
                'title' => 'Treatments & Services Catalog',
                'slug' => 'treatments',
                'route' => '/treatments',
                'status' => 'published',
                'sections_count' => 8,
                'updated_at' => '2026-11-21 16:15:00',
                'is_editable' => false,
            ],
            [
                'id' => 4,
                'title' => 'Contact & Emergency Location',
                'slug' => 'contact',
                'route' => '/contact',
                'status' => 'published',
                'sections_count' => 3,
                'updated_at' => '2026-11-22 09:45:00',
                'is_editable' => false,
            ],
        ];
    }

    public static function getDefaultHomePageData(): array
    {
        return [
            '_updated_at' => date('Y-m-d H:i:s'),
            'hero' => [
                'eyebrow' => 'NHS & PRIVATE PATIENTS WELCOMED',
                'headline' => 'Make your Dental Experience a',
                'headline_highlight' => 'Lot Brighter',
                'title' => 'Make your Dental Experience a',
                'highlight_word' => 'Lot Brighter',
                'subtitle' => 'Welcome to Acocks Green Dental Practice. Delivering gentle, high-standard dental care for patients of all ages across Birmingham B27. From preventive family appointments to transformative aesthetics, our clinical team puts your comfort first.',
                'cta_primary' => 'Book An Appointment',
                'cta_primary_link' => '#quick-book',
                'cta_secondary' => 'Emergency Consultation',
                'cta_secondary_link' => '/contact/#emergency',
                'phone' => '+44 121 765 2870',
                'emergency_label' => 'Emergency Triage Line',
                'hero_image' => App::url('/images/hero-patient.jpg'),
                'stats' => [
                    ['label' => 'Happy Patients', 'value' => '5,000+', 'is_active' => true],
                    ['label' => 'Dentists & Staff', 'value' => '7+', 'is_active' => true],
                    ['label' => 'Years of Trust', 'value' => '20+', 'is_active' => true],
                ],
                'hero_badges' => [
                    ['title' => 'CQC Regulated Standards', 'subtitle' => 'Fully compliant', 'icon' => 'verified'],
                    ['title' => 'Same-Day Emergency Slots', 'subtitle' => 'Fast pain relief', 'icon' => 'e911_emergency'],
                ],
            ],
            'services_intro' => [
                'eyebrow' => 'Our Practice Services',
                'title' => 'Discover Quality Dental Care in Acocks Green',
                'subtitle' => 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.',
            ],
            'featured_services' => [
                [
                    'id' => 1,
                    'title' => 'Routine Dental Examinations',
                    'slug' => 'examinations',
                    'category' => 'General Dentistry',
                    'badge' => 'Preventive',
                    'description' => 'Comprehensive soft tissue, periodontal, and tooth screenings with digital X-rays to preserve oral wellness.',
                    'icon' => 'dentistry',
                ],
                [
                    'id' => 2,
                    'title' => 'Dental Hygiene & Airflow Polish',
                    'slug' => 'hygiene',
                    'category' => 'Hygiene',
                    'badge' => 'Airflow Polish',
                    'description' => 'Gentle calculus removal, plaque decontamination, and high-pressure airflow polishing for brighter smiles.',
                    'icon' => 'clean_hands',
                ],
                [
                    'id' => 3,
                    'title' => 'White Tooth Fillings',
                    'slug' => 'composite-fillings',
                    'category' => 'Restorations',
                    'badge' => 'Composite',
                    'description' => 'Mercury-free biocompatible tooth-colored composite restorations seamlessly bonded to damaged enamel.',
                    'icon' => 'healing',
                ],
                [
                    'id' => 4,
                    'title' => 'Root Canal Therapy',
                    'slug' => 'endodontics',
                    'category' => 'Endodontics',
                    'badge' => 'Pain Relief',
                    'description' => 'Precise rotary endodontic treatments eliminating deep pulp infection while saving your natural tooth structure.',
                    'icon' => 'vital_signs',
                ],
                [
                    'id' => 5,
                    'title' => 'Dental Crowns & Bridges',
                    'slug' => 'crowns-bridges',
                    'category' => 'Prosthetics',
                    'badge' => 'Ceramic',
                    'description' => 'High-strength monolithic zirconia and porcelain crowns designed for optimal bite force and natural aesthetics.',
                    'icon' => 'crown',
                ],
                [
                    'id' => 6,
                    'title' => 'Invisalign® Clear Aligners',
                    'slug' => 'invisalign',
                    'category' => 'Orthodontics',
                    'badge' => 'Discreet',
                    'description' => 'Virtually invisible removable orthodontic aligners gently guiding teeth into alignment without metal brackets.',
                    'icon' => 'auto_fix_high',
                ],
                [
                    'id' => 7,
                    'title' => 'Emergency Tooth Extraction',
                    'slug' => 'extractions',
                    'category' => 'Oral Surgery',
                    'badge' => 'Same-Day',
                    'description' => 'Atraumatic dental extractions for severely compromised or impacted teeth with local anesthesia numbness.',
                    'icon' => 'medical_services',
                ],
                [
                    'id' => 8,
                    'title' => 'Same-Day Emergency Relief',
                    'slug' => 'emergency',
                    'category' => 'Emergency',
                    'badge' => 'Urgent Care',
                    'description' => 'Dedicated priority slots for severe toothache, abscesses, broken teeth, or sports-related dental trauma.',
                    'icon' => 'e911_emergency',
                ],
            ],
            'about_summary' => [
                'eyebrow' => 'About Acocks Green Practice',
                'title' => 'Dedicated Dental Professionals Serving Birmingham B27',
                'subtitle' => 'Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.',
                'experience_years' => '20+',
                'patients_served' => '5,000+',
                'story_paragraphs' => [
                    'At Acocks Green Dental Practice, we believe that visiting the dentist should be a calm, reassuring experience. Our clinic has been trusted by families across South Birmingham for over two decades.',
                    'From children taking their first steps into oral health to adults receiving complex smile restorations, our multi-disciplinary clinicians tailor treatment speeds to your personal comfort level.',
                ],
                'trust_seal' => [
                    'title' => 'Patient Comfort First',
                    'subtitle' => 'Gentle nervous patient protocols',
                ],
                'image_1' => App::url('/images/treatment-room.jpg'),
                'image_2' => App::url('/images/surgery-clinic.jpg'),
            ],
            'clinicians' => [
                [
                    'id' => 1,
                    'name' => 'Dr. Atandrilla Das',
                    'title' => 'BDS Associate Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/images/doctor-das.jpg'),
                    'bio' => 'Special interest in comprehensive restorative therapy, minimal-prep restorations, and pediatric patient care.',
                ],
                [
                    'id' => 2,
                    'name' => 'Dr. Harjeevan Rai',
                    'title' => 'BDS Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/images/doctor-rai.jpg'),
                    'bio' => 'Focused on preventive oral health, biomechanical restorations, and gentle pain relief treatments.',
                ],
                [
                    'id' => 3,
                    'name' => 'Dr. Nadeem Sohail',
                    'title' => 'BDS Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/images/doctor-sohail.jpg'),
                    'bio' => 'Experienced in complex endodontics, emergency extractions, and crown & bridge oral rehabilitation.',
                ],
                [
                    'id' => 4,
                    'name' => 'Claire',
                    'title' => 'Dental Hygienist',
                    'badge' => 'Dental Hygienist',
                    'avatar' => App::url('/images/hygienist-claire.jpg'),
                    'bio' => 'Leading our hygiene suite with deep periodontal therapy, patient brushing coaching, and airflow stain polishing.',
                ],
            ],
            'support_team' => [
                ['name' => 'Hannah', 'role' => 'Foundation Dentist'],
                ['name' => 'Niamh', 'role' => 'Foundation Dentist'],
                ['name' => 'Mulaykah Abdurrahman', 'role' => 'Nurse Apprentice'],
                ['name' => 'Gabriela Popescu', 'role' => 'Nurse'],
                ['name' => 'Hamza Ahmad', 'role' => 'Nurse'],
                ['name' => 'Rukhsana Choudhary', 'role' => 'Nurse'],
                ['name' => 'Richard Gill', 'role' => 'Nurse'],
                ['name' => 'Jessica William', 'role' => 'Nurse'],
                ['name' => 'Jade Walker', 'role' => 'Receptionist'],
            ],
            'testimonials' => [
                'average_rating' => 4.9,
                'total_reviews' => 148,
                'items' => [
                    [
                        'name' => 'Sarah Thompson',
                        'location' => 'Acocks Green',
                        'comment' => 'I have always had dental anxiety, but the team here took the time to explain everything and put me completely at ease. Highly recommended!',
                        'treatment' => 'Routine Examination & Hygiene',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'David Miller',
                        'location' => 'Solihull',
                        'comment' => 'Called in the morning with intense wisdom tooth pain and was accommodated the same day. Extremely professional and pain-free extraction.',
                        'treatment' => 'Emergency Dental Care',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'Priya Patel',
                        'location' => 'Hall Green',
                        'comment' => 'My kids actually look forward to their dental check-ups now! Dr. Das is so gentle and patient with children.',
                        'treatment' => 'Family Dental Care',
                        'rating' => 5,
                    ],
                ],
            ],
            'safety_charter' => [
                'title' => 'NHS Sexual Safety Charter Signatory',
                'description' => 'Acocks Green Dental Practice is an official signatory of the NHS Sexual Safety Charter, championing zero tolerance for harassment and fostering a safe, respectful clinical environment.',
                'badge' => 'Official NHS Charter',
                'link_text' => 'Read Our Safety Standards',
                'link_url' => 'https://www.england.nhs.uk/publication/sexual-safety-in-healthcare-charter/',
            ],
            'contact_section' => [
                'title' => 'Visit Our Modern Surgery in Birmingham B27',
                'address' => '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
                'phone' => '+44 121 765 2870',
                'email' => 'acocksgreendentalpractice@gmail.com',
                'hours' => [
                    ['day_range' => 'Monday – Thursday', 'hours' => '8:30 AM – 5:30 PM'],
                    ['day_range' => 'Friday', 'hours' => '8:30 AM – 5:00 PM'],
                    ['day_range' => 'Saturday – Sunday', 'hours' => 'Emergency Triage On-Call'],
                ],
                'map_image' => App::url('/images/surgery-clinic.jpg'),
            ],
            'sections' => [
                [
                    'id' => 'sec_services',
                    'type' => 'services_block',
                    'category' => 'prebuilt',
                    'name' => 'Services Section',
                    'eyebrow' => 'Our Practice Services',
                    'title' => 'Discover Quality Dental Care in Acocks Green',
                    'summary' => 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.',
                    'description' => '',
                    'layout' => 'thumbnail', // 'thumbnail' or 'sidebar_list'
                    'image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'full_width',
                    'cta_text' => 'View All Treatments',
                    'cta_link' => '/treatments',
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'id' => 'sec_about',
                    'type' => 'page_snippet',
                    'category' => 'page_snippet',
                    'name' => 'About Our Surgery',
                    'page_slug' => 'about-us',
                    'eyebrow' => 'About Acocks Green Practice',
                    'title' => 'Dedicated Dental Professionals Serving Birmingham B27',
                    'summary' => 'Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.',
                    'description' => 'At Acocks Green Dental Practice, we believe that visiting the dentist should be a calm, reassuring experience. Our clinic has been trusted by families across South Birmingham for over two decades. From routine checkups to advanced cosmetic aligners, our clinicians pace treatments to your comfort.',
                    'feature_image' => App::url('/images/surgery-clinic.jpg'),
                    'image_position' => 'left', // 'left' or 'right'
                    'column_layout' => 'two_col_split',
                    'cta_text' => 'Discover Our Surgery Story',
                    'cta_link' => '/about-us',
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'id' => 'sec_team',
                    'type' => 'team_block',
                    'category' => 'prebuilt',
                    'name' => 'Doctors & Dental Surgeons',
                    'eyebrow' => 'Clinical Team',
                    'title' => 'Dedicated Clinicians & Dental Surgeons',
                    'summary' => 'Compassionate care delivered by fully registered dental professionals with decades of combined clinical expertise.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'full_width',
                    'cta_text' => 'Meet Full Surgery Team',
                    'cta_link' => '/about-us#team',
                    'is_active' => true,
                    'order' => 3,
                ],
                [
                    'id' => 'sec_testimonials',
                    'type' => 'testimonials_block',
                    'category' => 'prebuilt',
                    'name' => 'Patient Testimonials Slider',
                    'eyebrow' => 'Patient Feedback',
                    'title' => 'What Our Patients Say About Us',
                    'summary' => 'Real stories from patients treated at our Acocks Green Birmingham surgery.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'full_width',
                    'cta_text' => 'Leave a Google Review',
                    'cta_link' => 'https://g.page/review',
                    'is_active' => true,
                    'order' => 4,
                ],
                [
                    'id' => 'sec_charter',
                    'type' => 'custom_content',
                    'category' => 'custom_content',
                    'name' => 'NHS Sexual Safety Charter',
                    'eyebrow' => 'Official NHS Charter',
                    'title' => 'NHS Sexual Safety Charter Signatory',
                    'summary' => 'Acocks Green Dental Practice is an official signatory of the NHS Sexual Safety Charter, championing zero tolerance for harassment and fostering a safe, respectful clinical environment.',
                    'description' => 'We are dedicated to safeguarding all staff, patients, and visitors within our clinical facilities.',
                    'feature_image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'action_bar', // 'action_bar', 'two_col_split', 'full_width'
                    'cta_text' => 'Read Our Safety Standards',
                    'cta_link' => 'https://www.england.nhs.uk/publication/sexual-safety-in-healthcare-charter/',
                    'is_active' => true,
                    'order' => 5,
                ],
                [
                    'id' => 'sec_contact',
                    'type' => 'contact_block',
                    'category' => 'prebuilt',
                    'name' => 'Hours & Surgery Location Map',
                    'eyebrow' => 'Practice Location',
                    'title' => 'Visit Our Modern Surgery in Birmingham B27',
                    'summary' => 'Find surgery opening hours, parking information, and telephone reception.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'full_width',
                    'cta_text' => 'Call Reception',
                    'cta_link' => 'tel:+441217652870',
                    'is_active' => true,
                    'order' => 6,
                ],
            ],
        ];
    }

    public static function getHomePageData(): array
    {
        $file = self::getHomeStorageFile();
        $data = [];
        if (file_exists($file)) {
            $parsed = json_decode((string)file_get_contents($file), true);
            if (is_array($parsed) && !empty($parsed)) {
                $data = $parsed;
            }
        }

        $defaults = self::getDefaultHomePageData();
        $merged = array_replace_recursive($defaults, $data);

        // If custom sections were explicitly saved, respect their exact array order
        if (!empty($data['sections']) && is_array($data['sections'])) {
            $merged['sections'] = $data['sections'];
        }

        // Dynamically sync featured_services from ServicesService if available
        if (class_exists(ServicesService::class)) {
            $services = ServicesService::getAllServices(true);
            if (!empty($services)) {
                $featured = [];
                foreach ($services as $s) {
                    $featured[] = [
                        'id' => $s['id'],
                        'slug' => $s['slug'],
                        'title' => $s['title'],
                        'category' => $s['category'],
                        'badge' => $s['badge'],
                        'description' => $s['summary'],
                        'icon' => $s['icon'],
                        'feature_image' => $s['feature_image'],
                        'starting_price' => $s['starting_price'],
                        'duration' => $s['duration'],
                        'is_active' => true,
                    ];
                }
                $merged['featured_services'] = $featured;
            }
        }

        return $merged;
    }

    public static function saveHomePageData(array $data): bool
    {
        $current = self::getHomePageData();
        $data['_updated_at'] = date('Y-m-d H:i:s');

        // Preserve sections replacement if explicitly given
        $explicitSections = $data['sections'] ?? null;
        $merged = array_replace_recursive($current, $data);

        if ($explicitSections !== null && is_array($explicitSections)) {
            $merged['sections'] = $explicitSections;
        }

        $file = self::getHomeStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }
}
