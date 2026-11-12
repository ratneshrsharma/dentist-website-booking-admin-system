<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AuthController;
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

// Public Digital Invoices & Patient Tax Receipts
Route::get('/billing/{invoice_ref}', function ($invoice_ref) {
    require_once app_path('StandaloneRunner.php');
    \App\StandaloneRunner::handlePublicInvoice($invoice_ref);
});

Route::prefix('admin')->group(function (): void {
    // Authentication Endpoints
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // 1. Dashboard View
    Route::get('/dashboard', fn () => view('admin.dashboard'));

    // 2. Scheduler & Calendar
    Route::get('/appointments/calendar', fn () => view('admin.appointments.calendar'));

    // 3. EMR Odontogram
    Route::get('/emr/odontogram', fn () => view('admin.emr.odontogram'));

    // 4. Patient Records (EHR)
    Route::get('/patients', fn () => view('admin.patients.index'));

    // 5. Multi-Clinic Branch Facilities
    Route::get('/clinics', fn () => view('admin.clinics.index'));
    Route::get('/multi-clinic', fn () => view('admin.clinics.index'));

    // 6. Dental Supplies & Stock Inventory
    Route::get('/inventory', fn () => view('admin.inventory.index'));

    // 7. Billing, Invoices & POS
    Route::get('/billing', fn () => view('admin.billing.index'));
    Route::get('/billing/{invoice_ref}', function ($invoice_ref) {
        require_once app_path('StandaloneRunner.php');
        \App\StandaloneRunner::handlePublicInvoice($invoice_ref);
    });

    // 8. Theme & Typography Customizer
    Route::get('/theme-customizer', [ThemeCustomizerController::class, 'index']);
    Route::post('/theme-customizer/update', [ThemeCustomizerController::class, 'update']);
    Route::post('/theme-customizer/upload-font', [ThemeCustomizerController::class, 'uploadFont']);

    // 9. Enterprise Yoast-Style SEO Manager
    Route::get('/seo-manager', [SeoManagerController::class, 'index']);
    Route::post('/seo-manager/store', [SeoManagerController::class, 'store']);

    // 10. URL Redirection Manager (301, 302, 404, 410)
    Route::get('/seo-redirects', [SeoRedirectsController::class, 'index']);
    Route::post('/seo-redirects/store', [SeoRedirectsController::class, 'store']);
    Route::delete('/seo-redirects/{id}', [SeoRedirectsController::class, 'destroy']);

    // 11. Website CMS Pages Manager
    Route::get('/cms-pages', fn () => view('admin.cms.pages'));
    Route::get('/cms', fn () => view('admin.cms.pages'));

    // 12. Staff Directory & Security RBAC Roles
    Route::get('/roles', fn () => view('admin.roles.index'));
    Route::get('/users', fn () => view('admin.roles.index'));
});
