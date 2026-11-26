<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Uploader;
use App\Services\ThemeService;

class ThemeController
{
    public function index(): void
    {
        Auth::requirePermission('theme');

        $theme = ThemeService::getTheme();

        App::render('admin/theme/index', [
            'theme' => $theme,
            'pageTitle' => 'Global Theme & Whitelabeling Studio',
            'activeNav' => 'theme',
        ]);
    }

    public function update(): void
    {
        Auth::requirePermission('theme');

        $theme = ThemeService::getTheme();

        // 1. Check for Logo File Upload
        if (!empty($_FILES['logo_file']['name'])) {
            $uploadedUrl = Uploader::uploadImage($_FILES['logo_file'], 'brand_logo');
            if ($uploadedUrl) {
                $theme['branding']['logo_url'] = $uploadedUrl;
            }
        } elseif (!empty($_POST['logo_url_manual'])) {
            $theme['branding']['logo_url'] = trim($_POST['logo_url_manual']);
        }

        // 2. Branding & Clinic Identity
        if (isset($_POST['clinic_name'])) {
            $theme['branding']['clinic_name'] = trim($_POST['clinic_name']);
        }
        if (isset($_POST['tagline'])) {
            $theme['branding']['tagline'] = trim($_POST['tagline']);
        }
        if (isset($_POST['phone'])) {
            $theme['branding']['phone'] = trim($_POST['phone']);
        }
        if (isset($_POST['emergency_phone'])) {
            $theme['branding']['emergency_phone'] = trim($_POST['emergency_phone']);
        }
        if (isset($_POST['whatsapp'])) {
            $theme['branding']['whatsapp'] = trim($_POST['whatsapp']);
        }
        if (isset($_POST['address'])) {
            $theme['branding']['address'] = trim($_POST['address']);
        }

        // 3. Theme Colors & Tokens
        if (isset($_POST['primary_color'])) {
            $theme['colors']['primary'] = trim($_POST['primary_color']);
        }
        if (isset($_POST['primary_hover_color'])) {
            $theme['colors']['primary_hover'] = trim($_POST['primary_hover_color']);
        }
        if (isset($_POST['secondary_color'])) {
            $theme['colors']['secondary'] = trim($_POST['secondary_color']);
        }
        if (isset($_POST['surface_color'])) {
            $theme['colors']['surface'] = trim($_POST['surface_color']);
        }

        // 4. Typography / Fonts
        if (isset($_POST['font_family'])) {
            $theme['typography']['font_family'] = trim($_POST['font_family']);
        }

        // 5. Header Navigation Menu
        if (isset($_POST['header_menu_titles']) && is_array($_POST['header_menu_titles'])) {
            $newHeaderMenu = [];
            foreach ($_POST['header_menu_titles'] as $idx => $title) {
                $t = trim($title);
                $p = trim($_POST['header_menu_paths'][$idx] ?? '/');
                if ($t !== '') {
                    $newHeaderMenu[] = [
                        'title' => $t,
                        'path' => $p,
                    ];
                }
            }
            if (!empty($newHeaderMenu)) {
                $theme['header_menu'] = $newHeaderMenu;
            }
        }

        // 6. Footer Content & Copyright
        if (isset($_POST['copyright_text'])) {
            $theme['footer_data']['copyright_text'] = trim($_POST['copyright_text']);
        }

        ThemeService::saveTheme($theme);

        App::redirect('/admin/theme', [
            'success' => 'Whitelabeling settings, brand tokens, and navigation menus successfully updated!',
        ]);
    }
}

