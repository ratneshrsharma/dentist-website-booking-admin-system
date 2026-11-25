<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ThemeController;
use App\Controllers\PagesController;
use App\Controllers\ComponentsController;
use App\Controllers\BookingsController;
use App\Controllers\SettingsController;
use App\Controllers\ApiController;
use App\Controllers\BlogController;

/**
 * Clean & Fast Application Router
 */
class Router
{
    public static function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        // Strip subfolder prefix if present (e.g. /dental-saas)
        $uri = preg_replace('~^/dental-saas~', '', $uri);
        $uri = '/' . ltrim($uri, '/');

        // Handle OPTIONS preflight for APIs
        if ($method === 'OPTIONS') {
            App::json(['success' => true]);
        }

        // ==========================================
        // 1. REST API ROUTES (/api/v1/...)
        // ==========================================
        if (str_starts_with($uri, '/api/')) {
            $apiCtrl = new ApiController();

            if ($uri === '/api/v1/ping' || $uri === '/api/ping') {
                $apiCtrl->ping();
            }
            if ($uri === '/api/v1/theme' || $uri === '/api/v1/theme/global') {
                $apiCtrl->theme();
            }
            if ($uri === '/api/v1/pages' || $uri === '/api/pages') {
                $apiCtrl->pages();
            }
            if ($uri === '/api/v1/pages/home' || $uri === '/api/v1/cms/pages/home' || $uri === '/api/v1/cms-pages/home') {
                $apiCtrl->homePage();
            }
            if ($uri === '/api/v1/pages/about' || $uri === '/api/v1/pages/about-us' || $uri === '/api/v1/cms/pages/about-us') {
                $apiCtrl->aboutPage();
            }
            if (preg_match('~^/api/v1/(?:cms/)?pages/([A-Za-z0-9_-]+)$~', $uri, $pm)) {
                $apiCtrl->customPage($pm[1]);
            }
            if ($uri === '/api/v1/navigation' || $uri === '/api/v1/cms/navigation') {
                $apiCtrl->navigation();
            }
            if ($uri === '/api/v1/services' || $uri === '/api/services') {
                $apiCtrl->services();
            }
            if (preg_match('~^/api/v1/services/([A-Za-z0-9_-]+)$~', $uri, $m)) {
                $apiCtrl->serviceDetail($m[1]);
            }
            if ($uri === '/api/v1/doctors' || $uri === '/api/doctors') {
                $apiCtrl->doctors();
            }
            if (str_starts_with($uri, '/api/v1/availability') || str_starts_with($uri, '/api/availability')) {
                $apiCtrl->availability();
            }
            if (($uri === '/api/v1/appointments/book' || $uri === '/api/v1/appointments') && $method === 'POST') {
                $apiCtrl->bookAppointment();
            }

            // Blog REST API
            if ($uri === '/api/v1/blog/posts' || $uri === '/api/blog/posts') {
                $apiCtrl->blogPosts();
            }
            if (preg_match('~^/api/v1/blog/posts/([A-Za-z0-9_-]+)$~', $uri, $bm)) {
                $apiCtrl->blogPostDetail($bm[1]);
            }
            if ($uri === '/api/v1/blog/categories') {
                $apiCtrl->blogCategories();
            }
            if ($uri === '/api/v1/blog/tags') {
                $apiCtrl->blogTags();
            }

            App::json(['success' => false, 'message' => 'API endpoint not found', 'path' => $uri], 404);
        }

        // ==========================================
        // 2. ADMIN PORTAL ROUTES (/admin/...)
        // ==========================================
        if (str_starts_with($uri, '/admin')) {
            $path = trim(preg_replace('~^/admin/?~', '', $uri), '/');

            // Authentication Routes
            if ($path === 'login') {
                $auth = new AuthController();
                if ($method === 'POST') {
                    $auth->login();
                } else {
                    $auth->showLogin();
                }
            }

            if ($path === 'login/cancel-2fa') {
                $auth = new AuthController();
                $auth->cancel2FA();
            }

            if ($path === 'logout') {
                $auth = new AuthController();
                $auth->logout();
            }

            // Dashboard
            if ($path === '' || $path === 'dashboard') {
                $dash = new DashboardController();
                $dash->index();
            }

            // Theme & Whitelabeling Studio
            if ($path === 'theme' || $path === 'theme-customizer') {
                $theme = new ThemeController();
                if ($method === 'POST') {
                    $theme->update();
                } else {
                    $theme->index();
                }
            }

            // Pages List
            if ($path === 'pages' || $path === 'cms-pages') {
                $pages = new PagesController();
                $pages->index();
            }

            // Homepage Content & Assets Editor (Accessible from Page List)
            if ($path === 'pages/home/edit' || $path === 'pages/home' || $path === 'cms/pages/home') {
                $pages = new PagesController();
                if ($method === 'POST') {
                    $pages->updateHome();
                } else {
                    $pages->editHome();
                }
            }

            // About Page Content & Assets Editor
            if ($path === 'pages/about-us/edit' || $path === 'pages/about/edit') {
                $pages = new PagesController();
                if ($method === 'POST') {
                    $pages->updateAbout();
                } else {
                    $pages->editAbout();
                }
            }

            // Treatments & Services Catalog Editor
            if ($path === 'pages/treatments/edit') {
                $pages = new PagesController();
                if ($method === 'POST') {
                    $pages->updateTreatments();
                } else {
                    $pages->editTreatments();
                }
            }

            // Create / Toggle / Set Primary / Delete / Edit Custom CMS Pages
            if ($path === 'pages/create' && $method === 'POST') {
                $pages = new PagesController();
                $pages->create();
            }
            if (preg_match('~^pages/([A-Za-z0-9_-]+)/toggle$~', $path, $pm) && $method === 'POST') {
                $pages = new PagesController();
                $pages->toggleStatus($pm[1]);
            }
            if (preg_match('~^pages/([A-Za-z0-9_-]+)/primary$~', $path, $pm) && $method === 'POST') {
                $pages = new PagesController();
                $pages->setPrimary($pm[1]);
            }
            if (preg_match('~^pages/([A-Za-z0-9_-]+)/delete$~', $path, $pm) && $method === 'POST') {
                $pages = new PagesController();
                $pages->delete($pm[1]);
            }
            if (preg_match('~^pages/([A-Za-z0-9_-]+)/edit$~', $path, $pm)) {
                $pages = new PagesController();
                if ($method === 'POST') {
                    $pages->updateCustomPage($pm[1]);
                } else {
                    $pages->editCustomPage($pm[1]);
                }
            }

            // Clinical Bookings Master Dashboard
            if ($path === 'bookings' || $path === 'appointments') {
                $bCtrl = new BookingsController();
                $bCtrl->index();
            }
            if (preg_match('~^bookings/([A-Za-z0-9_-]+)/status$~', $path, $bm) && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->updateStatus($bm[1]);
            }
            if (preg_match('~^bookings/([A-Za-z0-9_-]+)/reschedule$~', $path, $bm) && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->reschedule($bm[1]);
            }
            if (preg_match('~^bookings/([A-Za-z0-9_-]+)/remind$~', $path, $bm) && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->sendReminder($bm[1]);
            }
            if (preg_match('~^bookings/([A-Za-z0-9_-]+)/delete$~', $path, $bm) && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->deleteBooking($bm[1]);
            }

            // Dedicated Doctor Availability, Timings & Leave
            if ($path === 'doctors/availability' || $path === 'bookings/availability') {
                $bCtrl = new BookingsController();
                if ($method === 'POST') {
                    $bCtrl->saveAvailability();
                } else {
                    $bCtrl->availability();
                }
            }
            if ($path === 'doctors/leave/add' && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->addLeave();
            }
            if (preg_match('~^doctors/leave/([A-Za-z0-9_-]+)/delete$~', $path, $lm) && $method === 'POST') {
                $bCtrl = new BookingsController();
                $bCtrl->deleteLeave($lm[1]);
            }

            // Practice & Communication Settings (Form email, WhatsApp number, practice details)
            if ($path === 'settings' || $path === 'practice-settings') {
                $sCtrl = new SettingsController();
                if ($method === 'POST') {
                    $sCtrl->update();
                } else {
                    $sCtrl->index();
                }
            }

            // Common Components Child Routes
            if (str_starts_with($path, 'components/')) {
                $comp = new ComponentsController();
                $sub = substr($path, strlen('components/'));

                // Services CRUD & Inner Pages
                if ($sub === 'services') {
                    $comp->services();
                }
                if ($sub === 'services/create') {
                    $comp->createService();
                }
                if ($sub === 'services/intro') {
                    $comp->saveServiceIntro();
                }
                if ($sub === 'services/reorder') {
                    $comp->reorderServices();
                }
                if (preg_match('~^services/(\d+)/edit$~', $sub, $sm)) {
                    $comp->editService((int)$sm[1]);
                }
                if (preg_match('~^services/(\d+)/view$~', $sub, $sm)) {
                    $comp->viewService((int)$sm[1]);
                }
                if (preg_match('~^services/(\d+)/toggle$~', $sub, $sm)) {
                    $comp->toggleService((int)$sm[1]);
                }
                if (preg_match('~^services/(\d+)/delete$~', $sub, $sm)) {
                    $comp->deleteService((int)$sm[1]);
                }

                if ($sub === 'about') {
                    $comp->about();
                }
                if ($sub === 'doctors') {
                    $comp->doctors();
                }
                if ($sub === 'testimonials') {
                    $comp->testimonials();
                }
                if ($sub === 'charter') {
                    $comp->charter();
                }
                if ($sub === 'contact') {
                    $comp->contact();
                }
            }

            // WordPress-style Blog Management (/admin/blog/...)
            if (str_starts_with($path, 'blog')) {
                $blog = new BlogController();
                $sub = trim(substr($path, strlen('blog')), '/');

                if ($sub === '' || $sub === 'posts') {
                    $blog->posts();
                }
                if ($sub === 'posts/create') {
                    $blog->createPost();
                }
                if (preg_match('~^posts/([A-Za-z0-9_-]+)/edit$~', $sub, $bm)) {
                    $blog->editPost($bm[1]);
                }
                if (preg_match('~^posts/([A-Za-z0-9_-]+)/toggle$~', $sub, $bm) && $method === 'POST') {
                    $blog->togglePostStatus($bm[1]);
                }
                if (preg_match('~^posts/([A-Za-z0-9_-]+)/delete$~', $sub, $bm) && $method === 'POST') {
                    $blog->deletePost($bm[1]);
                }
                if ($sub === 'categories') {
                    $blog->categories();
                }
                if ($sub === 'categories/save' && $method === 'POST') {
                    $blog->saveCategory();
                }
                if (preg_match('~^categories/([A-Za-z0-9_-]+)/delete$~', $sub, $bm) && $method === 'POST') {
                    $blog->deleteCategory($bm[1]);
                }
                if ($sub === 'tags') {
                    $blog->tags();
                }
                if ($sub === 'tags/save' && $method === 'POST') {
                    $blog->saveTag();
                }
                if (preg_match('~^tags/([A-Za-z0-9_-]+)/delete$~', $sub, $bm) && $method === 'POST') {
                    $blog->deleteTag($bm[1]);
                }
            }

            // Fallback for any unknown /admin URL
            App::redirect('/admin/dashboard');
        }

        // Root redirect to Admin Dashboard
        App::redirect('/admin/dashboard');
    }
}
