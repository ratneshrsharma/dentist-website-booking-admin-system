<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Services\ThemeService;
use App\Services\CmsService;
use App\Services\ServicesService;
use App\Services\BookingService;
use App\Services\BlogService;
use App\Services\ContactService;

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
        $primarySlug = CmsService::getPrimarySlug();
        $home = CmsService::getHomePageData();
        $home['primary_slug'] = $primarySlug;
        App::json([
            'success' => true,
            'data' => $home,
        ]);
    }

    public function aboutPage(): void
    {
        $about = CmsService::getAboutPageData();
        $home = CmsService::getHomePageData();
        // Enrich with clinicians, support team, and reviews from CMS
        $about['clinicians'] = $home['clinicians'] ?? [];
        $about['support_team'] = $home['support_team'] ?? [];
        $about['reviews'] = $home['reviews'] ?? [];

        App::json([
            'success' => true,
            'data' => $about,
        ]);
    }

    public function customPage(string $slug): void
    {
        if ($slug === 'home') {
            $this->homePage();
        }
        if ($slug === 'about' || $slug === 'about-us') {
            $this->aboutPage();
        }
        if ($slug === 'treatments') {
            App::json([
                'success' => true,
                'data' => CmsService::getTreatmentsPageData(),
            ]);
        }
        if ($slug === 'contact') {
            App::json([
                'success' => true,
                'data' => CmsService::getContactPageData(),
            ]);
        }
        $pageData = CmsService::getCustomPageData($slug);
        App::json([
            'success' => true,
            'data' => $pageData,
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

    public function services(): void
    {
        $services = ServicesService::getAllServices(true);
        App::json([
            'success' => true,
            'total' => count($services),
            'data' => $services,
        ]);
    }

    public function serviceDetail(string $slug): void
    {
        $service = ServicesService::getServiceBySlug($slug);
        if (!$service) {
            App::json(['success' => false, 'message' => 'Service not found'], 404);
        }

        App::json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function doctors(): void
    {
        $doctors = BookingService::getDefaultDoctors();
        App::json([
            'success' => true,
            'total' => count($doctors),
            'data' => $doctors,
        ]);
    }

    public function availability(): void
    {
        $doctorId = isset($_GET['doctor_id']) && $_GET['doctor_id'] !== '' ? (int)$_GET['doctor_id'] : 1;
        $date = trim($_GET['date'] ?? date('Y-m-d'));

        $slots = BookingService::getAvailableSlots($doctorId, $date);
        $doctor = BookingService::getDoctorById($doctorId);
        $schedule = BookingService::getDoctorSchedule($doctorId);

        App::json([
            'success' => true,
            'doctor' => $doctor,
            'date' => $date,
            'slot_duration' => $schedule['slot_duration'] ?? 30,
            'total_slots' => count($slots),
            'available_count' => count(array_filter($slots, fn($s) => !empty($s['available']))),
            'slots' => $slots,
        ]);
    }

    public function bookAppointment(): void
    {
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true) ?? $_POST;

        if (empty($payload['patient_name']) || empty($payload['patient_phone'])) {
            // Check if demo/offline request
            $payload['patient_name'] = $payload['patient_name'] ?? 'Patient Guest';
            $payload['patient_phone'] = $payload['patient_phone'] ?? '+44 7700 900000';
        }

        // Map alternate field names if passed
        if (isset($payload['phone']) && !isset($payload['patient_phone'])) {
            $payload['patient_phone'] = $payload['phone'];
        }
        if (isset($payload['email']) && !isset($payload['patient_email'])) {
            $payload['patient_email'] = $payload['email'];
        }
        if (isset($payload['date']) && !isset($payload['appointment_date'])) {
            $payload['appointment_date'] = $payload['date'];
        }
        if (isset($payload['time_slot']) && !isset($payload['appointment_time'])) {
            $payload['appointment_time'] = $payload['time_slot'];
        }

        $booking = BookingService::createBooking($payload);

        App::json([
            'success' => true,
            'message' => 'Your appointment request has been confirmed. A notification has been dispatched via your chosen channel.',
            'reference' => $booking['reference'],
            'booking_reference' => $booking['reference'],
            'whatsapp_url' => $booking['whatsapp_url'],
            'whatsapp_link' => $booking['whatsapp_url'],
            'data' => $booking,
        ]);
    }

    public function blogPosts(): void
    {
        $categorySlug = trim((string) ($_GET['category'] ?? ''));
        $tagSlug = trim((string) ($_GET['tag'] ?? ''));
        $search = strtolower(trim((string) ($_GET['q'] ?? '')));

        $livePosts = BlogService::getAllPosts(true);
        $filtered = array_values(array_filter($livePosts, static function ($p) use ($categorySlug, $tagSlug, $search) {
            if ($categorySlug !== '' && $categorySlug !== 'all') {
                $catSlugs = array_map(static fn($c) => $c['slug'] ?? '', $p['categories'] ?? []);
                if (!in_array($categorySlug, $catSlugs, true)) {
                    return false;
                }
            }
            if ($tagSlug !== '' && $tagSlug !== 'all') {
                $tagSlugs = array_map(static fn($t) => $t['slug'] ?? '', $p['tags'] ?? []);
                if (!in_array($tagSlug, $tagSlugs, true)) {
                    return false;
                }
            }
            if ($search !== '') {
                $hay = strtolower(($p['title'] ?? '') . ' ' . ($p['excerpt'] ?? '') . ' ' . ($p['author'] ?? ''));
                if (!str_contains($hay, $search)) {
                    return false;
                }
            }
            return true;
        }));

        $activeCats = array_values(array_filter(BlogService::getCategories(), static fn($c) => !empty($c['is_active'])));

        App::json([
            'success' => true,
            'total' => count($filtered),
            'data' => $filtered,
            'categories' => $activeCats,
            'tags' => BlogService::getTags(),
        ]);
    }

    public function blogPostDetail(string $slug): void
    {
        $post = BlogService::getPostBySlug($slug, true);
        if (!$post) {
            App::json(['success' => false, 'message' => 'Blog post not found'], 404);
        }

        // Filter only active FAQs
        if (!empty($post['show_faqs']) && !empty($post['faqs'])) {
            $post['faqs'] = array_values(array_filter(
                $post['faqs'],
                static fn($f) => !isset($f['is_active']) || !empty($f['is_active'])
            ));
        } else {
            $post['faqs'] = [];
        }

        // Related posts (up to 3 other live posts)
        $allLive = BlogService::getAllPosts(true);
        $related = array_values(array_slice(array_filter(
            $allLive,
            static fn($p) => ($p['slug'] ?? '') !== $post['slug']
        ), 0, 3));

        App::json([
            'success' => true,
            'data' => $post,
            'related' => $related,
        ]);
    }

    public function blogCategories(): void
    {
        $cats = array_values(array_filter(BlogService::getCategories(), static fn($c) => !empty($c['is_active'])));
        App::json(['success' => true, 'data' => $cats]);
    }

    public function blogTags(): void
    {
        App::json(['success' => true, 'data' => BlogService::getTags()]);
    }

    public function submitContact(): void
    {
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true) ?? $_POST;

        if (trim((string) ($payload['full_name'] ?? '')) === '' || trim((string) ($payload['phone'] ?? '')) === '') {
            App::json(['success' => false, 'message' => 'Full name and telephone number are required.'], 422);
        }

        $entry = ContactService::createSubmission($payload);

        App::json([
            'success' => true,
            'message' => 'Thank you! Your enquiry has been saved and routed to our Acocks Green reception team.',
            'reference' => $entry['reference'],
            'forwarded_to' => $entry['forwarded_to'],
            'data' => $entry,
        ]);
    }
}
