<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\SeoManagerController;
use App\Http\Controllers\Admin\SeoRedirectsController;
use App\Http\Controllers\Admin\ThemeCustomizerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - AdminLTE 4 Management Portal
|--------------------------------------------------------------------------
|
| Web routes for clinic administrators, doctors, and staff members managing
| EMR records, appointments, inventory, Yoast SEO, and theme customizers.
|
*/

Route::get('/', fn () => redirect('/admin/dashboard'));

Route::prefix('admin')->group(function (): void {
    // 1. Dashboard View
    Route::get('/dashboard', fn () => view('admin.dashboard'));

    // 2. Scheduler & Calendar
    Route::get('/appointments/calendar', fn () => view('admin.appointments.calendar'));

    // 3. EMR Odontogram
    Route::get('/emr/odontogram', fn () => view('admin.emr.odontogram'));

    // 4. Theme & Typography Customizer
    Route::get('/theme-customizer', [ThemeCustomizerController::class, 'index']);
    Route::post('/theme-customizer/update', [ThemeCustomizerController::class, 'update']);
    Route::post('/theme-customizer/upload-font', [ThemeCustomizerController::class, 'uploadFont']);

    // 5. Enterprise Yoast-Style SEO Manager
    Route::get('/seo-manager', [SeoManagerController::class, 'index']);
    Route::post('/seo-manager/store', [SeoManagerController::class, 'store']);

    // 6. URL Redirection Manager (301, 302, 404, 410)
    Route::get('/seo-redirects', [SeoRedirectsController::class, 'index']);
    Route::post('/seo-redirects/store', [SeoRedirectsController::class, 'store']);
    Route::delete('/seo-redirects/{id}', [SeoRedirectsController::class, 'destroy']);
});
