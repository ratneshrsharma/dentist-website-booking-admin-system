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
        $allPages = CmsService::getPages();

        App::render('admin/pages/home-editor', [
            'home' => $homeData,
            'theme' => $theme,
            'allPages' => $allPages,
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
            $heroImgUrl = Uploader::uploadImage($_FILES['hero_image_file'], 'hero', 'home');
            if ($heroImgUrl) {
                $home['hero']['hero_image'] = $heroImgUrl;
            }
        } elseif (!empty($_POST['hero_image_manual'])) {
            $home['hero']['hero_image'] = trim($_POST['hero_image_manual']);
        }

        // Hero Floating Badges
        if (isset($_POST['hero_badge_titles']) && is_array($_POST['hero_badge_titles'])) {
            $badges = [];
            foreach ($_POST['hero_badge_titles'] as $bIdx => $bTitle) {
                if (trim($bTitle) !== '') {
                    $badges[] = [
                        'title' => trim($bTitle),
                        'subtitle' => trim($_POST['hero_badge_subtitles'][$bIdx] ?? ''),
                        'icon' => trim($_POST['hero_badge_icons'][$bIdx] ?? 'verified'),
                    ];
                }
            }
            if (!empty($badges)) {
                $home['hero']['hero_badges'] = $badges;
            }
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
            $home['sections'] = $this->parseSectionsFromRequest($_POST['sections'], $_FILES, 'home');
        }

        // ----------------------------------------------------
        // 9. SEO & METADATA
        // ----------------------------------------------------
        if (isset($_POST['meta_title'])) {
            $home['seo']['meta_title'] = trim($_POST['meta_title']);
        }
        if (isset($_POST['meta_description'])) {
            $home['seo']['meta_description'] = trim($_POST['meta_description']);
        }
        if (isset($_POST['keywords'])) {
            $home['seo']['keywords'] = trim($_POST['keywords']);
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
        $allPages = CmsService::getPages();

        App::render('admin/pages/about-editor', [
            'about' => $aboutData,
            'theme' => $theme,
            'allPages' => $allPages,
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
        if (isset($_POST['hero_cta_primary'])) $about['hero']['cta_primary'] = trim($_POST['hero_cta_primary']);
        if (isset($_POST['hero_cta_primary_link'])) $about['hero']['cta_primary_link'] = trim($_POST['hero_cta_primary_link']);
        if (isset($_POST['hero_cta_secondary'])) $about['hero']['cta_secondary'] = trim($_POST['hero_cta_secondary']);
        if (isset($_POST['hero_cta_secondary_link'])) $about['hero']['cta_secondary_link'] = trim($_POST['hero_cta_secondary_link']);

        if (!empty($_FILES['hero_image_file']['name'])) {
            $up = Uploader::uploadImage($_FILES['hero_image_file'], 'about_team', 'about-us');
            if ($up) $about['hero']['image'] = $up;
        } elseif (!empty($_POST['hero_image_manual'])) {
            $about['hero']['image'] = trim($_POST['hero_image_manual']);
        }

        // Hero Trust Badges (4 items)
        if (isset($_POST['trust_badge_labels']) && is_array($_POST['trust_badge_labels'])) {
            $badges = [];
            foreach ($_POST['trust_badge_labels'] as $bIdx => $bLabel) {
                if (trim($bLabel) !== '') {
                    $badges[] = [
                        'icon' => trim($_POST['trust_badge_icons'][$bIdx] ?? 'verified_user'),
                        'label' => trim($bLabel),
                    ];
                }
            }
            if (!empty($badges)) {
                $about['hero']['trust_badges'] = $badges;
            }
        }

        // 2. Dynamic Page Sections Composition
        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            $parsedAboutSections = $this->parseSectionsFromRequest($_POST['sections'], $_FILES, 'about-us');
            $about['sections'] = $parsedAboutSections;

            // Keep legacy keys in sync with section headers
            foreach ($parsedAboutSections as $ps) {
                if (($ps['type'] ?? '') === 'why_us_block') {
                    $about['why_us']['eyebrow'] = $ps['eyebrow'];
                    $about['why_us']['headline'] = $ps['title'];
                    $about['why_us']['subtitle'] = $ps['summary'];
                } elseif (($ps['type'] ?? '') === 'clinics_block') {
                    $about['clinics']['eyebrow'] = $ps['eyebrow'];
                    $about['clinics']['headline'] = $ps['title'];
                    $about['clinics']['subtitle'] = $ps['summary'];
                } elseif (($ps['type'] ?? '') === 'safety_charter_cards') {
                    $about['safety_charter']['eyebrow'] = $ps['eyebrow'];
                    $about['safety_charter']['headline'] = $ps['title'];
                    $about['safety_charter']['subtitle'] = $ps['summary'];
                }
            }
        }

        // 3. Why Us & Ethos (Stats + 4 Pillars)
        if (isset($_POST['why_us_eyebrow'])) $about['why_us']['eyebrow'] = trim($_POST['why_us_eyebrow']);
        if (isset($_POST['why_us_headline'])) $about['why_us']['headline'] = trim($_POST['why_us_headline']);
        if (isset($_POST['why_us_subtitle'])) $about['why_us']['subtitle'] = trim($_POST['why_us_subtitle']);

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

        if (isset($_POST['pillars']) && is_array($_POST['pillars'])) {
            $newPillars = [];
            foreach ($_POST['pillars'] as $pl) {
                if (!empty($pl['title'])) {
                    $newPillars[] = [
                        'icon' => trim($pl['icon'] ?? 'spa'),
                        'title' => trim($pl['title']),
                        'desc' => trim($pl['desc'] ?? ''),
                        'badge' => trim($pl['badge'] ?? ''),
                    ];
                }
            }
            if (!empty($newPillars)) {
                $about['why_us']['pillars'] = $newPillars;
            }
        }

        // 4. Our Clinics & Surgeries (5 Features + Surgery Card)
        if (isset($_POST['clinics_eyebrow'])) $about['clinics']['eyebrow'] = trim($_POST['clinics_eyebrow']);
        if (isset($_POST['clinics_headline'])) $about['clinics']['headline'] = trim($_POST['clinics_headline']);
        if (isset($_POST['clinics_subtitle'])) $about['clinics']['subtitle'] = trim($_POST['clinics_subtitle']);
        if (isset($_POST['clinics_surgery_title'])) $about['clinics']['surgery_title'] = trim($_POST['clinics_surgery_title']);
        if (isset($_POST['clinics_surgery_desc'])) $about['clinics']['surgery_desc'] = trim($_POST['clinics_surgery_desc']);
        if (isset($_POST['clinics_surgery_badge'])) $about['clinics']['surgery_badge'] = trim($_POST['clinics_surgery_badge']);

        if (!empty($_FILES['clinics_image_file']['name'])) {
            $upC = Uploader::uploadImage($_FILES['clinics_image_file'], 'about_surgery', 'about-us');
            if ($upC) $about['clinics']['surgery_image'] = $upC;
        } elseif (!empty($_POST['clinics_image_manual'])) {
            $about['clinics']['surgery_image'] = trim($_POST['clinics_image_manual']);
        }

        if (isset($_POST['clinic_features']) && is_array($_POST['clinic_features'])) {
            $newFeatures = [];
            foreach ($_POST['clinic_features'] as $cf) {
                if (!empty($cf['title'])) {
                    $newFeatures[] = [
                        'icon' => trim($cf['icon'] ?? 'radiology'),
                        'title' => trim($cf['title']),
                        'desc' => trim($cf['desc'] ?? ''),
                    ];
                }
            }
            if (!empty($newFeatures)) {
                $about['clinics']['features'] = $newFeatures;
            }
        }

        // 5. NHS Safety Charter (3 Cards + Emergency Box)
        if (isset($_POST['charter_eyebrow'])) $about['safety_charter']['eyebrow'] = trim($_POST['charter_eyebrow']);
        if (isset($_POST['charter_headline'])) $about['safety_charter']['headline'] = trim($_POST['charter_headline']);
        if (isset($_POST['charter_subtitle'])) $about['safety_charter']['subtitle'] = trim($_POST['charter_subtitle']);

        if (isset($_POST['charter_cards']) && is_array($_POST['charter_cards'])) {
            $newCards = [];
            foreach ($_POST['charter_cards'] as $cc) {
                if (!empty($cc['title'])) {
                    $newCards[] = [
                        'icon' => trim($cc['icon'] ?? 'verified'),
                        'title' => trim($cc['title']),
                        'desc' => trim($cc['desc'] ?? ''),
                        'footer_label' => trim($cc['footer_label'] ?? ''),
                    ];
                }
            }
            if (!empty($newCards)) {
                $about['safety_charter']['cards'] = $newCards;
            }
        }

        if (isset($_POST['emergency_title'])) $about['safety_charter']['emergency_box']['title'] = trim($_POST['emergency_title']);
        if (isset($_POST['emergency_subtitle'])) $about['safety_charter']['emergency_box']['subtitle'] = trim($_POST['emergency_subtitle']);
        if (isset($_POST['emergency_phone'])) $about['safety_charter']['emergency_box']['phone'] = trim($_POST['emergency_phone']);
        if (isset($_POST['emergency_nhs111'])) $about['safety_charter']['emergency_box']['nhs111'] = trim($_POST['emergency_nhs111']);

        // Column counts (1..6 cols)
        if (isset($_POST['trust_badges_cols'])) $about['hero']['trust_badges_cols'] = max(1, min(6, (int)$_POST['trust_badges_cols']));
        if (isset($_POST['stats_cols'])) $about['why_us']['stats_cols'] = max(1, min(6, (int)$_POST['stats_cols']));
        if (isset($_POST['pillars_cols'])) $about['why_us']['pillars_cols'] = max(1, min(6, (int)$_POST['pillars_cols']));
        if (isset($_POST['clinic_features_cols'])) $about['clinics']['features_cols'] = max(1, min(6, (int)$_POST['clinic_features_cols']));
        if (isset($_POST['charter_cards_cols'])) $about['safety_charter']['cards_cols'] = max(1, min(6, (int)$_POST['charter_cards_cols']));

        // 6. SEO Metadata
        if (isset($_POST['meta_title'])) $about['seo']['meta_title'] = trim($_POST['meta_title']);
        if (isset($_POST['meta_description'])) $about['seo']['meta_description'] = trim($_POST['meta_description']);
        if (isset($_POST['keywords'])) $about['seo']['keywords'] = trim($_POST['keywords']);

        CmsService::saveAboutPageData($about);

        App::redirect('/admin/pages/about-us/edit', [
            'success' => 'About page content and practice standards saved successfully! Changes are immediately live on the website.',
        ]);
    }

    /**
     * Shared helper to parse dynamic page sections for Home, About, and custom CMS pages
     */
    private function parseSectionsFromRequest(array $postSections, array $files, string $subFolder): array
    {
        $parsedSections = [];
        foreach ($postSections as $idx => $sec) {
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

            if (!empty($files['section_image_files']['name'][$idx])) {
                $singleFile = [
                    'name' => $files['section_image_files']['name'][$idx],
                    'type' => $files['section_image_files']['type'][$idx],
                    'tmp_name' => $files['section_image_files']['tmp_name'][$idx],
                    'error' => $files['section_image_files']['error'][$idx],
                    'size' => $files['section_image_files']['size'][$idx],
                ];
                $up = Uploader::uploadImage($singleFile, 'sec_' . $secId, $subFolder);
                if ($up) {
                    $featureImg = $up;
                }
            }

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

            if (!empty($files['section_bg_files']['name'][$idx])) {
                $singleBg = [
                    'name' => $files['section_bg_files']['name'][$idx],
                    'type' => $files['section_bg_files']['type'][$idx],
                    'tmp_name' => $files['section_bg_files']['tmp_name'][$idx],
                    'error' => $files['section_bg_files']['error'][$idx],
                    'size' => $files['section_bg_files']['size'][$idx],
                ];
                $upBg = Uploader::uploadImage($singleBg, 'bg_' . $secId, $subFolder);
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
                'grid_cols' => max(1, min(6, (int)($sec['grid_cols'] ?? 3))),
                'is_active' => $isActive,
                'order' => $order,
            ];
        }

        usort($parsedSections, fn($a, $b) => $a['order'] <=> $b['order']);
        return $parsedSections;
    }

    public function create(): void
    {
        Auth::requireAuth();
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $template = trim($_POST['template'] ?? 'standard');
        $status = trim($_POST['status'] ?? 'published');

        if ($title === '') {
            App::redirect('/admin/pages', ['error' => 'Page title is required.']);
        }
        if ($slug === '') {
            $slug = $title;
        }

        $newPage = CmsService::createPage($title, $slug, $template, $status);
        App::redirect('/admin/pages/' . urlencode($newPage['slug']) . '/edit', [
            'success' => 'New page "' . $newPage['title'] . '" created! Customize its Banner, Content Sections, and SEO below.',
        ]);
    }

    public function toggleStatus(string $slug): void
    {
        Auth::requireAuth();
        $newStatus = CmsService::togglePageStatus($slug);
        if ($newStatus === null) {
            App::redirect('/admin/pages', ['error' => 'Page not found.']);
        }
        $label = $newStatus === 'published' ? 'activated' : 'deactivated';
        App::redirect('/admin/pages', [
            'success' => "Page '{$slug}' has been {$label}.",
        ]);
    }

    public function setPrimary(string $slug): void
    {
        Auth::requireAuth();
        if (CmsService::setPrimaryPage($slug)) {
            App::redirect('/admin/pages', [
                'success' => "Page '{$slug}' is now set as your Primary Homepage!",
            ]);
        }
        App::redirect('/admin/pages', ['error' => 'Unable to set primary page.']);
    }

    public function delete(string $slug): void
    {
        Auth::requireAuth();
        if (CmsService::deletePage($slug)) {
            App::redirect('/admin/pages', [
                'success' => "Page '{$slug}' deleted permanently.",
            ]);
        }
        App::redirect('/admin/pages', ['error' => 'Cannot delete the active Primary Homepage or page not found.']);
    }

    public function editCustomPage(string $slug): void
    {
        Auth::requireAuth();
        $pageData = CmsService::getCustomPageData($slug);
        $theme = ThemeService::getTheme();
        $allPages = CmsService::getPages();

        App::render('admin/pages/custom-editor', [
            'pageData' => $pageData,
            'slug' => $slug,
            'theme' => $theme,
            'allPages' => $allPages,
            'pageTitle' => ($pageData['title'] ?? ucfirst($slug)) . ' — Page Editor',
            'activeNav' => 'pages',
        ]);
    }

    public function updateCustomPage(string $slug): void
    {
        Auth::requireAuth();
        $data = CmsService::getCustomPageData($slug);

        if (isset($_POST['hero_eyebrow'])) $data['hero']['eyebrow'] = trim($_POST['hero_eyebrow']);
        if (isset($_POST['hero_headline'])) $data['hero']['headline'] = trim($_POST['hero_headline']);
        if (isset($_POST['hero_subtitle'])) $data['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        if (isset($_POST['hero_cta_primary'])) $data['hero']['cta_primary'] = trim($_POST['hero_cta_primary']);
        if (isset($_POST['hero_cta_primary_link'])) $data['hero']['cta_primary_link'] = trim($_POST['hero_cta_primary_link']);

        if (!empty($_FILES['hero_image_file']['name'])) {
            $up = Uploader::uploadImage($_FILES['hero_image_file'], 'hero_' . $slug, $slug);
            if ($up) $data['hero']['image'] = $up;
        } elseif (!empty($_POST['hero_image_manual'])) {
            $data['hero']['image'] = trim($_POST['hero_image_manual']);
        }

        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            $data['sections'] = $this->parseSectionsFromRequest($_POST['sections'], $_FILES, $slug);
        }

        if (isset($_POST['blog_posts']) && is_array($_POST['blog_posts'])) {
            $posts = [];
            foreach ($_POST['blog_posts'] as $pIdx => $bp) {
                if (trim($bp['title'] ?? '') === '') continue;
                $img = trim($bp['image'] ?? '');
                if (!empty($_FILES['blog_image_files']['name'][$pIdx])) {
                    $singleFile = [
                        'name' => $_FILES['blog_image_files']['name'][$pIdx],
                        'type' => $_FILES['blog_image_files']['type'][$pIdx],
                        'tmp_name' => $_FILES['blog_image_files']['tmp_name'][$pIdx],
                        'error' => $_FILES['blog_image_files']['error'][$pIdx],
                        'size' => $_FILES['blog_image_files']['size'][$pIdx],
                    ];
                    $up = Uploader::uploadImage($singleFile, 'blog_' . ($pIdx + 1), $slug);
                    if ($up) $img = $up;
                }
                $posts[] = [
                    'id' => trim($bp['id'] ?? ('post_' . ($pIdx + 1))),
                    'title' => trim($bp['title']),
                    'category' => trim($bp['category'] ?? 'Dental Care'),
                    'date' => trim($bp['date'] ?? date('Y-m-d')),
                    'author' => trim($bp['author'] ?? 'Clinical Team'),
                    'read_time' => trim($bp['read_time'] ?? '4 min read'),
                    'image' => $img ?: App::url('/uploads/home/treatment-room.jpg'),
                    'excerpt' => trim($bp['excerpt'] ?? ''),
                    'content' => trim($bp['content'] ?? ''),
                ];
            }
            $data['blog_posts'] = $posts;
        }

        if (isset($_POST['meta_title'])) $data['seo']['meta_title'] = trim($_POST['meta_title']);
        if (isset($_POST['meta_description'])) $data['seo']['meta_description'] = trim($_POST['meta_description']);
        if (isset($_POST['keywords'])) $data['seo']['keywords'] = trim($_POST['keywords']);

        CmsService::saveCustomPageData($slug, $data);

        App::redirect('/admin/pages/' . urlencode($slug) . '/edit', [
            'success' => 'Page saved successfully!',
        ]);
    }

    public function editTreatments(): void
    {
        Auth::requireAuth();
        $treatmentsData = CmsService::getTreatmentsPageData();
        $theme = ThemeService::getTheme();

        App::render('admin/pages/treatments-editor', [
            'treatments' => $treatmentsData,
            'theme' => $theme,
            'pageTitle' => 'Treatments & Services Catalog Page Editor',
            'activeNav' => 'pages',
        ]);
    }

    public function updateTreatments(): void
    {
        Auth::requireAuth();
        $data = CmsService::getTreatmentsPageData();

        if (isset($_POST['hero_eyebrow'])) $data['hero']['eyebrow'] = trim($_POST['hero_eyebrow']);
        if (isset($_POST['hero_headline'])) $data['hero']['headline'] = trim($_POST['hero_headline']);
        if (isset($_POST['hero_subtitle'])) $data['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        if (isset($_POST['hero_cta_primary'])) $data['hero']['cta_primary'] = trim($_POST['hero_cta_primary']);
        if (isset($_POST['hero_cta_primary_link'])) $data['hero']['cta_primary_link'] = trim($_POST['hero_cta_primary_link']);

        if (!empty($_FILES['hero_image_file']['name'])) {
            $up = Uploader::uploadImage($_FILES['hero_image_file'], 'treatments_hero', 'treatments');
            if ($up) $data['hero']['image'] = $up;
        } elseif (!empty($_POST['hero_image_manual'])) {
            $data['hero']['image'] = trim($_POST['hero_image_manual']);
        }

        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            $data['sections'] = $this->parseSectionsFromRequest($_POST['sections'], $_FILES, 'treatments');
        }

        if (isset($_POST['fee_bands']) && is_array($_POST['fee_bands'])) {
            $fees = [];
            foreach ($_POST['fee_bands'] as $fb) {
                if (trim($fb['title'] ?? '') !== '') {
                    $fees[] = [
                        'icon' => trim($fb['icon'] ?? 'local_hospital'),
                        'title' => trim($fb['title']),
                        'badge' => trim($fb['badge'] ?? ''),
                        'price' => trim($fb['price'] ?? ''),
                        'desc' => trim($fb['desc'] ?? ''),
                        'is_active' => !empty($fb['is_active']),
                    ];
                }
            }
            $data['fee_bands'] = $fees;
        }
        if (isset($_POST['fee_bands_cols'])) {
            $data['fee_bands_cols'] = max(1, min(6, (int)$_POST['fee_bands_cols']));
        }

        if (isset($_POST['clinical_pillars']) && is_array($_POST['clinical_pillars'])) {
            $pillars = [];
            foreach ($_POST['clinical_pillars'] as $cp) {
                if (trim($cp['title'] ?? '') !== '') {
                    $pillars[] = [
                        'icon' => trim($cp['icon'] ?? 'biotech'),
                        'title' => trim($cp['title']),
                        'desc' => trim($cp['desc'] ?? ''),
                        'is_active' => !empty($cp['is_active']),
                    ];
                }
            }
            $data['clinical_pillars'] = $pillars;
        }
        if (isset($_POST['pillars_cols'])) {
            $data['pillars_cols'] = max(1, min(6, (int)$_POST['pillars_cols']));
        }

        if (isset($_POST['meta_title'])) $data['seo']['meta_title'] = trim($_POST['meta_title']);
        if (isset($_POST['meta_description'])) $data['seo']['meta_description'] = trim($_POST['meta_description']);
        if (isset($_POST['keywords'])) $data['seo']['keywords'] = trim($_POST['keywords']);

        CmsService::saveTreatmentsPageData($data);

        App::redirect('/admin/pages/treatments/edit', [
            'success' => 'Treatments & Services Catalog page saved successfully!',
        ]);
    }

    public function editContact(): void
    {
        Auth::requireAuth();
        $contact = CmsService::getContactPageData();
        $entriesCount = count(\App\Services\ContactService::getAllSubmissions());

        App::render('admin/pages/contact-editor', [
            'contact' => $contact,
            'entriesCount' => $entriesCount,
            'pageTitle' => 'Edit Contact & Location Page',
            'activeNav' => 'pages',
        ]);
    }

    public function updateContact(): void
    {
        Auth::requireAuth();
        $data = CmsService::getContactPageData();

        if (isset($_POST['hero_eyebrow'])) $data['hero']['eyebrow'] = trim($_POST['hero_eyebrow']);
        if (isset($_POST['hero_headline'])) $data['hero']['headline'] = trim($_POST['hero_headline']);
        if (isset($_POST['hero_subtitle'])) $data['hero']['subtitle'] = trim($_POST['hero_subtitle']);
        if (isset($_POST['hero_triage_label'])) $data['hero']['triage_label'] = trim($_POST['hero_triage_label']);
        if (isset($_POST['hero_triage_phone'])) $data['hero']['triage_phone'] = trim($_POST['hero_triage_phone']);

        if (!empty($_FILES['hero_image_file']['tmp_name']) && is_uploaded_file($_FILES['hero_image_file']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['hero_image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/contact';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $fname = 'contact-hero-' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['hero_image_file']['tmp_name'], $uploadDir . '/' . $fname)) {
                    $data['hero']['image'] = '/uploads/contact/' . $fname;
                }
            }
        } elseif (isset($_POST['hero_image'])) {
            $data['hero']['image'] = trim($_POST['hero_image']);
        }

        if (isset($_POST['reassurance_title'])) $data['reassurance_card']['title'] = trim($_POST['reassurance_title']);
        if (isset($_POST['reassurance_desc'])) $data['reassurance_card']['desc'] = trim($_POST['reassurance_desc']);

        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            $sections = [];
            $order = 1;
            foreach ($_POST['sections'] as $sec) {
                if (trim($sec['title'] ?? '') === '' && trim($sec['name'] ?? '') === '') continue;
                $sections[] = [
                    'id' => trim($sec['id'] ?? ('sec_contact_' . $order)),
                    'type' => trim($sec['type'] ?? 'custom_content'),
                    'category' => trim($sec['category'] ?? 'custom'),
                    'name' => trim($sec['name'] ?? ($sec['title'] ?? 'Section')),
                    'eyebrow' => trim($sec['eyebrow'] ?? ''),
                    'title' => trim($sec['title'] ?? ''),
                    'summary' => trim($sec['summary'] ?? ''),
                    'description' => trim($sec['description'] ?? ''),
                    'is_active' => !empty($sec['is_active']),
                    'order' => $order++,
                ];
            }
            $data['sections'] = $sections;
        }

        if (isset($_POST['meta_title'])) $data['seo']['meta_title'] = trim($_POST['meta_title']);
        if (isset($_POST['meta_description'])) $data['seo']['meta_description'] = trim($_POST['meta_description']);
        if (isset($_POST['keywords'])) $data['seo']['keywords'] = trim($_POST['keywords']);

        CmsService::saveContactPageData($data);

        App::redirect('/admin/pages/contact/edit', [
            'success' => 'Contact & Location page updated successfully!',
        ]);
    }
}
