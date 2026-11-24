<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Uploader;
use App\Services\CmsService;
use App\Services\ThemeService;

class PagesController
{
    public function index(): void
    {
        Auth::requireAuth();

        $pages = CmsService::getPages();
        $theme = ThemeService::getTheme();

        App::render('admin/pages/index', [
            'pages' => $pages,
            'theme' => $theme,
            'pageTitle' => 'CMS Website Pages Manager',
            'activeNav' => 'pages',
        ]);
    }

    public function editHome(): void
    {
        Auth::requireAuth();

        $homeData = CmsService::getHomePageData();
        $theme = ThemeService::getTheme();

        App::render('admin/pages/home-editor', [
            'home' => $homeData,
            'theme' => $theme,
            'pageTitle' => 'Homepage Content & Visual Asset Editor',
            'activeNav' => 'pages',
        ]);
    }

    public function updateHome(): void
    {
        Auth::requireAuth();

        $home = CmsService::getHomePageData();

        // ----------------------------------------------------
        // 1. HERO BANNER
        // ----------------------------------------------------
        if (isset($_POST['hero_eyebrow'])) {
            $home['hero']['eyebrow'] = trim($_POST['hero_eyebrow']);
        }
        if (isset($_POST['hero_title'])) {
            $home['hero']['title'] = trim($_POST['hero_title']);
        }
        if (isset($_POST['hero_highlight_word'])) {
            $home['hero']['highlight_word'] = trim($_POST['hero_highlight_word']);
        }
        if (isset($_POST['hero_subtitle'])) {
            $home['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        }
        if (isset($_POST['hero_phone'])) {
            $home['hero']['phone'] = trim($_POST['hero_phone']);
        }
        if (isset($_POST['hero_emergency_label'])) {
            $home['hero']['emergency_label'] = trim($_POST['hero_emergency_label']);
        }

        // Hero Stats
        if (isset($_POST['stat_labels']) && is_array($_POST['stat_labels'])) {
            $stats = [];
            foreach ($_POST['stat_labels'] as $idx => $label) {
                $val = $_POST['stat_values'][$idx] ?? '';
                if (trim($label) !== '' || trim($val) !== '') {
                    $stats[] = ['label' => trim($label), 'value' => trim($val)];
                }
            }
            if (!empty($stats)) {
                $home['hero']['stats'] = $stats;
            }
        }

        // Hero Image File Upload
        if (!empty($_FILES['hero_image_file']['name'])) {
            $heroImgUrl = Uploader::uploadImage($_FILES['hero_image_file'], 'hero');
            if ($heroImgUrl) {
                $home['hero']['hero_image'] = $heroImgUrl;
            }
        } elseif (!empty($_POST['hero_image_manual'])) {
            $home['hero']['hero_image'] = trim($_POST['hero_image_manual']);
        }

        // ----------------------------------------------------
        // 2. SERVICES SECTION
        // ----------------------------------------------------
        if (isset($_POST['services_eyebrow'])) {
            $home['services_intro']['eyebrow'] = trim($_POST['services_eyebrow']);
        }
        if (isset($_POST['services_title'])) {
            $home['services_intro']['title'] = trim($_POST['services_title']);
        }
        if (isset($_POST['services_subtitle'])) {
            $home['services_intro']['subtitle'] = trim($_POST['services_subtitle']);
        }

        if (isset($_POST['service_titles']) && is_array($_POST['service_titles'])) {
            $services = [];
            foreach ($_POST['service_titles'] as $idx => $title) {
                $services[] = [
                    'id' => $idx + 1,
                    'title' => trim($title),
                    'slug' => $_POST['service_slugs'][$idx] ?? ('service-' . ($idx + 1)),
                    'category' => $_POST['service_categories'][$idx] ?? 'Dental Care',
                    'badge' => $_POST['service_badges'][$idx] ?? 'Standard',
                    'description' => $_POST['service_descriptions'][$idx] ?? '',
                    'icon' => $_POST['service_icons'][$idx] ?? 'dentistry',
                ];
            }
            $home['featured_services'] = $services;
        }

        // ----------------------------------------------------
        // 3. ABOUT OUR TEAM
        // ----------------------------------------------------
        if (isset($_POST['about_eyebrow'])) {
            $home['about_summary']['eyebrow'] = trim($_POST['about_eyebrow']);
        }
        if (isset($_POST['about_title'])) {
            $home['about_summary']['title'] = trim($_POST['about_title']);
        }
        if (isset($_POST['about_subtitle'])) {
            $home['about_summary']['subtitle'] = trim($_POST['about_subtitle']);
        }
        if (isset($_POST['about_experience_years'])) {
            $home['about_summary']['experience_years'] = trim($_POST['about_experience_years']);
        }
        if (isset($_POST['about_story_p1'])) {
            $home['about_summary']['story_paragraphs'][0] = trim($_POST['about_story_p1']);
        }
        if (isset($_POST['about_story_p2'])) {
            $home['about_summary']['story_paragraphs'][1] = trim($_POST['about_story_p2']);
        }

        // About Image 1 Upload
        if (!empty($_FILES['about_image_1_file']['name'])) {
            $aboutImg1 = Uploader::uploadImage($_FILES['about_image_1_file'], 'about_surgery');
            if ($aboutImg1) {
                $home['about_summary']['image_1'] = $aboutImg1;
            }
        } elseif (!empty($_POST['about_image_1_manual'])) {
            $home['about_summary']['image_1'] = trim($_POST['about_image_1_manual']);
        }

        // About Image 2 Upload
        if (!empty($_FILES['about_image_2_file']['name'])) {
            $aboutImg2 = Uploader::uploadImage($_FILES['about_image_2_file'], 'about_operatory');
            if ($aboutImg2) {
                $home['about_summary']['image_2'] = $aboutImg2;
            }
        } elseif (!empty($_POST['about_image_2_manual'])) {
            $home['about_summary']['image_2'] = trim($_POST['about_image_2_manual']);
        }

        // ----------------------------------------------------
        // 4. CLINICIANS & DOCTORS
        // ----------------------------------------------------
        if (isset($_POST['doctor_names']) && is_array($_POST['doctor_names'])) {
            $clinicians = [];
            foreach ($_POST['doctor_names'] as $idx => $name) {
                // Check if specific doctor avatar file was uploaded
                $avatarUrl = $home['clinicians'][$idx]['avatar'] ?? App::url('/images/doctor-das.jpg');
                if (!empty($_FILES['doctor_avatar_files']['name'][$idx])) {
                    $singleFile = [
                        'name' => $_FILES['doctor_avatar_files']['name'][$idx],
                        'type' => $_FILES['doctor_avatar_files']['type'][$idx],
                        'tmp_name' => $_FILES['doctor_avatar_files']['tmp_name'][$idx],
                        'error' => $_FILES['doctor_avatar_files']['error'][$idx],
                        'size' => $_FILES['doctor_avatar_files']['size'][$idx],
                    ];
                    $uploaded = Uploader::uploadImage($singleFile, 'doctor_' . ($idx + 1));
                    if ($uploaded) {
                        $avatarUrl = $uploaded;
                    }
                } elseif (!empty($_POST['doctor_avatars_manual'][$idx])) {
                    $avatarUrl = trim($_POST['doctor_avatars_manual'][$idx]);
                }

                $clinicians[] = [
                    'id' => $idx + 1,
                    'name' => trim($name),
                    'title' => trim($_POST['doctor_titles'][$idx] ?? 'Dental Surgeon'),
                    'badge' => trim($_POST['doctor_badges'][$idx] ?? 'Dentist'),
                    'avatar' => $avatarUrl,
                    'bio' => trim($_POST['doctor_bios'][$idx] ?? ''),
                ];
            }
            $home['clinicians'] = $clinicians;
        }

        // ----------------------------------------------------
        // 5. TESTIMONIALS
        // ----------------------------------------------------
        if (isset($_POST['testimonial_rating'])) {
            $home['testimonials']['average_rating'] = (float)$_POST['testimonial_rating'];
        }
        if (isset($_POST['testimonial_count'])) {
            $home['testimonials']['total_reviews'] = (int)$_POST['testimonial_count'];
        }

        // ----------------------------------------------------
        // 6. SAFETY CHARTER
        // ----------------------------------------------------
        if (isset($_POST['charter_title'])) {
            $home['safety_charter']['title'] = trim($_POST['charter_title']);
        }
        if (isset($_POST['charter_description'])) {
            $home['safety_charter']['description'] = trim($_POST['charter_description']);
        }
        if (isset($_POST['charter_link'])) {
            $home['safety_charter']['link_url'] = trim($_POST['charter_link']);
        }

        // ----------------------------------------------------
        // 7. CLINIC CONTACT & MAP
        // ----------------------------------------------------
        if (isset($_POST['contact_title'])) {
            $home['contact_section']['title'] = trim($_POST['contact_title']);
        }
        if (isset($_POST['contact_address'])) {
            $home['contact_section']['address'] = trim($_POST['contact_address']);
        }
        if (isset($_POST['contact_phone'])) {
            $home['contact_section']['phone'] = trim($_POST['contact_phone']);
        }
        if (isset($_POST['contact_email'])) {
            $home['contact_section']['email'] = trim($_POST['contact_email']);
        }

        // Map Image Upload
        if (!empty($_FILES['map_image_file']['name'])) {
            $mapImg = Uploader::uploadImage($_FILES['map_image_file'], 'map_location');
            if ($mapImg) {
                $home['contact_section']['map_image'] = $mapImg;
            }
        } elseif (!empty($_POST['map_image_manual'])) {
            $home['contact_section']['map_image'] = trim($_POST['map_image_manual']);
        }

        CmsService::saveHomePageData($home);

        App::redirect('/admin/pages/home/edit', [
            'success' => 'Homepage content and visual assets saved successfully! Changes are immediately live on the website.',
        ]);
    }
}
