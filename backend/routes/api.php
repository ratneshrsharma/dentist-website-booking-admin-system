<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AppointmentApiController;
use App\Http\Controllers\Api\V1\AvailabilityApiController;
use App\Http\Controllers\Api\V1\ClinicApiController;
use App\Http\Controllers\Api\V1\CmsApiController;
use App\Http\Controllers\Api\V1\DoctorApiController;
use App\Http\Controllers\Api\V1\SeoApiController;
use App\Http\Controllers\Api\V1\ServiceApiController;
use App\Http\Controllers\Api\V1\ThemeApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Advanced Dental Clinic REST API Routes (Version 1)
|--------------------------------------------------------------------------
|
| Public and authenticated endpoints serving the Next.js patient portal,
| 5-step booking wizard, real-time doctor slot availability, and clinic EMR.
|
*/

Route::prefix('v1')->middleware(['throttle:60,1'])->group(function (): void {
    // Health & System Ping
    Route::get('/ping', fn () => response()->json([
        'status' => 'healthy',
        'system' => 'Advanced Dental Clinic Suite',
        'timestamp' => now()->toIso8601String(),
    ]));

    // 1. Clinics & Branches
    Route::get('/clinics', [ClinicApiController::class, 'index']);
    Route::get('/clinics/{slug}', [ClinicApiController::class, 'show']);

    // 2. Dental Services & Categories
    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/services/{slug}', [ServiceApiController::class, 'show']);

    // 3. Doctors & Specialists
    Route::get('/doctors', [DoctorApiController::class, 'index']);
    Route::get('/doctors/{id}', [DoctorApiController::class, 'show']);

    // 4. Real-Time Slot Availability
    Route::get('/availability/slots', [AvailabilityApiController::class, 'slots']);
    Route::get('/availability/calendar', [AvailabilityApiController::class, 'calendar']);

    // 5. Patient Appointment Booking (OWASP Strict Rate Limiting: 10 requests / min)
    Route::post('/appointments/book', [AppointmentApiController::class, 'store'])
        ->middleware('throttle:10,1');
    Route::get('/appointments/lookup/{reference}', [AppointmentApiController::class, 'lookup']);

    // 6. Headless CMS & Multi-Page Navigation API
    Route::get('/cms/navigation', [CmsApiController::class, 'navigation']);
    Route::get('/cms/treatments', [CmsApiController::class, 'treatments']);
    Route::get('/cms/treatments/{slug}', [CmsApiController::class, 'treatmentBySlug']);
    Route::get('/cms/pages/{slug}', [CmsApiController::class, 'pageByKey']);

    // 7. Visual Theme Customizer API
    Route::get('/theme/settings', [ThemeApiController::class, 'settings']);

    // 8. Yoast-Style SEO & URL Redirects Engine
    Route::get('/seo/metadata/{slug}', [SeoApiController::class, 'metadata']);
    Route::get('/seo/redirects', [SeoApiController::class, 'redirects']);
});
