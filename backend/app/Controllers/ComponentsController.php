<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Uploader;
use App\Services\CmsService;
use App\Services\ThemeService;

/**
 * Controller for Managing Common Atomic UI Components
 * (Services Grid, About/Photos, Doctors, Testimonials, Safety Charter, Hours & Map)
 */
class ComponentsController
{
    /**
     * 1. Services Grid Component
     */
    public function services(): void
    {
        Auth::requireAuth();
        $home = CmsService::getHomePageData();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $home['services_intro']['is_active'] = isset($_POST['is_active']);

            if (isset($_POST['service_titles']) && is_array($_POST['service_titles'])) {
                $services = [];
                foreach ($_POST['service_titles'] as $idx => $title) {
                    $featureImg = $_POST['service_images'][$idx] ?? '';
                    if (!empty($_FILES['service_image_files']['name'][$idx])) {
                        $fileItem = [
                            'name' => $_FILES['service_image_files']['name'][$idx],
                            'type' => $_FILES['service_image_files']['type'][$idx],
                            'tmp_name' => $_FILES['service_image_files']['tmp_name'][$idx],
                            'error' => $_FILES['service_image_files']['error'][$idx],
                            'size' => $_FILES['service_image_files']['size'][$idx],
                        ];
                        $upUrl = Uploader::uploadImage($fileItem, 'services');
                        if ($upUrl) {
                            $featureImg = $upUrl;
                        }
                    }

                    $isActive = isset($_POST['service_active']) && in_array((string)$idx, $_POST['service_active'], true);

                    $services[] = [
                        'id' => (int)($_POST['service_ids'][$idx] ?? ($idx + 1)),
                        'slug' => trim($_POST['service_slugs'][$idx] ?? ('service-' . ($idx + 1))),
                        'title' => trim($title),
                        'category' => trim($_POST['service_categories'][$idx] ?? 'General Dentistry'),
                        'badge' => trim($_POST['service_badges'][$idx] ?? ''),
                        'description' => trim($_POST['service_descs'][$idx] ?? ''),
                        'icon' => trim($_POST['service_icons'][$idx] ?? 'dentistry'),
                        'feature_image' => $featureImg,
                        'is_active' => $isActive,
                    ];
                }
                $home['featured_services'] = $services;
            }

            CmsService::saveHomePageData($home);
            App::flash('success', 'Services Grid component updated successfully.');
            App::redirect('/admin/components/services');
        }

        App::render('admin/components/services', [
            'home' => $home,
            'theme' => ThemeService::getTheme(),
            'pageTitle' => 'Common Component — Services Grid',
            'activeNav' => 'comp-services',
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

            if (isset($_POST['review_names']) && is_array($_POST['review_names'])) {
                $items = [];
                foreach ($_POST['review_names'] as $idx => $rName) {
                    $isActive = isset($_POST['review_active']) && in_array((string)$idx, $_POST['review_active'], true);
                    $items[] = [
                        'id' => $idx + 1,
                        'name' => trim($rName),
                        'location' => trim($_POST['review_locations'][$idx] ?? ''),
                        'treatment' => trim($_POST['review_treatments'][$idx] ?? ''),
                        'rating' => (int)($_POST['review_ratings'][$idx] ?? 5),
                        'comment' => trim($_POST['review_comments'][$idx] ?? ''),
                        'is_active' => $isActive,
                    ];
                }
                $testi['items'] = $items;
            }

            $home['testimonials'] = $testi;
            CmsService::saveHomePageData($home);
            App::flash('success', 'Testimonials component updated successfully.');
            App::redirect('/admin/components/testimonials');
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
