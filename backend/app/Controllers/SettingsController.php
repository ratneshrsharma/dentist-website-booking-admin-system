<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Services\ThemeService;

class SettingsController
{
    /**
     * Show Practice & Communication Settings
     */
    public function index(): void
    {
        $theme = ThemeService::getTheme();
        $branding = $theme['branding'] ?? [];

        App::render('admin/settings/index', [
            'activeNav' => 'settings',
            'branding' => $branding,
            'theme' => $theme,
        ]);
    }

    /**
     * Update Practice & Communication Settings
     */
    public function update(): void
    {
        $theme = ThemeService::getTheme();

        $theme['branding']['clinic_name'] = trim($_POST['clinic_name'] ?? $theme['branding']['clinic_name']);
        $theme['branding']['tagline'] = trim($_POST['tagline'] ?? $theme['branding']['tagline']);
        $theme['branding']['email'] = trim($_POST['email'] ?? 'reception@acocksgreendental.co.uk');
        $theme['branding']['form_email'] = trim($_POST['form_email'] ?? 'bookings@acocksgreendental.co.uk');
        $theme['branding']['contact_forward_emails'] = trim($_POST['contact_forward_emails'] ?? ($theme['branding']['form_email'] ?? 'bookings@acocksgreendental.co.uk'));
        $theme['branding']['whatsapp'] = trim($_POST['whatsapp'] ?? '+441217652870');
        $theme['branding']['phone'] = trim($_POST['phone'] ?? '+44 121 765 2870');
        $theme['branding']['emergency_phone'] = trim($_POST['emergency_phone'] ?? '+44 121 765 2870');
        $theme['branding']['address'] = trim($_POST['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH');
        $theme['branding']['cqc_status'] = trim($_POST['cqc_status'] ?? 'CQC Regulated Standards');
        $theme['branding']['nhs_registered'] = !empty($_POST['nhs_registered']);

        // Handle logo upload if provided
        if (!empty($_FILES['logo_file']['tmp_name']) && is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
            $uploadDir = dirname(__DIR__, 2) . '/public/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION);
            $filename = 'logo_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $uploadDir . '/' . $filename)) {
                $theme['branding']['logo_url'] = App::url('/uploads/' . $filename);
            }
        } elseif (!empty($_POST['logo_url'])) {
            $theme['branding']['logo_url'] = trim($_POST['logo_url']);
        }

        ThemeService::saveTheme($theme);

        App::redirect('/admin/settings', [
            'success' => 'Practice and communication settings updated successfully! Email alerts and WhatsApp numbers are now active across the website.',
        ]);
    }
}
