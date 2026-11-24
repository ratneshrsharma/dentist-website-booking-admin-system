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
        if (isset($_POST['hero_title']) || isset($_POST['hero_headline'])) {
            $hTitle = trim($_POST['hero_title'] ?? $_POST['hero_headline'] ?? '');
            $home['hero']['title'] = $hTitle;
            $home['hero']['headline'] = $hTitle;
        }
        if (isset($_POST['hero_highlight_word']) || isset($_POST['hero_headline_highlight'])) {
            $hHigh = trim($_POST['hero_highlight_word'] ?? $_POST['hero_headline_highlight'] ?? '');
            $home['hero']['highlight_word'] = $hHigh;
            $home['hero']['headline_highlight'] = $hHigh;
        }
        if (isset($_POST['hero_subtitle'])) {
            $home['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        }
        if (isset($_POST['hero_cta_primary'])) {
            $home['hero']['cta_primary'] = trim($_POST['hero_cta_primary']);
        }
        if (isset($_POST['hero_cta_primary_link'])) {
            $home['hero']['cta_primary_link'] = trim($_POST['hero_cta_primary_link']);
        }
        if (isset($_POST['hero_cta_secondary'])) {
            $home['hero']['cta_secondary'] = trim($_POST['hero_cta_secondary']);
        }
        if (isset($_POST['hero_cta_secondary_link'])) {
            $home['hero']['cta_secondary_link'] = trim($_POST['hero_cta_secondary_link']);
        }
        if (isset($_POST['hero_phone'])) {
            $home['hero']['phone'] = trim($_POST['hero_phone']);
        }
        if (isset($_POST['hero_emergency_label'])) {
            $home['hero']['emergency_label'] = trim($_POST['hero_emergency_label']);
        }

        // Hero Stats with is_active toggles
        if (isset($_POST['stat_labels']) && is_array($_POST['stat_labels'])) {
            $stats = [];
            foreach ($_POST['stat_labels'] as $idx => $label) {
                $val = $_POST['stat_values'][$idx] ?? '';
                $isActive = isset($_POST['stat_active']) && in_array((string)$idx, $_POST['stat_active'], true);
                if (trim($label) !== '' || trim($val) !== '') {
                    $stats[] = [
                        'label' => trim($label),
                        'value' => trim($val),
                        'is_active' => $isActive,
                    ];
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

        // ----------------------------------------------------
        // 8. DYNAMIC PAGE SECTIONS COMPOSITION
        // ----------------------------------------------------
        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            $parsedSections = [];
            foreach ($_POST['sections'] as $idx => $sec) {
                $secId = trim($sec['id'] ?? ('sec_' . ($idx + 1)));
                $secType = trim($sec['type'] ?? 'custom_content');
                $secCat = trim($sec['category'] ?? 'custom_content');
                $secName = trim($sec['name'] ?? $sec['title'] ?? 'Section');
                $eyebrow = trim($sec['eyebrow'] ?? '');
                $title = trim($sec['title'] ?? '');
                $summary = trim($sec['summary'] ?? '');
                $desc = trim($sec['description'] ?? '');
                $layout = trim($sec['layout'] ?? 'thumbnail');
                $imgPos = trim($sec['image_position'] ?? 'right');
                $colLayout = trim($sec['column_layout'] ?? 'two_col_split');
                $ctaText = trim($sec['cta_text'] ?? '');
                $ctaLink = trim($sec['cta_link'] ?? '');
                $isActive = isset($sec['is_active']) && ($sec['is_active'] === '1' || $sec['is_active'] === 'on' || $sec['is_active'] === true);
                $order = (int)($sec['order'] ?? ($idx + 1));
                $featureImg = trim($sec['feature_image'] ?? '');

                if (!empty($_FILES['section_image_files']['name'][$idx])) {
                    $singleFile = [
                        'name' => $_FILES['section_image_files']['name'][$idx],
                        'type' => $_FILES['section_image_files']['type'][$idx],
                        'tmp_name' => $_FILES['section_image_files']['tmp_name'][$idx],
                        'error' => $_FILES['section_image_files']['error'][$idx],
                        'size' => $_FILES['section_image_files']['size'][$idx],
                    ];
                    $up = Uploader::uploadImage($singleFile, 'sec_' . $secId);
                    if ($up) {
                        $featureImg = $up;
                    }
                }

                // Background & Creative Section Styling
                $bgType = trim($sec['bg_type'] ?? 'default');
                $bgColor = trim($sec['bg_color'] ?? '#ffffff');
                $bgGradStart = trim($sec['bg_gradient_start'] ?? '#094713');
                $bgGradEnd = trim($sec['bg_gradient_end'] ?? '#15803d');
                $bgGradAngle = trim($sec['bg_gradient_angle'] ?? '135deg');
                $bgImg = trim($sec['bg_image'] ?? '');
                $bgOverlayColor = trim($sec['bg_overlay_color'] ?? '#000000');
                $bgOverlayOpacity = (float)($sec['bg_overlay_opacity'] ?? 0.6);
                $textContrast = trim($sec['text_contrast'] ?? 'auto');
                $paddingY = trim($sec['padding_y'] ?? 'normal');

                if (!empty($_FILES['section_bg_files']['name'][$idx])) {
                    $singleBg = [
                        'name' => $_FILES['section_bg_files']['name'][$idx],
                        'type' => $_FILES['section_bg_files']['type'][$idx],
                        'tmp_name' => $_FILES['section_bg_files']['tmp_name'][$idx],
                        'error' => $_FILES['section_bg_files']['error'][$idx],
                        'size' => $_FILES['section_bg_files']['size'][$idx],
                    ];
                    $upBg = Uploader::uploadImage($singleBg, 'bg_' . $secId);
                    if ($upBg) {
                        $bgImg = $upBg;
                    }
                }

                $parsedSections[] = [
                    'id' => $secId,
                    'type' => $secType,
                    'category' => $secCat,
                    'name' => $secName,
                    'page_slug' => trim($sec['page_slug'] ?? ''),
                    'eyebrow' => $eyebrow,
                    'title' => $title,
                    'summary' => $summary,
                    'description' => $desc,
                    'layout' => $layout,
                    'feature_image' => $featureImg,
                    'image_position' => $imgPos,
                    'column_layout' => $colLayout,
                    'cta_text' => $ctaText,
                    'cta_link' => $ctaLink,
                    'bg_type' => $bgType,
                    'bg_color' => $bgColor,
                    'bg_gradient_start' => $bgGradStart,
                    'bg_gradient_end' => $bgGradEnd,
                    'bg_gradient_angle' => $bgGradAngle,
                    'bg_image' => $bgImg,
                    'bg_overlay_color' => $bgOverlayColor,
                    'bg_overlay_opacity' => $bgOverlayOpacity,
                    'text_contrast' => $textContrast,
                    'padding_y' => $paddingY,
                    'is_active' => $isActive,
                    'order' => $order,
                ];
            }

            usort($parsedSections, fn($a, $b) => $a['order'] <=> $b['order']);
            $home['sections'] = $parsedSections;
        }

        CmsService::saveHomePageData($home);

        App::redirect('/admin/pages/home/edit', [
            'success' => 'Homepage content and visual assets saved successfully! Changes are immediately live on the website.',
        ]);
    }

    public function editAbout(): void
    {
        Auth::requireAuth();

        $aboutData = CmsService::getAboutPageData();
        $theme = ThemeService::getTheme();

        App::render('admin/pages/about-editor', [
            'about' => $aboutData,
            'theme' => $theme,
            'pageTitle' => 'About Page Content & Practice Standards Editor',
            'activeNav' => 'pages',
        ]);
    }

    public function updateAbout(): void
    {
        Auth::requireAuth();

        $about = CmsService::getAboutPageData();

        // 1. Hero Banner
        if (isset($_POST['hero_eyebrow'])) $about['hero']['eyebrow'] = trim($_POST['hero_eyebrow']);
        if (isset($_POST['hero_headline'])) $about['hero']['headline'] = trim($_POST['hero_headline']);
        if (isset($_POST['hero_subtitle'])) $about['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        if (isset($_POST['hero_image_caption'])) $about['hero']['image_caption'] = trim($_POST['hero_image_caption']);

        if (!empty($_FILES['hero_image_file']['name'])) {
            $up = Uploader::uploadImage($_FILES['hero_image_file'], 'about_team');
            if ($up) $about['hero']['image'] = $up;
        } elseif (!empty($_POST['hero_image_manual'])) {
            $about['hero']['image'] = trim($_POST['hero_image_manual']);
        }

        // 2. Why Us & Ethos
        if (isset($_POST['why_us_eyebrow'])) $about['why_us']['eyebrow'] = trim($_POST['why_us_eyebrow']);
        if (isset($_POST['why_us_headline'])) $about['why_us']['headline'] = trim($_POST['why_us_headline']);
        if (isset($_POST['why_us_subtitle'])) $about['why_us']['subtitle'] = trim($_POST['why_us_subtitle']);

        // Stats (4 items)
        if (isset($_POST['stats']) && is_array($_POST['stats'])) {
            $newStats = [];
            foreach ($_POST['stats'] as $st) {
                if (!empty($st['value']) && !empty($st['label'])) {
                    $newStats[] = [
                        'value' => trim($st['value']),
                        'label' => trim($st['label']),
                        'desc' => trim($st['desc'] ?? ''),
                    ];
                }
            }
            if (!empty($newStats)) {
                $about['why_us']['stats'] = $newStats;
            }
        }

        // 3. Our Clinics & Surgeries
        if (isset($_POST['clinics_eyebrow'])) $about['clinics']['eyebrow'] = trim($_POST['clinics_eyebrow']);
        if (isset($_POST['clinics_headline'])) $about['clinics']['headline'] = trim($_POST['clinics_headline']);
        if (isset($_POST['clinics_subtitle'])) $about['clinics']['subtitle'] = trim($_POST['clinics_subtitle']);
        if (isset($_POST['clinics_surgery_title'])) $about['clinics']['surgery_title'] = trim($_POST['clinics_surgery_title']);
        if (isset($_POST['clinics_surgery_desc'])) $about['clinics']['surgery_desc'] = trim($_POST['clinics_surgery_desc']);

        if (!empty($_FILES['clinics_image_file']['name'])) {
            $upC = Uploader::uploadImage($_FILES['clinics_image_file'], 'about_surgery');
            if ($upC) $about['clinics']['surgery_image'] = $upC;
        } elseif (!empty($_POST['clinics_image_manual'])) {
            $about['clinics']['surgery_image'] = trim($_POST['clinics_image_manual']);
        }

        // 4. NHS Safety Charter
        if (isset($_POST['charter_eyebrow'])) $about['safety_charter']['eyebrow'] = trim($_POST['charter_eyebrow']);
        if (isset($_POST['charter_headline'])) $about['safety_charter']['headline'] = trim($_POST['charter_headline']);
        if (isset($_POST['charter_subtitle'])) $about['safety_charter']['subtitle'] = trim($_POST['charter_subtitle']);

        // 5. SEO Metadata
        if (isset($_POST['meta_title'])) $about['seo']['meta_title'] = trim($_POST['meta_title']);
        if (isset($_POST['meta_description'])) $about['seo']['meta_description'] = trim($_POST['meta_description']);
        if (isset($_POST['keywords'])) $about['seo']['keywords'] = trim($_POST['keywords']);

        CmsService::saveAboutPageData($about);

        App::redirect('/admin/pages/about-us/edit', [
            'success' => 'About page content and practice standards saved successfully! Changes are immediately live on the website.',
        ]);
    }
}
