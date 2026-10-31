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

        .brand-link {
            background-color: #0F172A !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 1rem 1.25rem !important;
        }

        .brand-text {
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #FFFFFF !important;
        }

        .brand-subtext {
            font-size: 0.6875rem;
            color: #94A3B8;
            display: block;
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
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-primary fw-bold" href="{{ url('/admin/multi-clinic') }}"><i class="bi bi-grid-fill me-2"></i>All-Clinics Central Monitor</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Right Navbar Links -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Quick Emergency Triage Notification -->
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
                            <span class="dropdown-item dropdown-header fw-bold">3 Urgent Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Emergency triage: Severe trauma
                                <span class="float-end text-muted text-sm">4 mins ago</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-box-seam-fill text-warning me-2"></i> Low stock: Titanium Implants (Batch #849)
                                <span class="float-end text-muted text-sm">1 hour ago</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer text-center">View All Notifications</a>
                        </div>
                    </li>

                    <!-- User Account Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="dropdown" href="#">
                            <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: var(--app-primary);">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="d-none d-sm-block text-start">
                                <span class="d-block fw-semibold text-dark small lh-1">Dr. Alexander Vance</span>
                                <span class="text-muted" style="font-size: 0.6875rem;">Super Administrator</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person-badge me-2"></i>Doctor Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock me-2"></i>Security & 2FA</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ url('/admin/dashboard') }}" class="brand-link text-decoration-none">
                    <span class="brand-text">Advanced Dental <span class="badge bg-success small ms-1">PRO</span></span>
                    <span class="brand-subtext">Clinical EMR & Logistics</span>
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2">Clinical Operations</li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/dashboard') }}" class="nav-link @if(request()->is('admin/dashboard*')) active @endif">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Practice Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="nav-link @if(request()->is('admin/appointments*')) active @endif">
                                <i class="nav-icon bi bi-calendar-week"></i>
                                <p>Scheduler & Calendar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/emr/odontogram') }}" class="nav-link @if(request()->is('admin/emr*')) active @endif">
                                <i class="nav-icon bi bi-diagram-3-fill"></i>
                                <p>Odontogram EMR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/patients') }}" class="nav-link @if(request()->is('admin/patients*')) active @endif">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Patient Records (EHR)</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2 mt-2">Logistics & Finance</li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/multi-clinic') }}" class="nav-link @if(request()->is('admin/multi-clinic*')) active @endif">
                                <i class="nav-icon bi bi-buildings"></i>
                                <p>Multi-Clinic Manager</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/inventory') }}" class="nav-link @if(request()->is('admin/inventory*')) active @endif">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Dental Supplies & Stock</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/billing') }}" class="nav-link @if(request()->is('admin/billing*')) active @endif">
                                <i class="nav-icon bi bi-receipt-cutoff"></i>
                                <p>Billing, Invoices & POS</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase text-secondary small fw-bold px-3 py-2 mt-2">Website & System</li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/cms') }}" class="nav-link @if(request()->is('admin/cms*')) active @endif">
                                <i class="nav-icon bi bi-globe"></i>
                                <p>Website CMS Manager</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/users') }}" class="nav-link @if(request()->is('admin/users*')) active @endif">
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
