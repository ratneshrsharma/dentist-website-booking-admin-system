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

        // 7. System & Contact Settings (Super Admin & Admin)
        if (Auth::can('settings') || Auth::can('users')) {
            if (isset($_POST['sys_email'])) {
                $theme['branding']['email'] = trim($_POST['sys_email']);
            }
            if (isset($_POST['sys_whatsapp'])) {
                $theme['branding']['whatsapp'] = trim($_POST['sys_whatsapp']);
            }
            if (isset($_POST['sys_phone'])) {
                $theme['branding']['phone'] = trim($_POST['sys_phone']);
            }
            if (isset($_POST['sys_emergency_phone'])) {
                $theme['branding']['emergency_phone'] = trim($_POST['sys_emergency_phone']);
            }
            if (isset($_POST['sys_contact_forward_emails'])) {
                $theme['branding']['contact_forward_emails'] = trim($_POST['sys_contact_forward_emails']);
            }
            if (isset($_POST['session_timeout_hours'])) {
                $theme['system_settings']['session_timeout_hours'] = max(1, min(720, (int) $_POST['session_timeout_hours']));
            }
            if (isset($_POST['log_retention_months'])) {
                $theme['system_settings']['log_retention_months'] = max(1, min(60, (int) $_POST['log_retention_months']));
            }
            if (isset($_POST['default_slot_duration'])) {
                $theme['system_settings']['default_slot_duration'] = max(10, min(120, (int) $_POST['default_slot_duration']));
            }
            if (isset($_POST['sys_settings_submitted'])) {
                $theme['system_settings']['require_2fa'] = !empty($_POST['require_2fa']);
                $theme['system_settings']['maintenance_mode'] = !empty($_POST['maintenance_mode']);
            }
        }

        ThemeService::saveTheme($theme);
        \App\Services\ActivityLogService::log('Updated Global Theme & System Settings', 'Global Theme', 'Success');

        App::redirect('/admin/theme', [
            'success' => 'Whitelabeling settings, brand tokens, and system settings successfully updated!',
        ]);
    }
}

