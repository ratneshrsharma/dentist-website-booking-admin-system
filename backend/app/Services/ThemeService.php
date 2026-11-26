<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\App;

/**
 * Service to manage Global Whitelabeling, Theme Colors, Typography, Logo, Header & Footer
 */
class ThemeService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/cms_theme.json';
    }

    public static function getDefaultTheme(): array
    {
        return [
            'theme_name' => 'acocks-green',
            'display_name' => 'Acocks Green Dental Practice',
            'colors' => [
                'primary' => '#0d631b',
                'primary_hover' => '#0a4f15',
                'secondary' => '#45664e',
                'surface' => '#f2fcf5',
                'surface_muted' => '#ecf6ef',
                'text_primary' => '#151d1a',
                'text_secondary' => '#40493d',
                'nhs_blue' => '#005eb8',
                'status_error' => '#ba1a1a',
                'brand_accent_glow' => '#E8F5E9',
            ],
            'typography' => [
                'font_family' => 'Plus Jakarta Sans',
                'heading_font' => 'Plus Jakarta Sans',
                'body_font' => 'Work Sans',
            ],
            'branding' => [
                'clinic_name' => 'Acocks Green',
                'tagline' => 'Dental Practice',
                'logo_url' => App::url('/images/acocks-green-logo.png'),
                'email' => 'reception@acocksgreendental.co.uk',
                'form_email' => 'bookings@acocksgreendental.co.uk',
                'contact_forward_emails' => 'bookings@acocksgreendental.co.uk, reception@acocksgreendental.co.uk',
                'phone' => '+44 121 765 2870',
                'whatsapp' => '+441217652870',
                'emergency_phone' => '+44 121 765 2870',
                'address' => '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
                'cqc_status' => 'CQC Regulated Standards',
                'nhs_registered' => true,
            ],
            'system_settings' => [
                'session_timeout_hours' => 10,
                'log_retention_months' => 2,
                'default_slot_duration' => 30,
                'require_2fa' => true,
                'maintenance_mode' => false,
            ],
            'header_menu' => [
                ['title' => 'Home', 'path' => '/'],
                ['title' => 'Treatments & Services', 'path' => '/treatments'],
                ['title' => 'About Us', 'path' => '/about-us'],
                ['title' => 'Patient Safety & Charter', 'path' => '/safety-charter'],
                ['title' => 'Contact & Location', 'path' => '/contact'],
            ],
            'footer_data' => [
                'quick_links' => [
                    ['title' => 'Home', 'path' => '/'],
                    ['title' => 'Meet Our Clinicians', 'path' => '/#team'],
                    ['title' => 'Emergency Dentistry', 'path' => '/treatments'],
                    ['title' => 'NHS Patient Registration', 'path' => '/contact'],
                    ['title' => 'Contact Us', 'path' => '/contact'],
                ],
                'services_links' => [
                    ['title' => 'Routine Dental Examinations', 'path' => '/treatments'],
                    ['title' => 'Dental Hygiene & Stain Polishing', 'path' => '/treatments'],
                    ['title' => 'Tooth Restorations & White Fillings', 'path' => '/treatments'],
                    ['title' => 'Invisalign® & Teeth Straightening', 'path' => '/treatments'],
                    ['title' => 'Root Canal & Emergency Pain Relief', 'path' => '/treatments'],
                ],
                'copyright_text' => '© ' . date('Y') . ' Acocks Green Dental Practice. All rights reserved. CQC Regulated Dental Care.',
            ],
        ];
    }

    public static function getTheme(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string)file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                return array_replace_recursive(self::getDefaultTheme(), $data);
            }
        }
        return self::getDefaultTheme();
    }

    public static function saveTheme(array $data): bool
    {
        $current = self::getTheme();
        $merged = array_replace_recursive($current, $data);

        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }
}
