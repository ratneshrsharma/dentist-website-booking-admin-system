<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Services\ThemeService;
use App\Services\CmsService;

class ApiController
{
    public function ping(): void
    {
        App::json([
            'success' => true,
            'status' => 'online',
            'service' => '01-Dental-SaaS Headless REST API',
            'timestamp' => date('c'),
            'version' => '2.0.0',
        ]);
    }

    public function theme(): void
    {
        $theme = ThemeService::getTheme();
        App::json([
            'success' => true,
            'data' => $theme,
        ]);
    }

    public function pages(): void
    {
        $pages = CmsService::getPages();
        App::json([
            'success' => true,
            'total' => count($pages),
            'data' => $pages,
        ]);
    }

    public function homePage(): void
    {
        $home = CmsService::getHomePageData();
        App::json([
            'success' => true,
            'data' => $home,
        ]);
    }

    public function navigation(): void
    {
        $theme = ThemeService::getTheme();
        App::json([
            'success' => true,
            'data' => [
                'header_menu' => $theme['header_menu'] ?? [],
                'footer_data' => $theme['footer_data'] ?? [],
            ],
        ]);
    }

    public function bookAppointment(): void
    {
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true) ?? $_POST;

        $patientName = trim($payload['patient_name'] ?? 'Patient');
        $patientPhone = trim($payload['patient_phone'] ?? '');
        $treatment = trim($payload['treatment'] ?? 'Routine Dental Examination');
        $prefDate = trim($payload['preferred_date'] ?? date('Y-m-d'));

        $reference = 'BKG-' . date('Y') . '-' . rand(1000, 9999);

        // WhatsApp Triage link
        $theme = ThemeService::getTheme();
        $wa = preg_replace('/\D/', '', $theme['branding']['whatsapp'] ?? '441217652870');
        $msg = urlencode("Hello Acocks Green Dental Practice,\nI submitted booking request ref {$reference} for {$treatment} on {$prefDate}.\nName: {$patientName}");
        $whatsappUrl = "https://wa.me/{$wa}?text={$msg}";

        App::json([
            'success' => true,
            'message' => 'Your appointment request has been recorded. Our triage nurse will confirm shortly.',
            'reference' => $reference,
            'whatsapp_url' => $whatsappUrl,
            'data' => [
                'patient_name' => $patientName,
                'patient_phone' => $patientPhone,
                'treatment' => $treatment,
                'preferred_date' => $prefDate,
            ],
        ]);
    }
}
