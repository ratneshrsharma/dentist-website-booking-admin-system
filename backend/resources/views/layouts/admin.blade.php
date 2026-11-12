<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Advanced Dental Clinic Multi-Clinic Dental Management System')</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & AdminLTE 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">

    <!-- FullCalendar 6 for Clinical Scheduling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css">

    <style>
        :root {
            --app-primary: #0D9488;
            --app-primary-hover: #0F766E;
            --app-accent: #F59E0B;
            --app-dark: #0F172A;
            --app-sidebar-bg: #1E293B;
            --font-family-base: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font-family-base);
            background-color: #F8FAFC;
            color: #1E293B;
        }

        .app-sidebar {
            background-color: var(--app-sidebar-bg) !important;
        }

        .sidebar-brand {
            height: auto !important;
            min-height: 4.25rem !important;
            padding: 0.75rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            background-color: #0F172A !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .sidebar-brand .brand-link {
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            white-space: normal !important;
            line-height: 1.25 !important;
            text-decoration: none !important;
            width: 100% !important;
        }

        .brand-icon-box {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0D9488, #0F766E);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-details {
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
        }

        .brand-text {
            font-weight: 800;
            font-size: 0.9375rem;
            letter-spacing: -0.01em;
            color: #FFFFFF !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .brand-subtext {
            font-size: 0.6875rem;
            color: #94A3B8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            margin-top: 2px;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .nav-bell-btn {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .nav-bell-btn:hover {
            background-color: #F1F5F9;
        }

        .nav-bell-badge {
            top: 4px;
            right: 4px;
            font-size: 0.65rem;
            padding: 0.22em 0.45em;
            line-height: 1;
            box-shadow: 0 0 0 2px #FFFFFF;
            font-weight: 700;
        }

        .clinic-selector-badge {
            background: rgba(13, 148, 136, 0.15);
            border: 1px solid var(--app-primary);
            color: var(--app-primary);
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
        }

        .nav-link.active {
            background-color: var(--app-primary) !important;
            color: #FFFFFF !important;
            border-radius: 0.5rem;
        }

        .card {
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            font-weight: 700;
        }

        /* Odontogram Surface Styles */
        .tooth-surface {
            fill: #FFFFFF;
            stroke: #475569;
            stroke-width: 1.5;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tooth-surface:hover {
            fill: #CCFBF1;
            stroke: #0D9488;
        }

        .tooth-surface.caries {
            fill: #EF4444 !important;
        }

        .tooth-surface.filling {
            fill: #3B82F6 !important;
        }

        .tooth-surface.crown {
            fill: #F59E0B !important;
        }

        .tooth-surface.root_canal {
            fill: #8B5CF6 !important;
        }

        .tooth-surface.extracted {
            fill: #64748B !important;
            stroke-dasharray: 2, 2;
        }

        .tooth-surface.implant {
            fill: #10B981 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Top Navbar -->
        <nav class="app-header navbar navbar-expand bg-body shadow-sm">
            <div class="container-fluid">
                <!-- Sidebar Toggle -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                </ul>

                <!-- Multi-Clinic Global Switcher -->
                <div class="d-none d-md-flex align-items-center ms-3">
                    <span class="text-muted small me-2"><i class="bi bi-hospital"></i> Active Branch:</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle clinic-selector-badge" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-geo-alt-fill me-1"></i> Metro Dental Headquarters
                        </button>
                        <ul class="dropdown-menu shadow">
                            <li><h6 class="dropdown-header">Switch Clinic Location</h6></li>
                            <li><a class="dropdown-item active" href="?clinic=1"><i class="bi bi-check2 text-success me-2"></i>Metro Dental HQ (New York)</a></li>
                            <li><a class="dropdown-item" href="?clinic=2"><i class="bi bi-building me-2"></i>Downtown Smiles Branch (West 57th)</a></li>
                            <li><a class="dropdown-item" href="?clinic=3"><i class="bi bi-building me-2"></i>Westside Pediatric & Family Dental</a></li>
                            <li data-roles="super_admin,admin"><hr class="dropdown-divider"></li>
                            <li data-roles="super_admin,admin"><a class="dropdown-item text-primary fw-bold" href="{{ url('/admin/multi-clinic') }}"><i class="bi bi-grid-fill me-2"></i>All-Clinics Central Monitor</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Right Navbar Links -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Quick Emergency Triage Notification -->
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative nav-bell-btn" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="Urgent Clinical Notifications">
                            <i class="bi bi-bell fs-5 text-secondary"></i>
                            <span class="badge bg-danger rounded-pill position-absolute nav-bell-badge">
                                3
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow border-0 mt-2" style="min-width: 320px; border-radius: 12px;">
                            <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark small mb-0"><i class="bi bi-bell-fill text-danger me-2"></i>3 Urgent Clinical Alerts</span>
                                <span class="badge bg-danger-subtle text-danger small">Action Required</span>
                            </div>
                            <div class="list-group list-group-flush small">
                                <a href="{{ url('/admin/appointments/calendar') }}" class="list-group-item list-group-item-action py-2 px-3 border-bottom">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <strong class="text-danger"><i class="bi bi-exclamation-octagon-fill me-1"></i>Emergency Triage</strong>
                                        <small class="text-muted">4m ago</small>
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 0.78rem;">Severe acute trauma - Patient David S. arriving in Chair 1.</p>
                                </a>
                                <a href="{{ url('/admin/inventory') }}" class="list-group-item list-group-item-action py-2 px-3 border-bottom">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <strong class="text-warning"><i class="bi bi-box-seam-fill me-1"></i>Low Material Stock</strong>
                                        <small class="text-muted">1h ago</small>
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 0.78rem;">Straumann BLX Implants below threshold (3 remaining).</p>
                                </a>
                                <a href="{{ url('/admin/billing') }}" class="list-group-item list-group-item-action py-2 px-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <strong class="text-primary"><i class="bi bi-cash-stack me-1"></i>POS Claim Settled</strong>
                                        <small class="text-muted">2h ago</small>
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 0.78rem;">Invoice INV-2026-0891 confirmed paid (£1,650.00).</p>
                                </a>
                            </div>
                            <div class="p-2 border-top text-center bg-light">
                                <a href="{{ url('/admin/dashboard') }}" class="small text-decoration-none fw-semibold text-primary">View Clinical Dashboard Overview</a>
                            </div>
                        </div>
                    </li>

                    <!-- User Account Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="dropdown" href="#">
                            <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: var(--app-primary);">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="d-none d-sm-block text-start">
                                <span class="d-block fw-semibold text-dark small lh-1">@yield('user_name', 'Dr. Alexander Vance')</span>
                                <span class="badge bg-primary-subtle text-primary border small" style="font-size: 0.65rem;">@yield('user_role_label', 'Super Administrator')</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li class="px-3 py-2 border-bottom">
                                <span class="d-block fw-bold text-dark small">@yield('user_name', 'Dr. Alexander Vance')</span>
                                <small class="text-muted">@yield('user_email', 'admin@example.com')</small>
                            </li>
                            <!-- Admin Links -->
                            <li data-roles="super_admin,admin"><a class="dropdown-item" href="{{ url('/admin/roles') }}"><i class="bi bi-shield-lock me-2 text-warning"></i>Security & Permissions</a></li>
                            <li data-roles="super_admin,admin"><a class="dropdown-item" href="{{ url('/admin/clinics') }}"><i class="bi bi-hospital me-2 text-primary"></i>Branch Facilities</a></li>
                            <!-- Doctor Links -->
                            <li data-roles="doctor"><a class="dropdown-item" href="{{ url('/admin/emr/odontogram') }}"><i class="bi bi-diagram-3-fill me-2 text-danger"></i>Clinical Odontogram EMR</a></li>
                            <li data-roles="doctor"><a class="dropdown-item" href="{{ url('/admin/patients') }}"><i class="bi bi-people-fill me-2 text-primary"></i>My Assigned Patients</a></li>
                            <!-- Receptionist Links -->
                            <li data-roles="receptionist"><a class="dropdown-item" href="{{ url('/admin/appointments/calendar') }}"><i class="bi bi-calendar-check me-2 text-info"></i>Appointments Roster</a></li>
                            <li data-roles="receptionist"><a class="dropdown-item" href="{{ url('/admin/patients') }}"><i class="bi bi-person-plus me-2 text-primary"></i>Patient Intake</a></li>
                            <!-- Website Manager Links -->
                            <li data-roles="website_manager"><a class="dropdown-item" href="{{ url('/admin/cms-pages') }}"><i class="bi bi-globe me-2 text-success"></i>Website CMS Pages</a></li>
                            <li data-roles="website_manager"><a class="dropdown-item" href="{{ url('/admin/theme-customizer') }}"><i class="bi bi-palette2 me-2 text-warning"></i>Theme Customizer</a></li>
                            <!-- Billing Officer Links -->
                            <li data-roles="billing"><a class="dropdown-item" href="{{ url('/admin/billing') }}"><i class="bi bi-receipt-cutoff me-2 text-dark"></i>Billing Ledger & POS</a></li>
                            <li data-roles="billing"><a class="dropdown-item" href="{{ url('/admin/inventory') }}"><i class="bi bi-box-seam me-2 text-secondary"></i>Dental Supplies</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-semibold" href="{{ url('/admin/logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ url('/admin/dashboard') }}" class="brand-link">
                    <div class="brand-icon-box">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div class="brand-details">
                        <span class="brand-text">Advanced Dental <span class="badge bg-success small" style="font-size: 0.625rem; padding: 0.25em 0.5em;">PRO</span></span>
                        <span class="brand-subtext">Clinical EMR & Logistics</span>
                    </div>
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                        <!-- Section: Clinical Operations -->
                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2" data-section="clinical">Clinical Operations</li>
                        <li class="nav-item" data-nav="dashboard" data-roles="super_admin,admin,doctor,receptionist,website_manager,billing">
                            <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Practice Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="calendar" data-roles="super_admin,admin,doctor,receptionist,billing">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="nav-link">
                                <i class="nav-icon bi bi-calendar-week"></i>
                                <p>Scheduler & Calendar</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="odontogram" data-roles="super_admin,admin,doctor">
                            <a href="{{ url('/admin/emr/odontogram') }}" class="nav-link">
                                <i class="nav-icon bi bi-diagram-3-fill"></i>
                                <p>Odontogram EMR</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="patients" data-roles="super_admin,admin,doctor,receptionist,billing">
                            <a href="{{ url('/admin/patients') }}" class="nav-link">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Patient Records (EHR)</p>
                            </a>
                        </li>

                        <!-- Section: Logistics & Finance -->
                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2 mt-2" data-section="logistics" data-roles="super_admin,admin,doctor,billing">Logistics & Finance</li>
                        <li class="nav-item" data-nav="clinics" data-roles="super_admin,admin">
                            <a href="{{ url('/admin/clinics') }}" class="nav-link">
                                <i class="nav-icon bi bi-buildings"></i>
                                <p>Multi-Clinic Manager</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="inventory" data-roles="super_admin,admin,doctor,billing">
                            <a href="{{ url('/admin/inventory') }}" class="nav-link">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Dental Supplies & Stock</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="billing" data-roles="super_admin,admin,billing">
                            <a href="{{ url('/admin/billing') }}" class="nav-link">
                                <i class="nav-icon bi bi-receipt-cutoff"></i>
                                <p>Billing, Invoices & POS</p>
                            </a>
                        </li>

                        <!-- Section: Website & System -->
                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2 mt-2" data-section="website" data-roles="super_admin,admin,website_manager">Website & System</li>
                        <li class="nav-item" data-nav="theme-customizer" data-roles="super_admin,admin,website_manager">
                            <a href="{{ url('/admin/theme-customizer') }}" class="nav-link">
                                <i class="nav-icon bi bi-palette2"></i>
                                <p>Theme Customizer</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="seo-manager" data-roles="super_admin,admin,website_manager">
                            <a href="{{ url('/admin/seo-manager') }}" class="nav-link">
                                <i class="nav-icon bi bi-search"></i>
                                <p>Yoast SEO & Scripts</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="seo-redirects" data-roles="super_admin,admin,website_manager">
                            <a href="{{ url('/admin/seo-redirects') }}" class="nav-link">
                                <i class="nav-icon bi bi-signpost-split"></i>
                                <p>URL 301 Redirects</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="cms-pages" data-roles="super_admin,admin,website_manager">
                            <a href="{{ url('/admin/cms-pages') }}" class="nav-link">
                                <i class="nav-icon bi bi-globe"></i>
                                <p>Website CMS Manager</p>
                            </a>
                        </li>
                        <li class="nav-item" data-nav="roles" data-roles="super_admin,admin">
                            <a href="{{ url('/admin/roles') }}" class="nav-link">
                                <i class="nav-icon bi bi-shield-check"></i>
                                <p>Staff RBAC & Roles</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="app-main">
            <div class="app-content-header py-3">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-0 fw-bold">@yield('page_title', 'Practice Dashboard')</h3>
                            <p class="text-muted small mb-0">@yield('page_subtitle', 'Real-time multi-branch dental clinical management')</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                @yield('page_actions')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Body -->
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Main Footer -->
        <footer class="app-footer text-muted small py-3 border-top bg-white">
            <div class="container-fluid d-flex justify-content-between">
                <span>&copy; {{ date('Y') }} <strong>Advanced Dental Clinic</strong> Multi-Clinic System. All rights reserved.</span>
                <span class="text-success"><i class="bi bi-shield-lock-fill"></i> HIPAA & OSHA Compliant v2.4.0</span>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    @stack('scripts')
</body>
</html>
