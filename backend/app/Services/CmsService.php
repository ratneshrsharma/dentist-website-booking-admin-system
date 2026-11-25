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

    private static function getPagesRegistryFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_pages.json';
    }

    private static function getCustomPageStorageFile(string $slug): string
    {
        $safe = preg_replace('/[^a-z0-9_-]/', '', strtolower($slug));
        return dirname(__DIR__, 2) . '/storage/app/cms_page_' . $safe . '.json';
    }

    private static function getTreatmentsStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_treatments.json';
    }

    public static function getTreatmentsPageData(): array
    {
        $file = self::getTreatmentsStorageFile();
        $data = [];
        if (file_exists($file)) {
            $decoded = json_decode((string)file_get_contents($file), true);
            if (is_array($decoded) && !empty($decoded)) {
                $data = $decoded;
            }
        }
        $defaults = self::getDefaultTreatmentsPageData();
        $merged = array_replace_recursive($defaults, $data);

        if (isset($data['sections']) && is_array($data['sections'])) {
            $merged['sections'] = $data['sections'];
        }
        if (isset($data['fee_bands']) && is_array($data['fee_bands'])) {
            $merged['fee_bands'] = $data['fee_bands'];
        }
        if (isset($data['clinical_pillars']) && is_array($data['clinical_pillars'])) {
            $merged['clinical_pillars'] = $data['clinical_pillars'];
        }

        return $merged;
    }

    public static function saveTreatmentsPageData(array $data): bool
    {
        $current = self::getTreatmentsPageData();
        $data['_updated_at'] = date('Y-m-d H:i:s');

        $explicitSections = $data['sections'] ?? null;
        $explicitFeeBands = $data['fee_bands'] ?? null;
        $explicitPillars = $data['clinical_pillars'] ?? null;

        $merged = array_replace_recursive($current, $data);

        if ($explicitSections !== null && is_array($explicitSections)) {
            $merged['sections'] = $explicitSections;
        }
        if ($explicitFeeBands !== null && is_array($explicitFeeBands)) {
            $merged['fee_bands'] = $explicitFeeBands;
        }
        if ($explicitPillars !== null && is_array($explicitPillars)) {
            $merged['clinical_pillars'] = $explicitPillars;
        }

        $file = self::getTreatmentsStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    public static function getDefaultTreatmentsPageData(): array
    {
        return [
            '_updated_at' => date('Y-m-d H:i:s'),
            'slug' => 'treatments',
            'title' => 'Treatments & Services Catalog',
            'hero' => [
                'eyebrow' => 'OUR CLINICAL SERVICES & PROCEDURES',
                'headline' => 'Comprehensive Dental Care & Specialized Treatments',
                'subtitle' => 'From essential routine NHS care to advanced cosmetic smile makeovers and restorative procedures in Acocks Green, Birmingham. Delivered with gentle compassion and state-of-the-art diagnostics.',
                'image' => App::url('/uploads/home/hero-patient.jpg'),
                'cta_primary' => 'Book Consultation',
                'cta_primary_link' => '#quick-book',
            ],
            'fee_bands' => [
                [
                    'icon' => 'local_hospital',
                    'title' => 'NHS Band 1',
                    'badge' => 'Examination & Diagnosis',
                    'price' => '£26.80',
                    'desc' => 'Includes comprehensive examination, diagnosis, X-rays, and preventive clinical advice.',
                    'is_active' => true,
                ],
                [
                    'icon' => 'healing',
                    'title' => 'NHS Band 2',
                    'badge' => 'Fillings & Root Canals',
                    'price' => '£73.50',
                    'desc' => 'Covers Band 1 plus fillings, root canal treatments, and tooth extractions.',
                    'is_active' => true,
                ],
                [
                    'icon' => 'workspace_premium',
                    'title' => 'Private Dentistry Options',
                    'badge' => 'Cosmetic & Flexible',
                    'price' => 'From £45.00',
                    'desc' => 'Extended appointment times, white composite fillings, Airflow hygiene, and Invisalign® aligners.',
                    'is_active' => true,
                ],
            ],
            'clinical_pillars' => [
                ['icon' => 'biotech', 'title' => 'Modern Digital Technology', 'desc' => 'Low-radiation 3D digital radiography and iTero optical scanners.', 'is_active' => true],
                ['icon' => 'sentiment_satisfied', 'title' => 'Welcoming Phobic Patients', 'desc' => 'Unhurried appointments with gentle numbing techniques.', 'is_active' => true],
                ['icon' => 'calendar_month', 'title' => 'Flexible Appointments', 'desc' => 'Same-day emergency triage slots and convenient scheduling.', 'is_active' => true],
                ['icon' => 'verified_user', 'title' => 'Strict NHS & CQC Safety', 'desc' => 'HTM 01-05 gold standard decontamination and CQC compliance.', 'is_active' => true],
            ],
            'sections' => [
                [
                    'id' => 'sec_trt_grid',
                    'type' => 'services_block',
                    'category' => 'prebuilt',
                    'name' => 'Treatments & Services Grid',
                    'eyebrow' => 'Clinical Catalog',
                    'title' => 'Explore Our Dental Treatments',
                    'summary' => 'Filter by specialty or click any treatment to explore full clinical details and pricing.',
                    'grid_cols' => 3,
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'id' => 'sec_trt_fees',
                    'type' => 'fee_bands_block',
                    'category' => 'prebuilt',
                    'name' => 'NHS Fee Bands & Private Options',
                    'eyebrow' => 'Transparent Pricing',
                    'title' => 'NHS Fee Bands & Private Care Options',
                    'summary' => 'Clear upfront pricing with zero hidden fees across both NHS and private pathways.',
                    'grid_cols' => 3,
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'id' => 'sec_trt_pillars',
                    'type' => 'why_us_block',
                    'category' => 'prebuilt',
                    'name' => 'Clinical Pillars & Care Standards',
                    'eyebrow' => 'Why Choose Us',
                    'title' => 'Patient-First Care in Birmingham B27',
                    'summary' => 'Combining modern clinical technology with gentle chairside reassurance.',
                    'grid_cols' => 4,
                    'is_active' => true,
                    'order' => 3,
                ],
                [
                    'id' => 'sec_trt_cta',
                    'type' => 'custom_content',
                    'category' => 'custom_content',
                    'name' => 'Quick Book Consultation Banner',
                    'eyebrow' => 'NEED CLINICAL ADVICE FIRST?',
                    'title' => 'Not Sure Which Treatment is Right for You?',
                    'summary' => 'Speak directly with our clinical team or book a consultation at our Warwick Road surgery. We will guide you through all NHS and private options clearly, with zero obligation.',
                    'column_layout' => 'action_bar',
                    'cta_text' => 'Book Consultation',
                    'cta_link' => '#quick-book',
                    'is_active' => true,
                    'order' => 4,
                ],
            ],
            'seo' => [
                'meta_title' => 'Treatments & Services | Acocks Green Dental Practice',
                'meta_description' => 'Comprehensive NHS and private dental treatments in Acocks Green, Birmingham B27.',
                'keywords' => 'dental treatments Birmingham, NHS dentist, Airflow hygiene, Invisalign, emergency dentist',
            ],
        ];
    }

    public static function getPages(): array
    {
        $file = self::getPagesRegistryFile();
        $homeData = self::getHomePageData();
        $aboutData = self::getAboutPageData();

        if (file_exists($file)) {
            $decoded = json_decode((string)file_get_contents($file), true);
            if (is_array($decoded) && !empty($decoded)) {
                // Sync dynamic counts & timestamps
                foreach ($decoded as &$p) {
                    if ($p['slug'] === 'home') {
                        $p['sections_count'] = count($homeData['sections'] ?? []);
                        $p['updated_at'] = $homeData['_updated_at'] ?? $p['updated_at'];
                    } elseif ($p['slug'] === 'about-us') {
                        $p['sections_count'] = count($aboutData['sections'] ?? []);
                        $p['updated_at'] = $aboutData['_updated_at'] ?? $p['updated_at'];
                    } elseif ($p['slug'] === 'treatments') {
                        $tData = self::getTreatmentsPageData();
                        $p['is_editable'] = true;
                        $p['route'] = '/treatments';
                        $p['sections_count'] = count($tData['sections'] ?? []);
                        $p['updated_at'] = $tData['_updated_at'] ?? $p['updated_at'];
                    } elseif ($p['slug'] === 'contact') {
                        $ctData = self::getContactPageData();
                        $p['is_editable'] = true;
                        $p['route'] = '/contact';
                        $p['sections_count'] = count($ctData['sections'] ?? []);
                        $p['updated_at'] = $ctData['_updated_at'] ?? $p['updated_at'];
                    } elseif (!empty($p['is_custom']) || $p['slug'] === 'blog') {
                        $cData = self::getCustomPageData($p['slug']);
                        $p['sections_count'] = count($cData['sections'] ?? []);
                        $p['updated_at'] = $cData['_updated_at'] ?? $p['updated_at'];
                    }
                }
                unset($p);
                return $decoded;
            }
        }

        $defaults = [
            [
                'id' => 1,
                'title' => 'Home Page',
                'slug' => 'home',
                'route' => '/',
                'template' => 'home',
                'status' => 'published',
                'is_primary' => true,
                'is_editable' => true,
                'is_custom' => false,
                'sections_count' => count($homeData['sections'] ?? []),
                'updated_at' => $homeData['_updated_at'] ?? date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'title' => 'About Our Practice & Team',
                'slug' => 'about-us',
                'route' => '/about-us',
                'template' => 'about',
                'status' => 'published',
                'is_primary' => false,
                'is_editable' => true,
                'is_custom' => false,
                'sections_count' => count($aboutData['sections'] ?? []),
                'updated_at' => $aboutData['_updated_at'] ?? date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'title' => 'Dental Health Blog & News',
                'slug' => 'blog',
                'route' => '/blog',
                'template' => 'blog_list',
                'status' => 'published',
                'is_primary' => false,
                'is_editable' => true,
                'is_custom' => true,
                'sections_count' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'title' => 'Treatments & Services Catalog',
                'slug' => 'treatments',
                'route' => '/treatments',
                'template' => 'treatments',
                'status' => 'published',
                'is_primary' => false,
                'is_editable' => true,
                'is_custom' => false,
                'sections_count' => 4,
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'title' => 'Contact & Emergency Location',
                'slug' => 'contact',
                'route' => '/contact',
                'template' => 'contact',
                'status' => 'published',
                'is_primary' => false,
                'is_editable' => true,
                'is_custom' => false,
                'sections_count' => 3,
                'updated_at' => '2026-11-22 09:45:00',
            ],
        ];

        self::savePagesRegistry($defaults);
        return $defaults;
    }

    public static function savePagesRegistry(array $pages): bool
    {
        $file = self::getPagesRegistryFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return file_put_contents($file, json_encode(array_values($pages), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    public static function createPage(string $title, string $slug, string $template = 'standard', string $status = 'published'): array
    {
        $pages = self::getPages();
        $cleanSlug = trim(preg_replace('/[^a-z0-9-]+/', '-', strtolower($slug)), '-');
        if ($cleanSlug === '') {
            $cleanSlug = 'page-' . time();
        }
        // Ensure unique slug
        foreach ($pages as $existing) {
            if ($existing['slug'] === $cleanSlug) {
                $cleanSlug .= '-' . substr((string)time(), -4);
                break;
            }
        }

        $maxId = 0;
        foreach ($pages as $p) {
            if ((int)($p['id'] ?? 0) > $maxId) {
                $maxId = (int)$p['id'];
            }
        }

        $route = $template === 'blog_list' ? '/blog' : '/' . $cleanSlug;
        $newPage = [
            'id' => $maxId + 1,
            'title' => trim($title),
            'slug' => $cleanSlug,
            'route' => $route,
            'template' => $template,
            'status' => $status,
            'is_primary' => false,
            'is_editable' => true,
            'is_custom' => true,
            'sections_count' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $pages[] = $newPage;
        self::savePagesRegistry($pages);

        // Initialize custom page data
        self::saveCustomPageData($cleanSlug, self::getDefaultCustomPageData($cleanSlug, $title, $template));

        return $newPage;
    }

    public static function togglePageStatus(string $slug): ?string
    {
        $pages = self::getPages();
        $newStatus = null;
        foreach ($pages as &$p) {
            if ($p['slug'] === $slug) {
                $p['status'] = ($p['status'] ?? 'published') === 'published' ? 'inactive' : 'published';
                $p['updated_at'] = date('Y-m-d H:i:s');
                $newStatus = $p['status'];
                break;
            }
        }
        unset($p);
        if ($newStatus !== null) {
            self::savePagesRegistry($pages);
        }
        return $newStatus;
    }

    public static function setPrimaryPage(string $slug): bool
    {
        $pages = self::getPages();
        $found = false;
        foreach ($pages as &$p) {
            if ($p['slug'] === $slug) {
                $p['is_primary'] = true;
                $p['status'] = 'published';
                $found = true;
            } else {
                $p['is_primary'] = false;
            }
        }
        unset($p);
        if ($found) {
            self::savePagesRegistry($pages);
        }
        return $found;
    }

    public static function deletePage(string $slug): bool
    {
        $pages = self::getPages();
        $filtered = [];
        $deleted = false;
        foreach ($pages as $p) {
            if ($p['slug'] === $slug && empty($p['is_primary'])) {
                $deleted = true;
                $customFile = self::getCustomPageStorageFile($slug);
                if (file_exists($customFile)) {
                    @unlink($customFile);
                }
                continue;
            }
            $filtered[] = $p;
        }
        if ($deleted) {
            self::savePagesRegistry($filtered);
        }
        return $deleted;
    }

    public static function getPrimarySlug(): string
    {
        foreach (self::getPages() as $p) {
            if (!empty($p['is_primary'])) {
                return (string)$p['slug'];
            }
        }
        return 'home';
    }

    public static function getCustomPageData(string $slug): array
    {
        $file = self::getCustomPageStorageFile($slug);
        if (file_exists($file)) {
            $decoded = json_decode((string)file_get_contents($file), true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }
        $title = $slug === 'blog' ? 'Dental Health Blog & News' : ucwords(str_replace('-', ' ', $slug));
        $template = $slug === 'blog' ? 'blog_list' : 'standard';
        return self::getDefaultCustomPageData($slug, $title, $template);
    }

    public static function saveCustomPageData(string $slug, array $data): bool
    {
        $current = self::getCustomPageData($slug);
        $data['_updated_at'] = date('Y-m-d H:i:s');
        $explicitSections = $data['sections'] ?? null;
        $explicitPosts = $data['blog_posts'] ?? null;
        $merged = array_replace_recursive($current, $data);
        if ($explicitSections !== null && is_array($explicitSections)) {
            $merged['sections'] = $explicitSections;
        }
        if ($explicitPosts !== null && is_array($explicitPosts)) {
            $merged['blog_posts'] = $explicitPosts;
        }

        $file = self::getCustomPageStorageFile($slug);
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    public static function getDefaultCustomPageData(string $slug, string $title, string $template = 'standard'): array
    {
        $isBlog = ($template === 'blog_list' || $slug === 'blog');
        return [
            '_updated_at' => date('Y-m-d H:i:s'),
            'slug' => $slug,
            'template' => $template,
            'title' => $title,
            'hero' => [
                'eyebrow' => $isBlog ? 'Clinical Insights & Oral Wellness' : 'Acocks Green Dental Practice',
                'headline' => $isBlog ? 'Dental Health Blog & Patient Guides' : $title,
                'subtitle' => $isBlog
                    ? 'Evidence-based dental advice, NHS & private care tips, and practice updates from our Birmingham B27 clinical team.'
                    : 'Discover personalized dental care and clinical excellence at Acocks Green Dental Practice.',
                'image' => App::url('/uploads/home/surgery-clinic.jpg'),
                'cta_primary' => 'Book An Appointment',
                'cta_primary_link' => '#quick-book',
            ],
            'sections' => [
                [
                    'id' => 'sec_' . $slug . '_intro',
                    'type' => $isBlog ? 'blog_block' : 'custom_content',
                    'category' => $isBlog ? 'prebuilt' : 'custom_content',
                    'name' => $isBlog ? 'All Blog Posts Grid' : 'Main Content Section',
                    'eyebrow' => $isBlog ? 'Latest Articles' : 'Overview',
                    'title' => $isBlog ? 'Recent Dental Health Articles' : $title,
                    'summary' => $isBlog ? 'Written and clinically reviewed by our GDC-registered dental surgeons.' : 'Add your page content, images, and layout options below.',
                    'description' => '',
                    'column_layout' => 'two_col_split',
                    'image_position' => 'right',
                    'grid_cols' => 3,
                    'is_active' => true,
                    'order' => 1,
                ],
            ],
            'blog_posts' => $isBlog ? [
                [
                    'id' => 'post_1',
                    'title' => 'How Often Should You Book a Dental Hygiene & Airflow Polish?',
                    'category' => 'Preventive Care',
                    'date' => '2026-11-18',
                    'author' => 'Claire, Dental Hygienist',
                    'read_time' => '4 min read',
                    'image' => App::url('/uploads/home/treatment-room.jpg'),
                    'excerpt' => 'Learn how Airflow warm-water polishing removes stubborn tea, coffee, and plaque biofilm gently without scraping sensitive enamel.',
                    'content' => 'Regular dental hygiene appointments every 3 to 6 months are essential for preventing gum disease and preserving natural enamel. Our Airflow system uses a gentle stream of warm water, air, and fine erythritol powder to lift surface stains painlessly.',
                ],
                [
                    'id' => 'post_2',
                    'title' => 'NHS vs Private Dental Care in Birmingham: What Is Included?',
                    'category' => 'Patient Guides',
                    'date' => '2026-11-10',
                    'author' => 'Dr. Atandrilla Das',
                    'read_time' => '5 min read',
                    'image' => App::url('/uploads/home/hero-patient.jpg'),
                    'excerpt' => 'A transparent breakdown of NHS Band 1, Band 2, and Band 3 treatments alongside private cosmetic options like white fillings and Invisalign.',
                    'content' => 'Understanding your dental treatment options should always be clear and stress-free. At Acocks Green Dental Practice, we explain both NHS and private pathways upfront so you can choose what suits your clinical needs and budget.',
                ],
                [
                    'id' => 'post_3',
                    'title' => 'Same-Day Emergency Dental Triage: What Counts as Urgent?',
                    'category' => 'Emergency Care',
                    'date' => '2026-11-02',
                    'author' => 'Dr. Nadeem Sohail',
                    'read_time' => '3 min read',
                    'image' => App::url('/uploads/home/surgery-clinic.jpg'),
                    'excerpt' => 'Severe toothache, facial swelling, or a knocked-out tooth? Here is how our Birmingham B27 triage line gets you seen the very same day.',
                    'content' => 'Dental emergencies can happen without warning. If you experience severe throbbing pain, swelling, or dental trauma, call our reception on +44 121 765 2870 before 10:00 AM for priority same-day clinical triage.',
                ],
            ] : [],
            'seo' => [
                'meta_title' => $title . ' | Acocks Green Dental Practice',
                'meta_description' => 'Acocks Green Dental Practice — NHS & Private Family Dentistry in Birmingham B27.',
                'keywords' => 'dental clinic Birmingham, Acocks Green dentist, dental blog',
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
                'hero_image' => App::url('/uploads/home/hero-patient.jpg'),
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
                'image_1' => App::url('/uploads/home/treatment-room.jpg'),
                'image_2' => App::url('/uploads/home/surgery-clinic.jpg'),
            ],
            'clinicians' => [
                [
                    'id' => 1,
                    'name' => 'Dr. Atandrilla Das',
                    'title' => 'BDS Associate Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/uploads/home/doctor-das.jpg'),
                    'bio' => 'Special interest in comprehensive restorative therapy, minimal-prep restorations, and pediatric patient care.',
                ],
                [
                    'id' => 2,
                    'name' => 'Dr. Harjeevan Rai',
                    'title' => 'BDS Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/uploads/home/doctor-rai.jpg'),
                    'bio' => 'Focused on preventive oral health, biomechanical restorations, and gentle pain relief treatments.',
                ],
                [
                    'id' => 3,
                    'name' => 'Dr. Nadeem Sohail',
                    'title' => 'BDS Dental Surgeon',
                    'badge' => 'Associate Dentist',
                    'avatar' => App::url('/uploads/home/doctor-sohail.jpg'),
                    'bio' => 'Experienced in complex endodontics, emergency extractions, and crown & bridge oral rehabilitation.',
                ],
                [
                    'id' => 4,
                    'name' => 'Claire',
                    'title' => 'Dental Hygienist',
                    'badge' => 'Dental Hygienist',
                    'avatar' => App::url('/uploads/home/hygienist-claire.jpg'),
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
                'map_image' => App::url('/uploads/home/surgery-clinic.jpg'),
            ],
            'seo' => [
                'meta_title' => 'Acocks Green Dental Practice | NHS & Private Family Dentist Birmingham B27',
                'meta_description' => 'Trusted NHS & private dental clinic in Acocks Green, Birmingham B27. Routine exams, hygiene, Invisalign, composite fillings, and same-day emergency dental triage.',
                'keywords' => 'dentist Acocks Green, Birmingham B27 dentist, NHS dentist Birmingham, emergency dentist, Invisalign Acocks Green',
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
                    'feature_image' => App::url('/uploads/home/surgery-clinic.jpg'),
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

    private static function getAboutStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_about.json';
    }

    public static function getAboutPageData(): array
    {
        $file = self::getAboutStorageFile();
        $data = [];
        if (file_exists($file)) {
            $decoded = json_decode((string)file_get_contents($file), true);
            if (is_array($decoded) && !empty($decoded)) {
                $data = $decoded;
            }
        }

        $defaults = self::getDefaultAboutPageData();
        $merged = array_replace_recursive($defaults, $data);

        if (!empty($data['sections']) && is_array($data['sections'])) {
            $merged['sections'] = $data['sections'];
        }
        if (!empty($data['hero']['trust_badges']) && is_array($data['hero']['trust_badges'])) {
            $merged['hero']['trust_badges'] = $data['hero']['trust_badges'];
        }
        if (isset($data['why_us']['stats']) && is_array($data['why_us']['stats'])) {
            $merged['why_us']['stats'] = $data['why_us']['stats'];
        }
        if (isset($data['why_us']['pillars']) && is_array($data['why_us']['pillars'])) {
            $merged['why_us']['pillars'] = $data['why_us']['pillars'];
        }
        if (isset($data['clinics']['features']) && is_array($data['clinics']['features'])) {
            $merged['clinics']['features'] = $data['clinics']['features'];
        }
        if (isset($data['safety_charter']['cards']) && is_array($data['safety_charter']['cards'])) {
            $merged['safety_charter']['cards'] = $data['safety_charter']['cards'];
        }

        // Sync clinicians from Home CMS if not customized on About
        if (empty($merged['clinicians'])) {
            $home = self::getHomePageData();
            $merged['clinicians'] = $home['clinicians'] ?? [];
        }

        return $merged;
    }

    public static function saveAboutPageData(array $data): bool
    {
        $current = self::getAboutPageData();
        $data['_updated_at'] = date('Y-m-d H:i:s');

        $explicitSections = $data['sections'] ?? null;
        $explicitBadges = $data['hero']['trust_badges'] ?? null;
        $explicitStats = $data['why_us']['stats'] ?? null;
        $explicitPillars = $data['why_us']['pillars'] ?? null;
        $explicitFeatures = $data['clinics']['features'] ?? null;
        $explicitCharterCards = $data['safety_charter']['cards'] ?? null;

        $merged = array_replace_recursive($current, $data);

        if ($explicitSections !== null && is_array($explicitSections)) {
            $merged['sections'] = $explicitSections;
        }
        if ($explicitBadges !== null && is_array($explicitBadges)) {
            $merged['hero']['trust_badges'] = $explicitBadges;
        }
        if ($explicitStats !== null && is_array($explicitStats)) {
            $merged['why_us']['stats'] = $explicitStats;
        }
        if ($explicitPillars !== null && is_array($explicitPillars)) {
            $merged['why_us']['pillars'] = $explicitPillars;
        }
        if ($explicitFeatures !== null && is_array($explicitFeatures)) {
            $merged['clinics']['features'] = $explicitFeatures;
        }
        if ($explicitCharterCards !== null && is_array($explicitCharterCards)) {
            $merged['safety_charter']['cards'] = $explicitCharterCards;
        }

        $file = self::getAboutStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    public static function getDefaultAboutPageData(): array
    {
        return [
            '_updated_at' => date('Y-m-d H:i:s'),
            'slug' => 'about-us',
            'title' => 'Dedicated to Gentle, High-Quality Family & Cosmetic Dentistry in Acocks Green',
            'hero' => [
                'eyebrow' => 'Caring for Birmingham Smiles Since 1998',
                'headline' => 'Dedicated to Gentle, High-Quality Family & Cosmetic Dentistry in Acocks Green',
                'subtitle' => 'With over 25 years of clinical heritage at 1078 Warwick Road, Acocks Green Dental Practice unites compassionate NHS primary dental health with advanced, minimally invasive private and cosmetic care. We believe modern dental visits should feel calm, transparent, and completely unhurried.',
                'image' => App::url('/uploads/about-us/about-team.jpg'),
                'image_caption' => 'Principal Clinicians & Care Team — Warwick Road',
                'cta_primary' => 'Meet Our Team',
                'cta_primary_link' => '#our-team',
                'cta_secondary' => '0121 765 2870',
                'cta_secondary_link' => 'tel:+441217652870',
                'trust_badges' => [
                    ['icon' => 'local_hospital', 'label' => 'NHS & Private'],
                    ['icon' => 'verified_user', 'label' => 'CQC Regulated'],
                    ['icon' => 'workspace_premium', 'label' => 'BDA Member'],
                    ['icon' => 'military_tech', 'label' => 'Award-Winning'],
                ],
            ],
            'why_us' => [
                'eyebrow' => 'Practice Ethos & Clinical Standards',
                'headline' => 'Why Birmingham Patients Choose Acocks Green Dental',
                'subtitle' => 'We understand that many patients feel anxious or delay treatments due to fear of discomfort or unexpected bills. Our clinicians take time to listen, provide transparent NHS and private guidance, and deliver gentle treatment in a calm, modern setting.',
                'pillars' => [
                    [
                        'icon' => 'spa',
                        'title' => 'Unhurried & Gentle Care',
                        'desc' => 'Extra appointment time dedicated to anxious patients, gentle numbing techniques, and comprehensive clinical explanations prior to any procedure.',
                        'badge' => 'Dental Phobia Certified',
                    ],
                    [
                        'icon' => 'biotech',
                        'title' => 'Modern Clinical Tech',
                        'desc' => 'Low-dose digital 3D radiography, iTero® intraoral digital optical scanners, and painless ultrasonic scaling for fast, accurate treatment planning.',
                        'badge' => 'Zero Goop Digital Scans',
                    ],
                    [
                        'icon' => 'receipt_long',
                        'title' => 'Transparent Pathways',
                        'desc' => 'Clear upfront cost breakdowns with zero hidden fees, standard NHS bandings, and interest-free 0% APR financing options on qualifying treatments.',
                        'badge' => '0% Finance Options',
                    ],
                    [
                        'icon' => 'school',
                        'title' => 'GDC-Registered Team',
                        'desc' => 'Continual postgraduate development, master\'s level restorative clinicians, and dedicated oral hygiene specialists ensuring hospital-grade care.',
                        'badge' => 'GDC Regulated Clinicians',
                    ],
                ],
                'stats' => [
                    ['value' => '25+', 'label' => 'Years Serving Acocks Green', 'desc' => 'Continuous community dental trust'],
                    ['value' => '15,000+', 'label' => 'Smiles Treated', 'desc' => 'Families, children, and adults'],
                    ['value' => '4.9/5', 'label' => 'Average Patient Rating', 'desc' => 'Across Google and NHS Choices'],
                    ['value' => '100%', 'label' => 'CQC Compliance', 'desc' => 'Audited safety & sterilization'],
                ],
            ],
            'clinics' => [
                'eyebrow' => 'Modern Surgery & Accessible Amenities',
                'headline' => 'State-of-the-Art Surgeries on Warwick Road',
                'subtitle' => 'Designed for comfort, sterility, and seamless clinical efficiency. Located conveniently at 1078 Warwick Road, Birmingham with on-site parking and step-free disabled access.',
                'features' => [
                    [
                        'icon' => 'radiology',
                        'title' => 'Digital X-Ray & Intraoral 3D Imaging Suite',
                        'desc' => 'Instant, ultra-low radiation diagnostic imaging displayed chairside on HD screens for transparent patient consultation.',
                    ],
                    [
                        'icon' => 'sanitizer',
                        'title' => 'Dedicated Sterilisation & Decontamination Suite',
                        'desc' => 'Fully segregated HTM 01-05 compliant cleanroom utilizing vacuum autoclaves, tracking barcoding, and daily biological spore testing.',
                    ],
                    [
                        'icon' => 'accessible',
                        'title' => 'Step-Free Ground Floor Surgeries',
                        'desc' => 'Wheelchair, mobility scooter, and pushchair accessible throughout the clinic, including broad corridors and accessible facilities.',
                    ],
                    [
                        'icon' => 'chair',
                        'title' => 'Comfort-First Patient Lounge',
                        'desc' => 'Calming, acoustically treated waiting environment with fresh chilled water, tea/coffee, and high-speed Wi-Fi.',
                    ],
                    [
                        'icon' => 'directions_bus',
                        'title' => 'Free Patient Parking & Transport Links',
                        'desc' => 'Dedicated on-site parking at the rear, directly opposite Warwick Road bus stops and 5 minutes from Acocks Green Railway Station.',
                    ],
                ],
                'surgery_image' => App::url('/uploads/about-us/surgery-clinic.jpg'),
                'surgery_title' => 'Modern Surgery 1',
                'surgery_desc' => 'Equipped with A-dec 500 ergonomic chair and digital radiographic suite',
                'surgery_badge' => 'Active Clinical Suite',
            ],
            'safety_charter' => [
                'eyebrow' => 'Regulatory Rigor & Patient Safeguards',
                'headline' => 'Our NHS Safety Charter & CQC Quality Standards',
                'subtitle' => 'We are deeply committed to delivering safe, dignified, and clinically audited dental care under NHS primary care contracts and private healthcare regulations.',
                'cards' => [
                    [
                        'icon' => 'verified',
                        'title' => 'CQC Regulated & Inspected',
                        'desc' => 'Acocks Green Dental Practice is fully registered with the Care Quality Commission and rated compliant in all essential standards of safety, clinical effectiveness, caring, responsiveness, and leadership.',
                        'footer_label' => 'Inspection Status: 100% Compliant',
                    ],
                    [
                        'icon' => 'clean_hands',
                        'title' => 'Cross-Infection Control (HTM 01-05)',
                        'desc' => 'Gold standard autoclave sterilization, continuous single-use disposables, and daily biological spore testing ensure ultimate reassurance and complete protection for your family.',
                        'footer_label' => 'HTM 01-05 Gold Protocol',
                    ],
                    [
                        'icon' => 'lock',
                        'title' => 'Confidentiality & GDPR Compliance',
                        'desc' => 'Full compliance with NHS Caldicott Guardian principles, General Dental Council guidelines, and modern 256-bit encrypted digital radiograph and health records archives.',
                        'footer_label' => 'Encrypted Health Storage',
                    ],
                ],
                'emergency_box' => [
                    'title' => 'Emergency & Out-of-Hours Dental Support',
                    'subtitle' => 'Experiencing severe dental pain, bleeding, or facial trauma outside regular practice hours?',
                    'phone' => '+44 121 765 2870',
                    'nhs111' => '111',
                ],
            ],
            'seo' => [
                'meta_title' => 'About Our Practice & Clinical Team | Acocks Green Dental Practice',
                'meta_description' => 'Discover our patient-first clinical philosophy, hospital-grade sterilization protocols, and multi-specialty dental expertise in Birmingham B27.',
                'keywords' => 'dental clinic about us, dental philosophy, sterile dental facility, multi-specialty dentistry, Acocks Green dentist',
            ],
            'sections' => [
                [
                    'id' => 'sec_about_why_us',
                    'type' => 'why_us_block',
                    'category' => 'prebuilt',
                    'name' => 'Why Us & Ethos Pillars',
                    'page_slug' => '',
                    'eyebrow' => 'Practice Ethos & Clinical Standards',
                    'title' => 'Why Birmingham Patients Choose Acocks Green Dental',
                    'summary' => 'We understand that many patients feel anxious or delay treatments due to fear of discomfort or unexpected bills. Our clinicians take time to listen, provide transparent NHS and private guidance, and deliver gentle treatment in a calm, modern setting.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'feature_image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'two_col_split',
                    'cta_text' => '',
                    'cta_link' => '',
                    'bg_type' => 'default',
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'id' => 'sec_about_team',
                    'type' => 'team_block',
                    'category' => 'prebuilt',
                    'name' => 'Our Clinical Team',
                    'page_slug' => '',
                    'eyebrow' => 'Meet Our Experienced Clinicians',
                    'title' => 'GDC-Registered Dentists, Hygienists & Dental Nurses',
                    'summary' => 'Every clinician at Acocks Green Dental Practice shares a commitment to gentle clinical precision, continuous professional learning, and friendly patient care.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'feature_image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'two_col_split',
                    'cta_text' => '',
                    'cta_link' => '',
                    'bg_type' => 'default',
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'id' => 'sec_about_clinics',
                    'type' => 'clinics_block',
                    'category' => 'prebuilt',
                    'name' => 'Our Clinics & Amenities',
                    'page_slug' => '',
                    'eyebrow' => 'Modern Surgery & Accessible Amenities',
                    'title' => 'State-of-the-Art Surgeries on Warwick Road',
                    'summary' => 'Designed for comfort, sterility, and seamless clinical efficiency. Located conveniently at 1078 Warwick Road, Birmingham with on-site parking and step-free disabled access.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'feature_image' => App::url('/uploads/about-us/surgery-clinic.jpg'),
                    'image_position' => 'right',
                    'column_layout' => 'two_col_split',
                    'cta_text' => '',
                    'cta_link' => '',
                    'bg_type' => 'default',
                    'is_active' => true,
                    'order' => 3,
                ],
                [
                    'id' => 'sec_about_charter',
                    'type' => 'safety_charter_cards',
                    'category' => 'prebuilt',
                    'name' => 'NHS Safety Charter & CQC Standards',
                    'page_slug' => '',
                    'eyebrow' => 'Regulatory Rigor & Patient Safeguards',
                    'title' => 'Our NHS Safety Charter & CQC Quality Standards',
                    'summary' => 'We are deeply committed to delivering safe, dignified, and clinically audited dental care under NHS primary care contracts and private healthcare regulations.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'feature_image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'two_col_split',
                    'cta_text' => '',
                    'cta_link' => '',
                    'bg_type' => 'default',
                    'is_active' => true,
                    'order' => 4,
                ],
                [
                    'id' => 'sec_about_reviews',
                    'type' => 'testimonials_block',
                    'category' => 'prebuilt',
                    'name' => 'Patient Reviews & Stories',
                    'page_slug' => '',
                    'eyebrow' => 'Patient Voices',
                    'title' => 'What Our Patients Say About Us',
                    'summary' => 'Verified reviews from patients cared for at our Acocks Green dental practice.',
                    'description' => '',
                    'layout' => 'thumbnail',
                    'feature_image' => '',
                    'image_position' => 'right',
                    'column_layout' => 'two_col_split',
                    'cta_text' => 'Leave a Google Review',
                    'cta_link' => 'https://g.page/review',
                    'bg_type' => 'default',
                    'is_active' => true,
                    'order' => 5,
                ],
            ],
        ];
    }

    // =========================================================================
    // CONTACT PAGE DATA
    // =========================================================================

    private static function getContactStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_contact.json';
    }

    public static function getContactPageData(): array
    {
        $file = self::getContactStorageFile();
        $defaults = self::getDefaultContactPageData();
        if (file_exists($file)) {
            $decoded = json_decode((string) file_get_contents($file), true);
            if (is_array($decoded)) {
                return array_replace_recursive($defaults, $decoded);
            }
        }
        return $defaults;
    }

    public static function saveContactPageData(array $data): bool
    {
        $file = self::getContactStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $data['_updated_at'] = date('Y-m-d H:i:s');
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }

    public static function getDefaultContactPageData(): array
    {
        return [
            '_updated_at' => date('Y-m-d H:i:s'),
            'hero' => [
                'eyebrow' => 'GET IN TOUCH WITH OUR TEAM',
                'headline' => 'Contact Acocks Green Dental Practice in Birmingham',
                'subtitle' => 'Whether you are booking a routine NHS check-up, inquiring about cosmetic Invisalign® aligners, or requiring emergency dental triage, our gentle team at 1078 Warwick Road is here to assist you.',
                'image' => '/uploads/home/surgery-clinic.jpg',
                'triage_label' => 'Direct Clinical Triage',
                'triage_phone' => '0121 765 2870',
                'badges' => [
                    ['icon' => 'local_parking', 'label' => 'Free On-Site Patient Parking'],
                    ['icon' => 'directions_subway', 'label' => '5 Mins from Acocks Green Station'],
                    ['icon' => 'accessible', 'label' => 'Step-Free Ground Floor Access'],
                    ['icon' => 'emergency', 'label' => 'Same-Day Emergency Slots'],
                ],
            ],
            'journey_steps' => [
                ['step' => '1', 'title' => 'Immediate Clinical Triage', 'desc' => 'A dedicated receptionist reviews your clinical needs within 2 working hours. If symptoms suggest pulpitis, swelling, or infection, we prioritise same-day treatment.', 'is_active' => true],
                ['step' => '2', 'title' => 'Tailored Clinician Matching', 'desc' => 'We match your requirement with the right General Dental Council registered dentist or therapist (NHS Band 1-3 or private cosmetic clinician) at your preferred time.', 'is_active' => true],
                ['step' => '3', 'title' => 'Digital Paperwork & SMS Check-In', 'desc' => 'You receive an encrypted SMS/email to complete medical history from home on your phone — avoiding waiting room clipboard queues entirely.', 'is_active' => true],
            ],
            'reassurance_card' => [
                'title' => 'Nervous or Dental Phobic?',
                'desc' => "Haven't visited a dental surgery in years? Don't worry — we never judge. Mention your dental anxiety in the message notes, and our team will book an extra unhurried consultation with our gentlest clinicians.",
            ],
            'sections' => [
                [
                    'id' => 'sec_contact_channels',
                    'type' => 'channels_block',
                    'category' => 'prebuilt',
                    'name' => 'Communication Channels & Clinical Hours',
                    'eyebrow' => 'COMMUNICATION CHANNELS',
                    'title' => 'Immediate Ways to Connect & Clinical Hours',
                    'summary' => 'Connect directly with our dedicated Birmingham reception team, dental nurses, and clinical care coordinators.',
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'id' => 'sec_contact_form',
                    'type' => 'contact_form_block',
                    'category' => 'prebuilt',
                    'name' => 'Interactive Consultation & Triage Form',
                    'eyebrow' => 'APPOINTMENT & CLINICAL INQUIRY',
                    'title' => 'Send a Message or Request a Slot',
                    'summary' => 'Complete the form below. For acute pain or same-day emergency triage, please call us directly on 0121 765 2870.',
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'id' => 'sec_contact_directions',
                    'type' => 'directions_block',
                    'category' => 'prebuilt',
                    'name' => 'Finding Us, Transport & Map',
                    'eyebrow' => 'LOCATION & ACCESSIBILITY',
                    'title' => 'Finding Us: Transport & Dedicated Parking',
                    'summary' => 'Situated on the bustling Warwick Road (A41), our dental practice is conveniently positioned for patients across Acocks Green, Hall Green, Solihull, and Greater Birmingham.',
                    'is_active' => true,
                    'order' => 3,
                ],
            ],
            'seo' => [
                'meta_title' => 'Contact Us & Location | Acocks Green Dental Practice Birmingham B27',
                'meta_description' => 'Contact Acocks Green Dental Practice at 1078 Warwick Road, Birmingham B27 6BH. Call 0121 765 2870 or send an online appointment enquiry.',
                'keywords' => 'contact dentist birmingham b27, acocks green dental practice phone, emergency dental triage',
            ],
        ];
    }
}
