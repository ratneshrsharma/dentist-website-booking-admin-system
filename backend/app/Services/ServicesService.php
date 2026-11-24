<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * Service to manage Dental Clinic Services (Inner Pages, CRUD, Ordering & Status)
 */
class ServicesService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/services.json';
    }

    /**
     * Verified default seed services matching Acocks Green Dental Practice
     */
    public static function getDefaultServices(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'routine-examinations',
                'title' => 'Routine Dental Examinations',
                'category' => 'General Dentistry',
                'badge' => 'Preventive',
                'summary' => 'Comprehensive soft tissue, periodontal, and tooth screenings with digital X-rays to preserve oral wellness.',
                'content' => "Our comprehensive dental examination evaluates your overall oral health, identifying any early signs of decay, gum disease, or oral pathology.\n\nDuring your appointment, our dental surgeon performs digital low-radiation radiography, periodontal probing, and an oral cancer screening. We then discuss personalized preventive recommendations tailored to your oral health goals.",
                'icon' => 'dentistry',
                'feature_image' => App::url('/images/hero-patient.jpg'),
                'starting_price' => 'NHS Band 1 (£26.80) / Private £45.00',
                'duration' => '30 mins',
                'cdt_code' => 'D0120',
                'display_order' => 1,
                'is_active' => true,
                'created_at' => '2026-11-20 09:00:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 2,
                'slug' => 'dental-hygiene-airflow',
                'title' => 'Dental Hygiene & Airflow Polish',
                'category' => 'Hygiene',
                'badge' => 'Airflow Polish',
                'summary' => 'Gentle calculus removal, plaque decontamination, and high-pressure airflow polishing for brighter smiles.',
                'content' => "Experience advanced hygiene therapy using Swiss EMS Airflow technology. High-pressure air, warm water, and fine bicarbonate powder gently remove persistent tea, coffee, and tobacco stains without scraping enamel.\n\nOur certified dental hygienist also provides tailored interdental cleaning advice and gingival health monitoring.",
                'icon' => 'clean_hands',
                'feature_image' => App::url('/images/treatment-room.jpg'),
                'starting_price' => 'From £65.00',
                'duration' => '45 mins',
                'cdt_code' => 'D1110',
                'display_order' => 2,
                'is_active' => true,
                'created_at' => '2026-11-20 09:15:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 3,
                'slug' => 'composite-white-fillings',
                'title' => 'White Tooth Fillings (Composite)',
                'category' => 'Restorations',
                'badge' => 'Composite',
                'summary' => 'Mercury-free biocompatible tooth-colored composite restorations seamlessly bonded to damaged enamel.',
                'content' => "Restore broken or decayed teeth with natural, tooth-colored composite resin. Unlike old silver amalgam fillings, modern composite bonds directly to your natural tooth structure, preserving maximum healthy enamel while remaining completely invisible when you smile.",
                'icon' => 'healing',
                'feature_image' => App::url('/images/surgery-clinic.jpg'),
                'starting_price' => 'From £95.00',
                'duration' => '45 mins',
                'cdt_code' => 'D2391',
                'display_order' => 3,
                'is_active' => true,
                'created_at' => '2026-11-20 09:30:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 4,
                'slug' => 'root-canal-therapy',
                'title' => 'Root Canal Therapy (Endodontics)',
                'category' => 'Endodontics',
                'badge' => 'Pain Relief',
                'summary' => 'Precise rotary endodontic treatments eliminating deep pulp infection while saving your natural tooth structure.',
                'content' => "When dental pulp becomes inflamed or infected due to deep decay or trauma, root canal therapy saves your natural tooth from extraction. Using rotary nickel-titanium instruments and electronic apex locators, our clinicians gently disinfect the canals with local anesthesia for a completely comfortable procedure.",
                'icon' => 'vital_signs',
                'feature_image' => App::url('/images/treatment-room.jpg'),
                'starting_price' => 'From £295.00',
                'duration' => '60 mins',
                'cdt_code' => 'D3310',
                'display_order' => 4,
                'is_active' => true,
                'created_at' => '2026-11-20 09:45:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 5,
                'slug' => 'crowns-and-bridges',
                'title' => 'Dental Crowns & Fixed Bridges',
                'category' => 'Prosthetics',
                'badge' => 'Ceramic',
                'summary' => 'High-strength monolithic zirconia and porcelain crowns designed for optimal bite force and natural aesthetics.',
                'content' => "Custom-engineered dental crowns provide 360-degree protection for weakened or fractured teeth. We utilize high-translucency monolithic zirconia and lithium disilicate (E-Max) ceramics shade-matched precisely to adjacent natural teeth.",
                'icon' => 'crown',
                'feature_image' => App::url('/images/hero-patient.jpg'),
                'starting_price' => 'From £450.00',
                'duration' => '60 mins (2 visits)',
                'cdt_code' => 'D2740',
                'display_order' => 5,
                'is_active' => true,
                'created_at' => '2026-11-20 10:00:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 6,
                'slug' => 'invisalign-clear-aligners',
                'title' => 'Invisalign® Clear Aligners',
                'category' => 'Orthodontics',
                'badge' => 'Discreet',
                'summary' => 'Virtually invisible removable orthodontic aligners gently guiding teeth into alignment without metal brackets.',
                'content' => "Straighten crowded or crooked teeth with the world's most advanced clear aligner system. Custom 3D digital treatment simulations (ClinCheck) let you preview your finished smile before treatment even begins. Aligners are removable for easy eating and brushing.",
                'icon' => 'auto_fix_high',
                'feature_image' => App::url('/images/surgery-clinic.jpg'),
                'starting_price' => 'From £1,800.00',
                'duration' => '4-12 months',
                'cdt_code' => 'D8090',
                'display_order' => 6,
                'is_active' => true,
                'created_at' => '2026-11-20 10:15:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 7,
                'slug' => 'tooth-extractions',
                'title' => 'Emergency Tooth Extraction',
                'category' => 'Oral Surgery',
                'badge' => 'Same-Day',
                'summary' => 'Atraumatic dental extractions for severely compromised or impacted teeth with local anesthesia numbness.',
                'content' => "When a tooth cannot be saved through conservative restoration, our experienced dental surgeons perform gentle atraumatic extractions designed to minimize post-operative swelling and preserve bone for future implant replacement.",
                'icon' => 'medical_services',
                'feature_image' => App::url('/images/treatment-room.jpg'),
                'starting_price' => 'From £120.00',
                'duration' => '45 mins',
                'cdt_code' => 'D7140',
                'display_order' => 7,
                'is_active' => true,
                'created_at' => '2026-11-20 10:30:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
            [
                'id' => 8,
                'slug' => 'same-day-emergency-relief',
                'title' => 'Same-Day Emergency Relief',
                'category' => 'Emergency',
                'badge' => 'Urgent Care',
                'summary' => 'Dedicated priority slots for severe toothache, abscesses, broken teeth, or sports-related dental trauma.',
                'content' => "Dental emergencies cannot wait. We reserve dedicated slots each morning and afternoon for urgent cases: severe acute toothache, cracked teeth, lost crowns, or dental facial swelling. Call our triage hotline for prompt same-day pain relief.",
                'icon' => 'e911_emergency',
                'feature_image' => App::url('/images/hero-patient.jpg'),
                'starting_price' => 'Emergency Triage £50.00',
                'duration' => '30 mins',
                'cdt_code' => 'D0140',
                'display_order' => 8,
                'is_active' => true,
                'created_at' => '2026-11-20 10:45:00',
                'updated_at' => '2026-11-24 10:00:00',
            ],
        ];
    }

    /**
     * Retrieve all services, sorted by display_order
     */
    public static function getAllServices(bool $activeOnly = false): array
    {
        $file = self::getStorageFile();
        $services = [];

        if (file_exists($file)) {
            $data = json_decode((string)file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                $services = $data;
            }
        }

        if (empty($services)) {
            $services = self::getDefaultServices();
            self::saveServices($services);
        }

        if ($activeOnly) {
            $services = array_filter($services, fn($s) => ($s['is_active'] ?? true) === true);
        }

        // Sort by display_order ASC
        usort($services, fn($a, $b) => ($a['display_order'] ?? 999) <=> ($b['display_order'] ?? 999));

        return array_values($services);
    }

    /**
     * Find single service by ID
     */
    public static function getServiceById(int $id): ?array
    {
        $services = self::getAllServices();
        foreach ($services as $s) {
            if ((int)$s['id'] === $id) {
                return $s;
            }
        }
        return null;
    }

    /**
     * Find single service by Slug
     */
    public static function getServiceBySlug(string $slug): ?array
    {
        $services = self::getAllServices();
        foreach ($services as $s) {
            if ($s['slug'] === $slug) {
                return $s;
            }
        }
        return null;
    }

    /**
     * Create a new service
     */
    public static function createService(array $data): array
    {
        $services = self::getAllServices();
        
        $maxId = 0;
        $maxOrder = 0;
        foreach ($services as $s) {
            if ((int)$s['id'] > $maxId) $maxId = (int)$s['id'];
            if ((int)($s['display_order'] ?? 0) > $maxOrder) $maxOrder = (int)$s['display_order'];
        }

        $title = trim($data['title'] ?? 'New Dental Service');
        $slug = trim($data['slug'] ?? '');
        if ($slug === '') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        }

        $newService = [
            'id' => $maxId + 1,
            'slug' => $slug,
            'title' => $title,
            'category' => trim($data['category'] ?? 'General Dentistry'),
            'badge' => trim($data['badge'] ?? ''),
            'summary' => trim($data['summary'] ?? $data['description'] ?? ''),
            'content' => trim($data['content'] ?? ''),
            'icon' => trim($data['icon'] ?? 'dentistry'),
            'feature_image' => trim($data['feature_image'] ?? ''),
            'starting_price' => trim($data['starting_price'] ?? ''),
            'duration' => trim($data['duration'] ?? ''),
            'cdt_code' => trim($data['cdt_code'] ?? ''),
            'display_order' => (int)($data['display_order'] ?? ($maxOrder + 1)),
            'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $services[] = $newService;
        self::saveServices($services);

        return $newService;
    }

    /**
     * Update an existing service
     */
    public static function updateService(int $id, array $data): bool
    {
        $services = self::getAllServices();
        $found = false;

        foreach ($services as &$s) {
            if ((int)$s['id'] === $id) {
                if (isset($data['title'])) $s['title'] = trim($data['title']);
                if (isset($data['slug'])) $s['slug'] = trim($data['slug']);
                if (isset($data['category'])) $s['category'] = trim($data['category']);
                if (isset($data['badge'])) $s['badge'] = trim($data['badge']);
                if (isset($data['summary'])) $s['summary'] = trim($data['summary']);
                if (isset($data['content'])) $s['content'] = trim($data['content']);
                if (isset($data['icon'])) $s['icon'] = trim($data['icon']);
                if (isset($data['feature_image'])) $s['feature_image'] = trim($data['feature_image']);
                if (isset($data['starting_price'])) $s['starting_price'] = trim($data['starting_price']);
                if (isset($data['duration'])) $s['duration'] = trim($data['duration']);
                if (isset($data['cdt_code'])) $s['cdt_code'] = trim($data['cdt_code']);
                if (isset($data['display_order'])) $s['display_order'] = (int)$data['display_order'];
                if (array_key_exists('is_active', $data)) $s['is_active'] = (bool)$data['is_active'];
                $s['updated_at'] = date('Y-m-d H:i:s');
                $found = true;
                break;
            }
        }

        if ($found) {
            return self::saveServices($services);
        }

        return false;
    }

    /**
     * Delete service by ID
     */
    public static function deleteService(int $id): bool
    {
        $services = self::getAllServices();
        $initialCount = count($services);
        $services = array_filter($services, fn($s) => (int)$s['id'] !== $id);

        if (count($services) !== $initialCount) {
            return self::saveServices(array_values($services));
        }

        return false;
    }

    /**
     * Toggle active/inactive status
     */
    public static function toggleStatus(int $id): bool
    {
        $services = self::getAllServices();
        $found = false;

        foreach ($services as &$s) {
            if ((int)$s['id'] === $id) {
                $s['is_active'] = !($s['is_active'] ?? true);
                $s['updated_at'] = date('Y-m-d H:i:s');
                $found = true;
                break;
            }
        }

        if ($found) {
            return self::saveServices($services);
        }

        return false;
    }

    /**
     * Reorder services based on an ordered array of IDs
     */
    public static function reorderServices(array $orderedIds): bool
    {
        $services = self::getAllServices();
        $idMap = [];
        foreach ($services as $s) {
            $idMap[(int)$s['id']] = $s;
        }

        $reordered = [];
        $order = 1;
        foreach ($orderedIds as $id) {
            $idInt = (int)$id;
            if (isset($idMap[$idInt])) {
                $idMap[$idInt]['display_order'] = $order++;
                $reordered[] = $idMap[$idInt];
                unset($idMap[$idInt]);
            }
        }

        // Append any remaining
        foreach ($idMap as $rem) {
            $rem['display_order'] = $order++;
            $reordered[] = $rem;
        }

        return self::saveServices($reordered);
    }

    /**
     * Save all services to disk
     */
    public static function saveServices(array $services): bool
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $ok = file_put_contents($file, json_encode($services, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;

        // Also sync active services into CmsService's cms_home.json featured_services
        if ($ok) {
            self::syncWithHomeCms();
        }

        return $ok;
    }

    /**
     * Synchronize services with homepage CMS data
     */
    private static function syncWithHomeCms(): void
    {
        $activeServices = self::getAllServices(true);
        $home = CmsService::getHomePageData();

        $featured = [];
        foreach ($activeServices as $s) {
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

        $home['featured_services'] = $featured;
        CmsService::saveHomePageData($home);
    }
}
