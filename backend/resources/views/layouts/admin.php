<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Auth;
use App\Services\ThemeService;

$theme = ThemeService::getTheme();
$clinicName = $theme['branding']['clinic_name'] ?? 'Dental SaaS';
$clinicTagline = $theme['branding']['tagline'] ?? 'Practice Management';
$clinicLogo = $theme['branding']['logo_url'] ?? App::url('/images/acocks-green-logo.png');
$primaryColor = $theme['colors']['primary'] ?? '#0d631b';
$fontFamily = $theme['typography']['font_family'] ?? 'Plus Jakarta Sans';
$activeNav = $activeNav ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin Portal') ?> — <?= htmlspecialchars($clinicName) ?></title>
    <link rel="icon" type="image/png" href="<?= App::url('/images/acocks-green-logo.png') ?>">
    <link rel="shortcut icon" href="<?= App::url('/images/acocks-green-logo.png') ?>">
    
    <!-- Google Fonts & Material Symbols Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    
    <!-- Bootstrap 5.3 & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AdminLTE 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/css/adminlte.min.css">

    <style>
        :root {
            --brand-primary: <?= htmlspecialchars($primaryColor) ?>;
            --font-family-base: '<?= htmlspecialchars($fontFamily) ?>', system-ui, -apple-system, sans-serif;
            --sidebar-width: 260px;
        }
        body {
            font-family: var(--font-family-base);
            background-color: #f8fafc;
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 22px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            vertical-align: middle;
        }
        .app-sidebar {
            width: var(--sidebar-width) !important;
            background-color: #0f172a !important;
            height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            position: fixed !important;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1038;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .app-header,
        .app-main,
        .app-footer {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop: Expanded Sidebar (default) */
        @media (min-width: 992px) {
            body:not(.sidebar-collapse) .app-sidebar {
                transform: translateX(0) !important;
            }
            body:not(.sidebar-collapse) .app-header,
            body:not(.sidebar-collapse) .app-main,
            body:not(.sidebar-collapse) .app-footer {
                margin-left: var(--sidebar-width) !important;
                width: calc(100% - var(--sidebar-width)) !important;
            }

            /* Desktop: Collapsed Sidebar (no gap, 100% full width) */
            body.sidebar-collapse .app-sidebar {
                transform: translateX(-100%) !important;
            }
            body.sidebar-collapse .app-header,
            body.sidebar-collapse .app-main,
            body.sidebar-collapse .app-footer {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

        /* Mobile / Tablet (< 992px) */
        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%) !important;
            }
            body.sidebar-open .app-sidebar {
                transform: translateX(0) !important;
            }
            .app-header,
            .app-main,
            .app-footer {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
        .sidebar-brand {
            background-color: #0b1120 !important;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 14px 16px !important;
            height: auto !important;
            min-height: 64px;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-shrink: 0 !important;
        }
        .sidebar-wrapper {
            flex: 1 1 auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            max-height: calc(100vh - 64px) !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.25) transparent;
        }
        .sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.45);
        }
        .brand-logo-img {
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            object-fit: contain;
            border-radius: 10px;
            background: #ffffff;
            padding: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }
        .brand-title-wrap {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            line-height: 1.15;
            max-width: 175px;
        }
        .brand-name-text {
            color: #ffffff;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: -0.01em;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .brand-tagline-text {
            color: #94a3b8;
            font-size: 11px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-menu .nav-link {
            color: #94a3b8;
            font-weight: 500;
            border-radius: 8px;
            margin: 2px 8px;
            padding: 0.6rem 0.9rem;
            transition: all 0.2s ease;
        }
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: #ffffff !important;
            background-color: var(--brand-primary) !important;
        }
        .sidebar-menu .nav-link i {
            margin-right: 0.65rem;
            font-size: 1.1rem;
        }
        .badge-brand {
            background-color: var(--brand-primary);
            color: #ffffff;
        }
        /* Uniform CMS Button Sizing (Small & Medium Only) */
        .app-main .btn {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.42rem 0.95rem;
            line-height: 1.4;
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        }
        .app-main .btn-lg {
            font-size: 0.875rem !important;
            padding: 0.48rem 1.2rem !important;
        }
        .app-main .btn-sm {
            font-size: 0.78rem !important;
            padding: 0.28rem 0.65rem !important;
            line-height: 1.35;
        }
        .app-main .btn-group-sm .btn {
            min-width: 32px;
            height: 30px;
            padding: 0.25rem 0.5rem !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem !important;
        }
        .app-main .btn:focus,
        .app-main .btn:focus-visible {
            box-shadow: 0 0 0 3px rgba(13, 99, 27, 0.22) !important;
            outline: none;
        }
        .app-main .btn:active {
            transform: translateY(0) !important;
            filter: brightness(0.94);
        }
        .btn-brand {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-brand:hover,
        .btn-brand:focus,
        .btn-brand:active {
            background-color: #094713 !important;
            border-color: #094713 !important;
            color: #ffffff !important;
        }
        .preview-img-box {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            background: #ffffff;
        }
        .card-editor-header {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
        }
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #64748b;
        }
        .nav-tabs .nav-link.active {
            color: var(--brand-primary);
            border-bottom: 3px solid var(--brand-primary);
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Top Navbar -->
        <nav class="app-header navbar navbar-expand bg-white border-bottom shadow-sm">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list fs-5"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <span class="nav-link text-muted fw-medium">
                            <i class="bi bi-shield-check text-success me-1"></i> White-Label Dental Clinic CMS
                        </span>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (Auth::isImpersonating()): ?>
                        <li class="nav-item me-3">
                            <form method="POST" action="<?= App::url('/admin/users/stop-impersonate') ?>" class="d-inline">
                                <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm">
                                    <i class="bi bi-arrow-return-left me-1"></i> Return to Super Admin
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item me-3">
                        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> View Live Website
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 text-secondary"></i>
                            <span class="d-none d-md-inline fw-semibold"><?= htmlspecialchars($authUser['name'] ?? 'Admin') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="z-index: 1080;">
                            <li><h6 class="dropdown-header"><?= htmlspecialchars($authUser['email'] ?? 'admin@example.com') ?></h6></li>
                            <li><span class="dropdown-item-text text-muted small"><i class="bi bi-award me-1"></i> <?= htmlspecialchars($authUser['role'] ?? 'Super Admin') ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item fw-semibold" href="<?= App::url('/admin/profile') ?>" onclick="window.location.href=this.href; return false;">
                                    <i class="bi bi-person-gear me-2 text-success"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger fw-semibold" href="<?= App::url('/admin/logout') ?>" onclick="window.location.href=this.href; return false;">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Sidebar -->
        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <img src="<?= htmlspecialchars($clinicLogo) ?>" alt="Logo" class="brand-logo-img">
                <div class="brand-title-wrap">
                    <span class="brand-name-text" title="<?= htmlspecialchars($clinicName) ?>"><?= htmlspecialchars($clinicName) ?></span>
                    <small class="brand-tagline-text"><?= htmlspecialchars($clinicTagline) ?></small>
                </div>
            </div>

            <div class="sidebar-wrapper py-2">
                <nav>
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                        <!-- 1. DASHBOARD OVERVIEW -->
                        <li class="nav-header text-uppercase text-secondary px-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Main Overview</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/dashboard') ?>" class="nav-link <?= $activeNav === 'dashboard' ? 'active' : '' ?>">
                                <i class="bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- 2. CLINICAL APPOINTMENTS -->
                        <?php if (Auth::can('bookings') || Auth::can('doctors_availability')): ?>
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Clinical Appointments</li>
                        <?php if (Auth::can('bookings')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/bookings') ?>" class="nav-link <?= $activeNav === 'bookings' ? 'active' : '' ?>">
                                <i class="bi bi-calendar2-check-fill text-success"></i>
                                <p>Patient Bookings</p>
                                <span class="badge text-bg-success ms-auto">Roster</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (Auth::can('doctors_availability')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/doctors/availability') ?>" class="nav-link <?= $activeNav === 'doctor-availability' ? 'active' : '' ?>">
                                <i class="bi bi-clock-history text-info"></i>
                                <p>Doctor Availability & Leave</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>

                        <!-- 3. WEBSITE CMS -->
                        <?php if (Auth::can('cms_pages') || Auth::can('cms_components') || Auth::can('blog') || Auth::can('contact_submissions') || Auth::can('chat_logs') || Auth::can('theme') || Auth::can('settings')): ?>
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Website CMS</li>
                        <?php if (Auth::can('cms_pages')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/pages') ?>" class="nav-link <?= $activeNav === 'pages' ? 'active' : '' ?>">
                                <i class="bi bi-layout-text-window-reverse text-warning"></i>
                                <p>CMS Page List</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (Auth::can('contact_submissions')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/contact/submissions') ?>" class="nav-link <?= $activeNav === 'contact-submissions' ? 'active' : '' ?>">
                                <i class="bi bi-envelope-paper text-info"></i>
                                <p>Contact Form Entries</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (Auth::can('chat_logs')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/chat-logs') ?>" class="nav-link <?= $activeNav === 'chat-logs' ? 'active' : '' ?>">
                                <i class="bi bi-chat-dots-fill text-success"></i>
                                <p>Assistant Chat Logs</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (Auth::can('blog')): ?>
                        <!-- Blog & Articles (WordPress-style) -->
                        <li class="nav-header text-uppercase text-secondary px-3 mt-2 mb-1" style="font-size: 9.5px; letter-spacing: 0.06em; opacity: 0.85;">— Blog &amp; Articles</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/blog/posts') ?>" class="nav-link <?= $activeNav === 'blog-posts' ? 'active' : '' ?>">
                                <i class="bi bi-journal-richtext text-info"></i>
                                <p>All Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/blog/posts/create') ?>" class="nav-link <?= $activeNav === 'blog-new' ? 'active' : '' ?>">
                                <i class="bi bi-plus-circle"></i>
                                <p>Add New Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/blog/categories') ?>" class="nav-link <?= $activeNav === 'blog-categories' ? 'active' : '' ?>">
                                <i class="bi bi-folder2-open"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/blog/tags') ?>" class="nav-link <?= $activeNav === 'blog-tags' ? 'active' : '' ?>">
                                <i class="bi bi-tags"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (Auth::can('cms_components')): ?>
                        <!-- Common Components Nested -->
                        <li class="nav-header text-uppercase text-secondary px-3 mt-2 mb-1" style="font-size: 9.5px; letter-spacing: 0.06em; opacity: 0.85;">— Common Components</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/services') ?>" class="nav-link <?= $activeNav === 'comp-services' ? 'active' : '' ?>">
                                <i class="bi bi-grid-3x3-gap"></i>
                                <p>Services Grid</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/about') ?>" class="nav-link <?= $activeNav === 'comp-about' ? 'active' : '' ?>">
                                <i class="bi bi-info-circle"></i>
                                <p>About & Clinic Photos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/doctors') ?>" class="nav-link <?= $activeNav === 'comp-doctors' ? 'active' : '' ?>">
                                <i class="bi bi-people"></i>
                                <p>Doctors & Avatars</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/testimonials') ?>" class="nav-link <?= $activeNav === 'comp-testimonials' ? 'active' : '' ?>">
                                <i class="bi bi-star"></i>
                                <p>Patient Testimonials</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/charter') ?>" class="nav-link <?= $activeNav === 'comp-charter' ? 'active' : '' ?>">
                                <i class="bi bi-shield-check"></i>
                                <p>Safety Charter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/components/contact') ?>" class="nav-link <?= $activeNav === 'comp-contact' ? 'active' : '' ?>">
                                <i class="bi bi-geo-alt"></i>
                                <p>Hours & Map</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (Auth::can('theme')): ?>
                        <li class="nav-item mt-2">
                            <a href="<?= App::url('/admin/theme') ?>" class="nav-link <?= $activeNav === 'theme' ? 'active' : '' ?>">
                                <i class="bi bi-palette" style="color: #c084fc;"></i>
                                <p>Global Theme & Fonts</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (Auth::can('settings')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/settings') ?>" class="nav-link <?= $activeNav === 'settings' ? 'active' : '' ?>">
                                <i class="bi bi-gear-wide-connected text-primary"></i>
                                <p>Practice & Contact Settings</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>

                        <!-- 4. ACCOUNT & SECURITY -->
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Account &amp; Security</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/profile') ?>" class="nav-link <?= $activeNav === 'profile' ? 'active' : '' ?>">
                                <i class="bi bi-person-circle text-info"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <?php if (Auth::can('users')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/users') ?>" class="nav-link <?= $activeNav === 'users' ? 'active' : '' ?>">
                                <i class="bi bi-people-fill text-warning"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (Auth::can('logs')): ?>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/logs') ?>" class="nav-link <?= $activeNav === 'logs' ? 'active' : '' ?>">
                                <i class="bi bi-activity text-danger"></i>
                                <p>Activity Logs</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- 4. LIVE PATIENT WEBSITE -->
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Live Portal</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/') ?>" target="_blank" class="nav-link text-success">
                                <i class="bi bi-globe2"></i>
                                <p>Open Patient Website</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="app-main p-4">
            <div class="container-fluid">
                <!-- Alerts / Flash Messages -->
                <?php if (!empty($flashSuccess)): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                        <div><?= htmlspecialchars($flashSuccess) ?></div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($flashError)): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <div><?= htmlspecialchars($flashError) ?></div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Injected View Content -->
                <?= $content ?? '' ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer bg-white border-top py-3 text-muted small">
            <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    <strong><?= htmlspecialchars($clinicName) ?></strong> White-Label Dental Clinic Platform &copy; <?= date('Y') ?>. Built with Laravel MVC & Next.js Headless Architecture.
                </div>
                <div class="text-md-end fw-medium">
                    Design &amp; Developed by <a href="https://github.com/ratneshrsharma" target="_blank" class="text-decoration-none text-success fw-bold">Ratnesh Sharma</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
    <?php require dirname(__DIR__) . '/admin/components/_icon-picker.php'; ?>
</body>
</html>
