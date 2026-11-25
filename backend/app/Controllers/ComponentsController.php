<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Uploader;
use App\Services\CmsService;
use App\Services\ThemeService;
use App\Services\ServicesService;

/**
 * Controller for Managing Common Atomic UI Components
 * (Services Grid, About/Photos, Doctors, Testimonials, Safety Charter, Hours & Map)
 */
class ComponentsController
{
    /**
     * 1. Services Master Table & Inner Pages CRUD
     */
    public function services(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();
        $services = ServicesService::getAllServices();

        App::render('admin/components/services', [
            'home' => $home,
            'services' => $services,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — Clinical Services Catalog',
            'activeNav' => 'comp-services',
        ]);
    }

    /**
     * Create New Service Form & Handler
     */
    public function createService(): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $featureImg = trim($_POST['feature_image'] ?? '');
            if (!empty($_FILES['feature_image_file']['name'])) {
                $upUrl = Uploader::uploadImage($_FILES['feature_image_file'], 'service', 'services');
                if ($upUrl) {
                    $featureImg = $upUrl;
                }
            }

            $data = $this->parseServiceFormData($featureImg);

            ServicesService::createService($data);
            App::flash('success', 'New clinical service created successfully.');
            App::redirect('/admin/components/services');
        }

        App::render('admin/components/service-form', [
            'service' => null,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Add New Clinical Service',
            'activeNav' => 'comp-services',
        ]);
    }

    /**
     * Edit Existing Service Form & Handler
     */
    public function editService(int $id): void
    {
        Auth::requireAuth();
        $service = ServicesService::getServiceById($id);
        if (!$service) {
            App::flash('error', 'Service not found.');
            App::redirect('/admin/components/services');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $featureImg = trim($_POST['feature_image'] ?? ($service['feature_image'] ?? ''));
            if (!empty($_FILES['feature_image_file']['name'])) {
                $upUrl = Uploader::uploadImage($_FILES['feature_image_file'], 'service', 'services');
                if ($upUrl) {
                    $featureImg = $upUrl;
                }
            }

            $data = $this->parseServiceFormData($featureImg);

            ServicesService::updateService($id, $data);
            App::flash('success', 'Service "' . $data['title'] . '" updated successfully.');
            App::redirect('/admin/components/services');
        }

        App::render('admin/components/service-form', [
            'service' => $service,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Edit Service — ' . ($service['title'] ?? ''),
            'activeNav' => 'comp-services',
        ]);
    }

    private function parseServiceFormData(string $featureImg): array
    {
        $included = [];
        if (isset($_POST['included_items']) && is_array($_POST['included_items'])) {
            foreach ($_POST['included_items'] as $inc) {
                if (trim($inc['title'] ?? '') !== '') {
                    $included[] = [
                        'icon' => trim($inc['icon'] ?? 'clinical_notes'),
                        'title' => trim($inc['title']),
                        'desc' => trim($inc['desc'] ?? ''),
                        'is_active' => !empty($inc['is_active']),
                    ];
                }
            }
        }

        $journey = [];
        if (isset($_POST['journey_steps']) && is_array($_POST['journey_steps'])) {
            foreach ($_POST['journey_steps'] as $jIdx => $js) {
                if (trim($js['title'] ?? '') !== '') {
                    $journey[] = [
                        'step' => trim($js['step'] ?? sprintf('%02d', $jIdx + 1)),
                        'title' => trim($js['title']),
                        'desc' => trim($js['desc'] ?? ''),
                        'is_active' => !empty($js['is_active']),
                    ];
                }
            }
        }

        $pricing = [];
        if (isset($_POST['pricing_options']) && is_array($_POST['pricing_options'])) {
            foreach ($_POST['pricing_options'] as $po) {
                if (trim($po['title'] ?? '') !== '') {
                    $featuresRaw = trim($po['features_text'] ?? '');
                    $features = $featuresRaw !== ''
                        ? array_values(array_filter(array_map('trim', explode("\n", $featuresRaw))))
                        : ($po['features'] ?? []);
                    $pricing[] = [
                        'title' => trim($po['title']),
                        'badge' => trim($po['badge'] ?? ''),
                        'price' => trim($po['price'] ?? ''),
                        'features' => $features,
                        'is_featured' => !empty($po['is_featured']),
                        'is_active' => !empty($po['is_active']),
                    ];
                }
            }
        }

        $faqs = [];
        if (isset($_POST['faqs']) && is_array($_POST['faqs'])) {
            foreach ($_POST['faqs'] as $fq) {
                if (trim($fq['question'] ?? '') !== '') {
                    $faqs[] = [
                        'question' => trim($fq['question']),
                        'answer' => trim($fq['answer'] ?? ''),
                        'is_active' => !empty($fq['is_active']),
                    ];
                }
            }
        }

        return [
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'category' => trim($_POST['category'] ?? 'General Dentistry'),
            'badge' => trim($_POST['badge'] ?? ''),
            'eyebrow' => trim($_POST['eyebrow'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'icon' => trim($_POST['icon'] ?? 'dentistry'),
            'feature_image' => $featureImg,
            'starting_price' => trim($_POST['starting_price'] ?? ''),
            'duration' => trim($_POST['duration'] ?? ''),
            'cdt_code' => trim($_POST['cdt_code'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 1),
            'is_active' => isset($_POST['is_active']),
            'included_items' => $included,
            'journey_steps' => $journey,
            'pricing_options' => $pricing,
            'faqs' => $faqs,
            'section_flags' => [
                'show_included' => !empty($_POST['section_flags']['show_included']),
                'show_journey' => !empty($_POST['section_flags']['show_journey']),
                'show_pricing' => !empty($_POST['section_flags']['show_pricing']),
                'show_faqs' => !empty($_POST['section_flags']['show_faqs']),
            ],
        ];
    }

    /**
     * View Service Details
     */
    public function viewService(int $id): void
    {
        Auth::requireAuth();
        $service = ServicesService::getServiceById($id);
        if (!$service) {
            App::flash('error', 'Service not found.');
            App::redirect('/admin/components/services');
        }

        App::render('admin/components/service-view', [
            'service' => $service,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'View Service — ' . ($service['title'] ?? ''),
            'activeNav' => 'comp-services',
        ]);
    }

    /**
     * Toggle Active/Inactive Status
     */
    public function toggleService(int $id): void
    {
        Auth::requireAuth();
        ServicesService::toggleStatus($id);
        App::redirect('/admin/components/services', [
            'success' => 'Service status updated successfully.'
        ]);
    }

    /**
     * Delete Service
     */
    public function deleteService(int $id): void
    {
        Auth::requireAuth();
        ServicesService::deleteService($id);
        App::redirect('/admin/components/services', [
            'success' => 'Service permanently deleted.'
        ]);
    }

    /**
     * Reorder Services from Table Inputs
     */
    public function reorderServices(): void
    {
        Auth::requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = $_POST['service_ids'] ?? [];
            $orders = $_POST['display_orders'] ?? [];

            if (is_array($ids) && is_array($orders)) {
                // Pair and sort by numerical order
                $pairs = [];
                foreach ($ids as $idx => $id) {
                    $pairs[] = [
                        'id' => (int)$id,
                        'order' => (int)($orders[$idx] ?? 1),
                    ];
                }
                usort($pairs, fn($a, $b) => $a['order'] <=> $b['order']);
                $orderedIds = array_column($pairs, 'id');
                ServicesService::reorderServices($orderedIds);
            }
        }
        App::redirect('/admin/components/services', [
            'success' => 'Services custom display orders saved successfully.'
        ]);
    }

    /**
     * Save Section Intro Settings
     */
    public function saveServiceIntro(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if (isset($_POST['component_id'])) {
            $home['services_intro']['component_id'] = trim($_POST['component_id']);
        }
        if (isset($_POST['custom_class'])) {
            $home['services_intro']['custom_class'] = trim($_POST['custom_class']);
        }
        if (isset($_POST['eyebrow'])) {
            $home['services_intro']['eyebrow'] = trim($_POST['eyebrow']);
        }
        if (isset($_POST['title'])) {
            $home['services_intro']['title'] = trim($_POST['title']);
        }
        if (isset($_POST['subtitle'])) {
            $home['services_intro']['subtitle'] = trim($_POST['subtitle']);
        }

        CmsService::saveHomePageData($home);
        App::redirect('/admin/components/services', [
            'success' => 'Services section intro settings saved successfully.'
        ]);
    }

    /**
     * 2. About & Clinic Photos Component
     */
    public function about(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $about = $home['about_summary'] ?? [];

            $about['component_id'] = trim($_POST['component_id'] ?? 'about-surgery');
            $about['custom_class'] = trim($_POST['custom_class'] ?? '');
            $about['slug'] = trim($_POST['slug'] ?? 'about-us');
            $about['eyebrow'] = trim($_POST['eyebrow'] ?? '');
            $about['title'] = trim($_POST['title'] ?? '');
            $about['subtitle'] = trim($_POST['subtitle'] ?? '');
            $about['experience_years'] = trim($_POST['experience_years'] ?? '20+');
            $about['patients_served'] = trim($_POST['patients_served'] ?? '5,000+');
            $about['is_active'] = isset($_POST['is_active']);

            if (!empty($_POST['story_paragraphs'])) {
                $paras = array_filter(array_map('trim', explode("\n", (string)$_POST['story_paragraphs'])));
                $about['story_paragraphs'] = array_values($paras);
            }

            // Image 1 upload
            if (!empty($_FILES['image_1_file']['name'])) {
                $up1 = Uploader::uploadImage($_FILES['image_1_file'], 'about');
                if ($up1) $about['image_1'] = $up1;
            } elseif (!empty($_POST['image_1_manual'])) {
                $about['image_1'] = trim($_POST['image_1_manual']);
            }

            // Image 2 upload
            if (!empty($_FILES['image_2_file']['name'])) {
                $up2 = Uploader::uploadImage($_FILES['image_2_file'], 'about');
                if ($up2) $about['image_2'] = $up2;
            } elseif (!empty($_POST['image_2_manual'])) {
                $about['image_2'] = trim($_POST['image_2_manual']);
            }

            $home['about_summary'] = $about;
            CmsService::saveHomePageData($home);
            App::flash('success', 'About & Clinic Photos component updated successfully.');
            App::redirect('/admin/components/about');
        }

        App::render('admin/components/about', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — About & Clinic Photos',
            'activeNav' => 'comp-about',
        ]);
    }

    /**
     * 3. Doctors & Avatars Component
     */
    public function doctors(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clinician_names']) && is_array($_POST['clinician_names'])) {
                $clinicians = [];
                foreach ($_POST['clinician_names'] as $idx => $name) {
                    $avatar = $_POST['clinician_avatars'][$idx] ?? '';
                    if (!empty($_FILES['clinician_avatar_files']['name'][$idx])) {
                        $fileItem = [
                            'name' => $_FILES['clinician_avatar_files']['name'][$idx],
                            'type' => $_FILES['clinician_avatar_files']['type'][$idx],
                            'tmp_name' => $_FILES['clinician_avatar_files']['tmp_name'][$idx],
                            'error' => $_FILES['clinician_avatar_files']['error'][$idx],
                            'size' => $_FILES['clinician_avatar_files']['size'][$idx],
                        ];
                        $upUrl = Uploader::uploadImage($fileItem, 'doctors');
                        if ($upUrl) {
                            $avatar = $upUrl;
                        }
                    }

                    $isActive = isset($_POST['clinician_active']) && in_array((string)$idx, $_POST['clinician_active'], true);

                    $clinicians[] = [
                        'id' => (int)($_POST['clinician_ids'][$idx] ?? ($idx + 1)),
                        'name' => trim($name),
                        'title' => trim($_POST['clinician_titles'][$idx] ?? ''),
                        'badge' => trim($_POST['clinician_badges'][$idx] ?? ''),
                        'avatar' => $avatar,
                        'bio' => trim($_POST['clinician_bios'][$idx] ?? ''),
                        'is_active' => $isActive,
                    ];
                }
                $home['clinicians'] = $clinicians;
            }

            CmsService::saveHomePageData($home);
            App::flash('success', 'Doctors & Avatars component updated successfully.');
            App::redirect('/admin/components/doctors');
        }

        App::render('admin/components/doctors', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — Doctors & Avatars',
            'activeNav' => 'comp-doctors',
        ]);
    }

    /**
     * 4. Testimonials Component
     */
    public function testimonials(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $testi = $home['testimonials'] ?? [];
            if (isset($_POST['average_rating'])) {
                $testi['average_rating'] = (float)$_POST['average_rating'];
            }
            if (isset($_POST['total_reviews'])) {
                $testi['total_reviews'] = (int)$_POST['total_reviews'];
            }
            $testi['is_active'] = isset($_POST['is_active']);

            // Google Reviews Connection Settings
            $testi['google_place_id'] = trim($_POST['google_place_id'] ?? '');
            $testi['google_reviews_url'] = trim($_POST['google_reviews_url'] ?? 'https://g.page/review');
            $testi['google_auto_sync'] = isset($_POST['google_auto_sync']);
            $testi['google_min_rating'] = (int)($_POST['google_min_rating'] ?? 4);

            if (isset($_POST['review_names']) && is_array($_POST['review_names'])) {
                $items = [];
                foreach ($_POST['review_names'] as $idx => $rName) {
                    if (trim($rName) === '') continue;
                    $isActive = isset($_POST['review_active']) && in_array((string)$idx, $_POST['review_active'], true);
                    $items[] = [
                        'id' => $idx + 1,
                        'name' => trim($rName),
                        'location' => trim($_POST['review_locations'][$idx] ?? ''),
                        'treatment' => trim($_POST['review_treatments'][$idx] ?? ''),
                        'rating' => (int)($_POST['review_ratings'][$idx] ?? 5),
                        'comment' => trim($_POST['review_comments'][$idx] ?? ''),
                        'is_active' => $isActive,
                        'order' => (int)($_POST['review_orders'][$idx] ?? ($idx + 1)),
                    ];
                }
                // Sort by order
                usort($items, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
                $testi['items'] = $items;
            }

            $home['testimonials'] = $testi;
            CmsService::saveHomePageData($home);
            App::redirect('/admin/components/testimonials', [
                'success' => 'Patient testimonials and Google Reviews connection saved successfully.'
            ]);
        }

        App::render('admin/components/testimonials', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — Patient Testimonials',
            'activeNav' => 'comp-testimonials',
        ]);
    }

    /**
     * 5. Safety Charter Component
     */
    public function charter(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $charter = $home['safety_charter'] ?? [];
            $charter['component_id'] = trim($_POST['component_id'] ?? 'safety-charter');
            $charter['custom_class'] = trim($_POST['custom_class'] ?? '');
            $charter['title'] = trim($_POST['title'] ?? '');
            $charter['description'] = trim($_POST['description'] ?? '');
            $charter['badge'] = trim($_POST['badge'] ?? 'Official NHS Charter');
            $charter['link_text'] = trim($_POST['link_text'] ?? 'Read Our Safety Standards');
            $charter['link_url'] = trim($_POST['link_url'] ?? '');
            $charter['is_active'] = isset($_POST['is_active']);

            $home['safety_charter'] = $charter;
            CmsService::saveHomePageData($home);
            App::flash('success', 'Safety Charter component updated successfully.');
            App::redirect('/admin/components/charter');
        }

        App::render('admin/components/charter', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — NHS Safety Charter',
            'activeNav' => 'comp-charter',
        ]);
    }

    /**
     * 6. Hours & Map Component
     */
    public function contact(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact = $home['contact_section'] ?? [];
            $contact['component_id'] = trim($_POST['component_id'] ?? 'clinic-hours-map');
            $contact['custom_class'] = trim($_POST['custom_class'] ?? '');
            $contact['title'] = trim($_POST['title'] ?? '');
            $contact['address'] = trim($_POST['address'] ?? '');
            $contact['phone'] = trim($_POST['phone'] ?? '');
            $contact['email'] = trim($_POST['email'] ?? '');
            $contact['is_active'] = isset($_POST['is_active']);

            // Map image upload
            if (!empty($_FILES['map_image_file']['name'])) {
                $upMap = Uploader::uploadImage($_FILES['map_image_file'], 'map');
                if ($upMap) $contact['map_image'] = $upMap;
            } elseif (!empty($_POST['map_image_manual'])) {
                $contact['map_image'] = trim($_POST['map_image_manual']);
            }

            if (isset($_POST['hours_days']) && is_array($_POST['hours_days'])) {
                $hours = [];
                foreach ($_POST['hours_days'] as $idx => $days) {
                    $hours[] = [
                        'day_range' => trim($days),
                        'hours' => trim($_POST['hours_times'][$idx] ?? ''),
                    ];
                }
                $contact['hours'] = $hours;
            }

            $home['contact_section'] = $contact;
            CmsService::saveHomePageData($home);
            App::flash('success', 'Hours & Map component updated successfully.');
            App::redirect('/admin/components/contact');
        }

        App::render('admin/components/contact', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — Hours & Map',
            'activeNav' => 'comp-contact',
        ]);
    }
}
