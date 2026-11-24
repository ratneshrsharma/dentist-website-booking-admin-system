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
            background-color: #0f172a !important;
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
        .btn-brand {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-brand:hover {
            filter: brightness(0.9);
            color: #ffffff;
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
                    <li class="nav-item me-3">
                        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> View Live Website
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-secondary"></i>
                            <span class="d-none d-md-inline fw-semibold"><?= htmlspecialchars($authUser['name'] ?? 'Admin') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><h6 class="dropdown-header"><?= htmlspecialchars($authUser['email'] ?? 'admin@example.com') ?></h6></li>
                            <li><span class="dropdown-item-text text-muted small"><i class="bi bi-award me-1"></i> <?= htmlspecialchars($authUser['role'] ?? 'Super Administrator') ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger fw-semibold" href="<?= App::url('/admin/logout') ?>">
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
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Clinical Appointments</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/bookings') ?>" class="nav-link <?= $activeNav === 'bookings' ? 'active' : '' ?>">
                                <i class="bi bi-calendar2-check-fill text-success"></i>
                                <p>Patient Bookings</p>
                                <span class="badge text-bg-success ms-auto">Roster</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/doctors/availability') ?>" class="nav-link <?= $activeNav === 'doctor-availability' ? 'active' : '' ?>">
                                <i class="bi bi-clock-history text-info"></i>
                                <p>Doctor Availability & Leave</p>
                            </a>
                        </li>

                        <!-- 3. WEBSITE CMS -->
                        <li class="nav-header text-uppercase text-secondary px-3 mt-3 mb-1" style="font-size: 10px; letter-spacing: 0.08em;">Website CMS</li>
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/pages') ?>" class="nav-link <?= $activeNav === 'pages' ? 'active' : '' ?>">
                                <i class="bi bi-layout-text-window-reverse text-warning"></i>
                                <p>CMS Page List</p>
                            </a>
                        </li>

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

                        <!-- Global Theme & Whitelabeling -->
                        <li class="nav-item mt-2">
                            <a href="<?= App::url('/admin/theme') ?>" class="nav-link <?= $activeNav === 'theme' ? 'active' : '' ?>">
                                <i class="bi bi-palette" style="color: #c084fc;"></i>
                                <p>Global Theme & Fonts</p>
                            </a>
                        </li>

                        <!-- Practice & Communication Settings -->
                        <li class="nav-item">
                            <a href="<?= App::url('/admin/settings') ?>" class="nav-link <?= $activeNav === 'settings' ? 'active' : '' ?>">
                                <i class="bi bi-gear-wide-connected text-primary"></i>
                                <p>Practice & Contact Settings</p>
                            </a>
                        </li>

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
        <footer class="app-footer bg-white border-top py-3 text-center text-muted small">
            <div class="container-fluid">
                <strong><?= htmlspecialchars($clinicName) ?></strong> White-Label Dental Clinic Platform &copy; <?= date('Y') ?>. Built with Laravel MVC & Next.js Headless Architecture.
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>
