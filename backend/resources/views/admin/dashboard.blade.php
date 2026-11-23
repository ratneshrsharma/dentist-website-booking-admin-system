@extends('layouts.admin')

@section('title', 'Practice Dashboard - Advanced Dental Clinic')
@section('page_title', 'Practice Dashboard')
@section('page_subtitle', 'Role-tailored clinical, administrative, and website operations')

@section('page_actions')
    <div class="d-flex gap-2 flex-wrap justify-content-sm-end align-items-center">
        <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-primary shadow-sm" data-roles="super_admin,admin,receptionist">
            <i class="bi bi-calendar-plus me-1.5"></i> Quick Walk-In Booking
        </a>
        <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-sm btn-outline-secondary shadow-sm" data-roles="super_admin,admin,doctor">
            <i class="bi bi-diagram-3 me-1.5"></i> Launch Odontogram EMR
        </a>
        <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-primary shadow-sm" data-roles="website_manager">
            <i class="bi bi-globe me-1.5"></i> Manage CMS Pages
        </a>
        <a href="{{ url('/admin/theme-customizer') }}" class="btn btn-sm btn-outline-secondary shadow-sm" data-roles="website_manager">
            <i class="bi bi-palette2 me-1.5"></i> Theme Customizer
        </a>
        <a href="{{ url('/admin/billing') }}" class="btn btn-sm btn-primary shadow-sm" data-roles="billing">
            <i class="bi bi-receipt me-1.5"></i> New Billing Invoice
        </a>
    </div>
@endsection

@section('content')
<?php
// Resolve authenticated user profile from session or fallback
$authUser = $_SESSION['auth_user'] ?? (function_exists('auth') && auth()->user() ? auth()->user()->toArray() : [
    'name' => 'Demo Administrator',
    'role' => 'super_admin',
    'role_label' => 'Super Administrator',
    'email' => 'admin@example.com',
]);
$userRole = $authUser['role'] ?? 'super_admin';

// Unified Branch Data Source of Truth for Chairs & Financials (Senior Dev Item 5 Sync & Item 4 GBP £)
$branchData = [
    [
        'name' => 'Metro Dental Headquarters',
        'location' => 'Acocks Green, Warwick Road (Main Surgery)',
        'doctors_on_duty' => 4,
        'active_chairs' => 7,
        'total_chairs' => 8,
        'appts_today' => 22,
        'revenue_mtd' => '£54,200',
        'status' => 'Optimal',
        'status_class' => 'bg-success-subtle text-success',
    ],
    [
        'name' => 'Downtown Smiles Branch',
        'location' => 'Birmingham City Centre (Cosmetic Suite)',
        'doctors_on_duty' => 2,
        'active_chairs' => 4,
        'total_chairs' => 4,
        'appts_today' => 12,
        'revenue_mtd' => '£38,600',
        'status' => 'High Load',
        'status_class' => 'bg-warning-subtle text-warning',
    ],
    [
        'name' => 'Westside Pediatric & Family',
        'location' => 'Solihull Road (Orthodontic & Child EMR)',
        'doctors_on_duty' => 2,
        'active_chairs' => 3,
        'total_chairs' => 4,
        'appts_today' => 8,
        'revenue_mtd' => '£21,450',
        'status' => 'Normal',
        'status_class' => 'bg-success-subtle text-success',
    ],
];

$totalActiveChairs = array_sum(array_column($branchData, 'active_chairs')); // 7 + 4 + 3 = 14
$totalCapacityChairs = array_sum(array_column($branchData, 'total_chairs')); // 8 + 4 + 4 = 16
$occupancyPercentage = round(($totalActiveChairs / $totalCapacityChairs) * 100, 1); // 87.5%
?>

<?php if ($userRole === 'website_manager'): ?>
    <!-- ======================================================================= -->
    <!-- 1. WEBSITE MANAGER DASHBOARD (STRICT PRIVACY: NO PATIENTS, NO REVENUE) -->
    <!-- ======================================================================= -->
    <!-- Row 1: Website & SEO KPIs -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Published CMS Pages</span>
                    <div class="stat-value">4 Active</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-check-circle me-1"></i> 100% API Hydrated
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-globe"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Yoast SEO Score</span>
                    <div class="stat-value">100% Score</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-shield-check me-1"></i> Meta & Schema Ready
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-success">
                    <i class="bi bi-search"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Code Injection</span>
                    <div class="stat-value">GTM & Scripts</div>
                    <span class="badge bg-info-subtle text-info stat-meta">
                        <i class="bi bi-code-slash me-1"></i> Head & Body Active
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-info">
                    <i class="bi bi-code-square"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">301 Redirect Rules</span>
                    <div class="stat-value">14 Rules</div>
                    <span class="badge bg-warning-subtle text-warning stat-meta">
                        <i class="bi bi-arrow-left-right me-1"></i> Zero 404 Leaks
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-signpost-split"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Public Website Pages & SEO Health -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-file-earmark-text text-primary me-2"></i>Live Patient Portal CMS Pages</span>
                    <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-outline-primary">Open CMS Studio &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="min-width: 200px;">Page Title & URL</th>
                                <th class="text-nowrap" style="min-width: 140px;">Category</th>
                                <th class="text-nowrap" style="min-width: 220px;">SEO Meta Title</th>
                                <th class="text-nowrap" style="min-width: 120px;">Status</th>
                                <th class="text-end pe-3 text-nowrap" style="min-width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Treatments & Clinical Services</strong>
                                    <span class="text-muted small"><code>/treatments/</code></span>
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary">Clinical Services</span></td>
                                <td><small class="text-muted">NHS & Private Dental Treatments in Birmingham</small></td>
                                <td><span class="badge bg-success">Live & Published</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">About Our Surgery & Clinicians</strong>
                                    <span class="text-muted small"><code>/about-us/</code></span>
                                </td>
                                <td><span class="badge bg-info-subtle text-info">Practice Profile</span></td>
                                <td><small class="text-muted">About Acocks Green Dental Practice</small></td>
                                <td><span class="badge bg-success">Live & Published</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Contact & Emergency Appointments</strong>
                                    <span class="text-muted small"><code>/contact/</code></span>
                                </td>
                                <td><span class="badge bg-warning-subtle text-warning">Patient Contact</span></td>
                                <td><small class="text-muted">Contact Acocks Green Dental Surgery</small></td>
                                <td><span class="badge bg-success">Live & Published</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Homepage & Booking Hub</strong>
                                    <span class="text-muted small"><code>/</code></span>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Main Landing</span></td>
                                <td><small class="text-muted">Acocks Green Dental - NHS & Private Dental Care</small></td>
                                <td><span class="badge bg-success">Live & Published</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/cms-pages') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-sliders text-teal me-2" style="color: #0D9488;"></i>Digital Presence & Scripts</span>
                </div>
                <div class="card-body">
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-bold text-dark">Active Brand Theme</span>
                            <span class="badge bg-teal text-white" style="background-color: #0D9488;">Confident Doctor</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #0D9488;" title="Primary #0D9488"></div>
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #0F766E;" title="Dark #0F766E"></div>
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #0F172A;" title="Surface #0F172A"></div>
                            <span class="small text-muted ms-1">Plus Jakarta Sans font</span>
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-bold text-dark">Google Tag Manager (GTM)</span>
                            <span class="badge bg-success-subtle text-success">Head & Body Active</span>
                        </div>
                        <small class="text-muted font-monospace d-block">Container ID: GTM-AGD2026</small>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-bold text-dark">WhatsApp Floating Contact</span>
                            <span class="badge bg-success text-white"><i class="bi bi-whatsapp me-1"></i>Active</span>
                        </div>
                        <small class="text-muted d-block">Routing: <strong>+919904379260</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Website Management Quick Actions -->
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Website Management Quick Actions</span>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ url('/admin/cms-pages') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-file-earmark-richtext-fill fs-4 text-primary d-block mb-1"></i>
                                <strong class="d-block text-dark">CMS Page Studio</strong>
                                <span class="text-muted small">Update treatments & headlines</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/theme-customizer') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-palette2 fs-4 text-warning d-block mb-1"></i>
                                <strong class="d-block text-dark">Theme Customizer</strong>
                                <span class="text-muted small">Colors, logos & typography</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/seo-manager') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-search fs-4 text-info d-block mb-1"></i>
                                <strong class="d-block text-dark">Yoast SEO Manager</strong>
                                <span class="text-muted small">Meta tags & OpenGraph social</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/seo-redirects') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-signpost-split-fill fs-4 text-secondary d-block mb-1"></i>
                                <strong class="d-block text-dark">301 Redirect Rules</strong>
                                <span class="text-muted small">Prevent broken 404 links</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-clock-history text-secondary me-2"></i>Website Maintenance & Cleanup Log</span>
                </div>
                <div class="list-group list-group-flush small">
                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-success"><i class="bi bi-check-circle-fill me-1"></i>10 Obsolete Pages Removed</strong>
                            <small class="text-muted">Today</small>
                        </div>
                        <p class="mb-0 text-secondary" style="font-size: 0.78rem;">Purged legacy secondary theme pages, our-team, technology, and why-choose-us. 301 redirects active.</p>
                    </div>
                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-primary"><i class="bi bi-arrow-repeat me-1"></i>Homepage Services Synchronized</strong>
                            <small class="text-muted">Today</small>
                        </div>
                        <p class="mb-0 text-secondary" style="font-size: 0.78rem;">Aligned homepage services with Treatments catalog: 6 clinical cards with NHS & Private pricing chips.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($userRole === 'doctor'): ?>
    <!-- ======================================================================= -->
    <!-- 2. DOCTOR CLINICAL WORKSPACE DASHBOARD (EMR, ODONTOGRAM, SURGICAL CASES)-->
    <!-- ======================================================================= -->
    <!-- Row 1: Doctor KPIs (No financial revenues) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">My Assigned Patients</span>
                    <div class="stat-value">12 Patients</div>
                    <span class="badge bg-primary-subtle text-primary stat-meta">
                        <i class="bi bi-person-check me-1"></i> 4 Completed • 8 Pending
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Next Case in Chair</span>
                    <div class="stat-value">Chair 1</div>
                    <span class="badge bg-danger-subtle text-danger stat-meta">
                        <i class="bi bi-heart-pulse me-1"></i> Sarah Jenkins (Pulpitis)
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-danger">
                    <i class="bi bi-hospital"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Pending Odontograms</span>
                    <div class="stat-value">3 Charts</div>
                    <span class="badge bg-warning-subtle text-warning stat-meta">
                        <i class="bi bi-clock-history me-1"></i> EMR Charting Required
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Urgent Clinical Queue</span>
                    <div class="stat-value">2 Urgent</div>
                    <span class="badge bg-danger text-white stat-meta">
                        <i class="bi bi-exclamation-triangle me-1"></i> Priority Triage
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-danger">
                    <i class="bi bi-lightning-charge"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Doctor's Schedule & Urgent Clinical Queue -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-calendar2-check text-primary me-2"></i>My Surgical & Clinical Schedule Today</span>
                    <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-sm btn-outline-primary">Open Full Calendar &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="min-width: 170px;">Patient Name & MRN</th>
                                <th class="text-nowrap" style="min-width: 130px;">Scheduled Time</th>
                                <th style="min-width: 200px;">Clinical Procedure</th>
                                <th class="text-nowrap" style="min-width: 120px;">Assigned Chair</th>
                                <th class="text-nowrap" style="min-width: 110px;">Status</th>
                                <th class="text-end pe-3 text-nowrap" style="min-width: 120px;">Odontogram</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Sarah Jenkins</strong>
                                    <span class="badge bg-secondary-subtle text-secondary small">MRN: #DF-99248</span>
                                </td>
                                <td><span class="fw-bold text-danger">10:00 AM</span> <small class="text-muted">(Now)</small></td>
                                <td>Suspected Acute Pulpitis (Tooth #19)</td>
                                <td><span class="badge bg-primary">Chair 1</span></td>
                                <td><span class="badge bg-danger-subtle text-danger">In Chair</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/emr/odontogram?patient_id=1042') }}" class="btn btn-sm btn-danger">
                                        <i class="bi bi-diagram-3-fill me-1"></i>Open Chart
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Michael Rodriguez</strong>
                                    <span class="badge bg-secondary-subtle text-secondary small">MRN: #DF-1043</span>
                                </td>
                                <td>10:30 AM</td>
                                <td>All-on-4 Guided Surgical Consultation & CT Review</td>
                                <td><span class="badge bg-primary">Chair 1</span></td>
                                <td><span class="badge bg-info-subtle text-info">Waiting Room</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/emr/odontogram?patient_id=1043') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-diagram-3 me-1"></i>Open Chart
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">David Sample</strong>
                                    <span class="badge bg-secondary-subtle text-secondary small">MRN: #DF-1045</span>
                                </td>
                                <td>11:45 AM</td>
                                <td>Lower Molar Restoration & Bone Graft Review</td>
                                <td><span class="badge bg-secondary">Chair 2</span></td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Scheduled</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/emr/odontogram?patient_id=1045') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-diagram-3 me-1"></i>Open Chart
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Emily Watson</strong>
                                    <span class="badge bg-secondary-subtle text-secondary small">MRN: #DF-1046</span>
                                </td>
                                <td>02:00 PM</td>
                                <td>Invisalign Tray Delivery & Attachment Bonding</td>
                                <td><span class="badge bg-info">Chair 3</span></td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Scheduled</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/emr/odontogram?patient_id=1046') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-diagram-3 me-1"></i>Open Chart
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-danger"><i class="bi bi-clock-history me-2"></i>Live Urgent Clinical Triage</span>
                    <span class="badge bg-danger">2 Critical</span>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-danger">Sarah Jenkins (Pain: 8/10)</strong>
                            <small class="text-muted">10:00 AM</small>
                        </div>
                        <p class="mb-1 small text-dark">Suspected Acute Pulpitis (Tooth #19). Vitality test cold negative. Awaiting pulpectomy in Chair 1.</p>
                        <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Acocks Green Main Clinic • Chair 1</small>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-primary">Michael Rodriguez (Implant)</strong>
                            <small class="text-muted">10:30 AM</small>
                        </div>
                        <p class="mb-1 small text-dark">CBCT 3D Scan review for #19 / #20 implant fixture placement. Bone density Type II.</p>
                        <small class="text-muted"><i class="bi bi-geo-alt-fill text-primary me-1"></i>Acocks Green Main Clinic • Chair 1</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Restorative & Implant Materials Stock -->
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-box-seam-fill text-warning me-2"></i>Surgical & Restorative Stock Thresholds</span>
                    <a href="{{ url('/admin/inventory') }}" class="btn btn-sm btn-link text-decoration-none">Supplies Catalog &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Clinical Material</th>
                                <th>Available</th>
                                <th>Threshold</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>IMP-4010</code></td>
                                <td>Straumann BLX Implant Fixture 4.1mm</td>
                                <td><strong class="text-danger">3 units</strong></td>
                                <td>10 units</td>
                                <td><span class="badge bg-danger">Critical</span></td>
                            </tr>
                            <tr>
                                <td><code>LIDO-2P</code></td>
                                <td>Lidocaine 2% with Epinephrine 1:100k</td>
                                <td><strong class="text-warning">12 ampules</strong></td>
                                <td>20 ampules</td>
                                <td><span class="badge bg-warning text-dark">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td><code>COMP-A2</code></td>
                                <td>3M Filtek Supreme Universal Resin (A2)</td>
                                <td><strong class="text-success">8 syringes</strong></td>
                                <td>5 syringes</td>
                                <td><span class="badge bg-success">Adequate</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Doctor Quick Actions</span>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-diagram-3-fill fs-4 text-primary d-block mb-1"></i>
                                <strong class="d-block text-dark">Odontogram EMR</strong>
                                <span class="text-muted small">Record adult & pediatric charts</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/patients') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-people-fill fs-4 text-success d-block mb-1"></i>
                                <strong class="d-block text-dark">Patient Directory</strong>
                                <span class="text-muted small">Medical histories & X-rays</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-calendar-week fs-4 text-info d-block mb-1"></i>
                                <strong class="d-block text-dark">Surgery Roster</strong>
                                <span class="text-muted small">Daily chair schedule</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/inventory') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-box-seam fs-4 text-secondary d-block mb-1"></i>
                                <strong class="d-block text-dark">Implant Materials</strong>
                                <span class="text-muted small">View restorative supplies</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($userRole === 'receptionist'): ?>
    <!-- ======================================================================= -->
    <!-- 3. RECEPTIONIST / FRONT DESK DASHBOARD (CHECK-INS, ARRIVALS, CHAIRS)   -->
    <!-- ======================================================================= -->
    <!-- Row 1: Receptionist KPIs (No clinical diagnoses, no financial ledgers) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Today's Appointments</span>
                    <div class="stat-value">42 Total</div>
                    <span class="badge bg-primary-subtle text-primary stat-meta">
                        <i class="bi bi-calendar-check me-1"></i> Scheduled Roster
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Waiting Room</span>
                    <div class="stat-value">4 Waiting</div>
                    <span class="badge bg-warning-subtle text-warning stat-meta">
                        <i class="bi bi-hourglass-split me-1"></i> Avg wait: 8 mins
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Chair Utilization</span>
                    <div class="stat-value"><?= $totalActiveChairs ?> of <?= $totalCapacityChairs ?> Active</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-check-circle me-1"></i> <?= $occupancyPercentage ?>% Capacity
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-success">
                    <i class="bi bi-person-wheelchair"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Walk-In Inquiries</span>
                    <div class="stat-value">6 Enquiries</div>
                    <span class="badge bg-info-subtle text-info stat-meta">
                        <i class="bi bi-person-plus me-1"></i> Registered Today
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-info">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Live Waiting Room & Arrival Roster -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-person-lines-fill text-primary me-2"></i>Live Waiting Room & Arrival Roster</span>
                    <span class="badge bg-light text-dark border">Front Desk Feed</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="min-width: 170px;">Patient Name</th>
                                <th class="text-nowrap" style="min-width: 120px;">Arrival Time</th>
                                <th class="text-nowrap" style="min-width: 160px;">Assigned Clinician</th>
                                <th class="text-nowrap" style="min-width: 120px;">Chair</th>
                                <th class="text-nowrap" style="min-width: 120px;">Intake Status</th>
                                <th class="text-end pe-3 text-nowrap" style="min-width: 110px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Sarah Jenkins</strong>
                                    <span class="text-muted small">+44 7700 900123</span>
                                </td>
                                <td><span class="badge bg-primary">09:55 AM</span></td>
                                <td>Dr. Alexander Vance</td>
                                <td><span class="badge bg-dark">Chair 1</span></td>
                                <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check2-circle me-1"></i>In Chair</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-secondary" disabled>In Surgery</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">Michael Rodriguez</strong>
                                    <span class="text-muted small">+44 7700 900456</span>
                                </td>
                                <td><span class="badge bg-warning text-dark">10:15 AM</span></td>
                                <td>Dr. Alexander Vance</td>
                                <td><span class="badge bg-dark">Chair 1</span></td>
                                <td><span id="status-michael" class="badge bg-warning-subtle text-warning"><i class="bi bi-hourglass-split me-1"></i>Waiting Room</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-primary" id="btn-call-michael" onclick="callPatientToChair('michael', 'Michael Rodriguez', 'Chair 1')">
                                        <i class="bi bi-megaphone me-1"></i>Call to Chair
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark">David Sample</strong>
                                    <span class="text-muted small">+44 7700 900789</span>
                                </td>
                                <td><span class="text-muted">11:45 AM (Expected)</span></td>
                                <td>Dr. Elena Rostova</td>
                                <td><span class="badge bg-dark">Chair 2</span></td>
                                <td><span id="status-david" class="badge bg-secondary-subtle text-secondary">Scheduled</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary" id="btn-checkin-david" onclick="checkInPatient('david', 'David Sample')">
                                        <i class="bi bi-check-lg me-1"></i>Check-In
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-hospital text-teal me-2" style="color: #0D9488;"></i>Doctors On-Duty & Shifts</span>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">Dr. Alexander Vance</strong>
                            <span class="badge bg-danger-subtle text-danger">In Procedure</span>
                        </div>
                        <small class="text-muted d-block">Chair 1 (Surgical Unit) • Acocks Green Surgery</small>
                        <small class="text-secondary">Next availability: 11:30 AM</small>
                    </div>

                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">Dr. Elena Rostova</strong>
                            <span class="badge bg-success-subtle text-success">Available</span>
                        </div>
                        <small class="text-muted d-block">Chair 2 (General & Hygiene) • Ready for walk-in</small>
                        <small class="text-secondary">Open slot: 10:30 AM - 11:30 AM</small>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">Dr. Marcus Chen</strong>
                            <span class="badge bg-primary-subtle text-primary">Consultation</span>
                        </div>
                        <small class="text-muted d-block">Chair 3 (Orthodontics & Invisalign)</small>
                        <small class="text-secondary">Next availability: 11:00 AM</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Front Desk Quick Operations -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Front Desk Quick Actions</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-calendar-plus-fill fs-4 text-primary d-block mb-1"></i>
                                <strong class="d-block text-dark">Book Walk-In Appointment</strong>
                                <span class="text-muted small">Lock calendar slot & assign chair</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/patients') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-person-plus-fill fs-4 text-success d-block mb-1"></i>
                                <strong class="d-block text-dark">Patient Intake Form</strong>
                                <span class="text-muted small">Register new patient & NHS Band</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-calendar-week fs-4 text-info d-block mb-1"></i>
                                <strong class="d-block text-dark">Scheduler & Calendar</strong>
                                <span class="text-muted small">Roster view & doctor shifts</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/patients') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-search fs-4 text-warning d-block mb-1"></i>
                                <strong class="d-block text-dark">Patient Lookup</strong>
                                <span class="text-muted small">Find phone, MRN & appointments</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($userRole === 'billing'): ?>
    <!-- ======================================================================= -->
    <!-- 4. BILLING OFFICER DASHBOARD (INVOICES, POS, OUTSTANDING BALANCES)     -->
    <!-- ======================================================================= -->
    <!-- Row 1: Billing & Accounts KPIs (Consistent GBP £ Currency) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Daily Collections</span>
                    <div class="stat-value text-success">£14,850</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-check-circle me-1"></i> 28 Invoices Settled
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Outstanding Balances</span>
                    <div class="stat-value text-danger">£3,420</div>
                    <span class="badge bg-danger-subtle text-danger stat-meta">
                        <i class="bi bi-exclamation-octagon me-1"></i> 6 Partial Balances Due
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-danger">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Pending Insurance Claims</span>
                    <div class="stat-value">7 Claims</div>
                    <span class="badge bg-warning-subtle text-warning stat-meta">
                        <i class="bi bi-hourglass-split me-1"></i> Awaiting Bupa / AXA
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">POS Settlement Rate</span>
                    <div class="stat-value">98.4%</div>
                    <span class="badge bg-primary-subtle text-primary stat-meta">
                        <i class="bi bi-credit-card me-1"></i> Contactless & Chip
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-credit-card-2-front"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Recent Billing Invoices with In-Page Digital Preview Trigger -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-receipt-cutoff text-primary me-2"></i>Recent Patient Billing Invoices</span>
                    <a href="{{ url('/admin/billing') }}" class="btn btn-sm btn-outline-primary">Open Billing Workspace &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="min-width: 130px;">Invoice #</th>
                                <th class="text-nowrap" style="min-width: 160px;">Patient Name</th>
                                <th style="min-width: 220px;">Treatment & Codes</th>
                                <th class="text-nowrap" style="min-width: 120px;">Total Amount</th>
                                <th class="text-nowrap" style="min-width: 110px;">Status</th>
                                <th class="text-end pe-3 text-nowrap" style="min-width: 110px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>INV-2026-0891</code></td>
                                <td>
                                    <strong class="d-block text-dark">Sarah Jenkins</strong>
                                    <span class="text-muted small">MRN: #DF-99248</span>
                                </td>
                                <td>Pulpectomy & Molar Restoration (£1,650.00)</td>
                                <td><strong class="text-success">£1,650.00</strong></td>
                                <td><span class="badge bg-success">Paid in Full</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/billing') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Digital Invoice
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><code>INV-2026-0892</code></td>
                                <td>
                                    <strong class="d-block text-dark">Michael Rodriguez</strong>
                                    <span class="text-muted small">MRN: #DF-1043</span>
                                </td>
                                <td>All-on-4 Implant Retainer Deposit (£500.00)</td>
                                <td><strong class="text-primary">£500.00</strong></td>
                                <td><span class="badge bg-info-subtle text-info">Advance Deposit</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/billing') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Digital Invoice
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><code>INV-2026-0893</code></td>
                                <td>
                                    <strong class="d-block text-dark">David Sample</strong>
                                    <span class="text-muted small">MRN: #DF-1045</span>
                                </td>
                                <td>Crown Prep & Shade Selection (£680.00)</td>
                                <td><strong class="text-danger">£680.00</strong></td>
                                <td><span class="badge bg-warning-subtle text-warning">Pending Insurance</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ url('/admin/billing') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Digital Invoice
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-pie-chart-fill text-teal me-2" style="color: #0D9488;"></i>Payment Method Settlement Mix</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span>Card POS Terminal (Chip/Pin/ApplePay):</span>
                            <strong class="text-dark">£9,250 (62%)</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 62%;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span>Bank Transfer / BACS Direct:</span>
                            <strong class="text-dark">£3,400 (23%)</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 23%;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span>Cash Settlement:</span>
                            <strong class="text-dark">£1,200 (8%)</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 8%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span>0% APR Dental Finance Plan:</span>
                            <strong class="text-dark">£1,000 (7%)</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 7%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Billing Quick Actions -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Billing & Accounts Quick Actions</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/billing') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-receipt-cutoff fs-4 text-primary d-block mb-1"></i>
                                <strong class="d-block text-dark">Generate Tax Invoice</strong>
                                <span class="text-muted small">NHS Band & Private itemized bill</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/billing') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-credit-card-2-front-fill fs-4 text-success d-block mb-1"></i>
                                <strong class="d-block text-dark">POS Terminal Payment</strong>
                                <span class="text-muted small">Process card, cash, or advance deposit</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/inventory') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-cart-check-fill fs-4 text-info d-block mb-1"></i>
                                <strong class="d-block text-dark">Supplies Purchase Orders</strong>
                                <span class="text-muted small">Restorative materials procurement</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ url('/admin/billing') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-whatsapp fs-4 text-success d-block mb-1"></i>
                                <strong class="d-block text-dark">Send WhatsApp Receipt</strong>
                                <span class="text-muted small">Instant PDF dispatch to patient phone</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- ======================================================================= -->
    <!-- 5. SUPER ADMIN & CLINIC ADMIN DASHBOARD (EXECUTIVE OVERVIEW)            -->
    <!-- ======================================================================= -->
    <!-- Row 1: KPI Statistics Widgets (Synchronized Numbers & GBP £ Currency) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Today's Appointments</span>
                    <div class="stat-value">42</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-arrow-up-right me-1"></i> 14% vs yesterday
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Chair Occupancy Rate</span>
                    <div class="stat-value"><?= $occupancyPercentage ?>%</div>
                    <span class="badge bg-success-subtle text-success stat-meta">
                        <i class="bi bi-check-circle me-1"></i> <?= $totalActiveChairs ?> of <?= $totalCapacityChairs ?> chairs active
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-success">
                    <i class="bi bi-person-wheelchair"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Daily Billed Revenue</span>
                    <div class="stat-value text-success">£14,850</div>
                    <span class="badge bg-primary-subtle text-primary stat-meta">
                        <i class="bi bi-receipt me-1"></i> 28 Invoices Settled
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-card-content">
                    <span class="stat-label">Active Clinical Patients</span>
                    <div class="stat-value">3,420</div>
                    <span class="badge bg-info-subtle text-info stat-meta">
                        <i class="bi bi-shield-check me-1"></i> EMR Charts Synced
                    </span>
                </div>
                <div class="stat-icon-wrapper stat-icon-info">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Branch Comparison Matrix & Urgent Clinical Queue -->
    <div class="row g-4 mb-4">
        <!-- Branch Comparison Table (Synchronized with 14 Chairs & GBP £) -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-buildings-fill text-primary me-2"></i>Branch-Wise Operational Metrics</span>
                    <span class="badge bg-light text-dark border">Synchronized Live Feed</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" style="min-width: 180px;">Clinic Branch</th>
                                <th class="text-nowrap" style="min-width: 140px;">Doctor Shifts</th>
                                <th class="text-nowrap" style="min-width: 140px;">Active Chairs</th>
                                <th class="text-nowrap" style="min-width: 120px;">Today's Appts</th>
                                <th class="text-nowrap" style="min-width: 130px;">Revenue (MTD)</th>
                                <th class="text-nowrap" style="min-width: 100px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($branchData as $branch): ?>
                                <tr>
                                    <td>
                                        <strong class="d-block text-dark"><?= htmlspecialchars($branch['name']) ?></strong>
                                        <span class="text-muted small"><?= htmlspecialchars($branch['location']) ?></span>
                                    </td>
                                    <td><?= $branch['doctors_on_duty'] ?> Doctors On-Duty</td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 80px;">
                                            <div class="progress-bar bg-success" style="width: <?= round(($branch['active_chairs'] / $branch['total_chairs']) * 100) ?>%;"></div>
                                        </div>
                                        <span class="small text-muted"><?= $branch['active_chairs'] ?> / <?= $branch['total_chairs'] ?> Chairs</span>
                                    </td>
                                    <td><span class="badge bg-primary"><?= $branch['appts_today'] ?> Appts</span></td>
                                    <td><strong class="text-success"><?= $branch['revenue_mtd'] ?></strong></td>
                                    <td><span class="badge <?= $branch['status_class'] ?>"><?= $branch['status'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Clinic Totals (All Branches)</td>
                                <td>8 Clinicians</td>
                                <td><?= $totalActiveChairs ?> / <?= $totalCapacityChairs ?> Chairs Active (<?= $occupancyPercentage ?>%)</td>
                                <td>42 Appts</td>
                                <td class="text-success">£114,250</td>
                                <td><span class="badge bg-success">100% Operational</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Live Urgent Queue / Patient Flow -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-danger"><i class="bi bi-clock-history me-2"></i>Live Patient Triage Queue</span>
                    <span class="badge bg-danger">3 Urgent</span>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold text-danger">Sarah Jenkins (Pain: 8/10)</h6>
                            <small class="text-muted">10:00 AM</small>
                        </div>
                        <p class="mb-1 small text-dark">Suspected Acute Pulpitis (Tooth #19). Awaiting pulpectomy in Chair 1.</p>
                        <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Alexander Vance • Acocks Green HQ</small>
                    </div>

                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold text-primary">Michael Rodriguez</h6>
                            <small class="text-muted">10:30 AM</small>
                        </div>
                        <p class="mb-1 small text-dark">All-on-4 Guided Surgical Consultation & 3D CT Review.</p>
                        <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Vance • Acocks Green HQ</small>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold text-success">Emily Watson</h6>
                            <small class="text-muted">11:00 AM</small>
                        </div>
                        <p class="mb-1 small text-dark">Invisalign Tray Delivery & Attachment Bonding.</p>
                        <small class="text-muted"><i class="bi bi-person-fill"></i> Dr. Elena Rostova • Westside</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Inventory Alerts & Quick Operations -->
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-exclamation-octagon-fill text-warning me-2"></i>Critical Dental Stock Alerts</span>
                    <a href="{{ url('/admin/inventory') }}" class="btn btn-sm btn-link text-decoration-none">Manage Inventory &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item Code</th>
                                <th>Dental Supply</th>
                                <th>Current Stock</th>
                                <th>Reorder Threshold</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>IMP-4010</code></td>
                                <td>Straumann Titanium Implant Fixture 4.1mm</td>
                                <td><span class="badge bg-danger">3 units</span></td>
                                <td>10 units</td>
                                <td><button class="btn btn-xs btn-outline-primary btn-sm">Order Stock</button></td>
                            </tr>
                            <tr>
                                <td><code>LIDO-2P</code></td>
                                <td>Lidocaine 2% with Epinephrine 1:100k</td>
                                <td><span class="badge bg-warning text-dark">12 ampules</span></td>
                                <td>20 ampules</td>
                                <td><button class="btn btn-xs btn-outline-primary btn-sm">Transfer</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Executive Quick Operations</span>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-diagram-3-fill fs-4 text-primary d-block mb-1"></i>
                                <strong class="d-block text-dark">Odontogram EMR</strong>
                                <span class="text-muted small">Record 32-tooth surfaces</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/appointments/calendar') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-calendar-event-fill fs-4 text-success d-block mb-1"></i>
                                <strong class="d-block text-dark">Doctor Rostering</strong>
                                <span class="text-muted small">Drag-and-drop chair slots</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/patients') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-person-plus-fill fs-4 text-info d-block mb-1"></i>
                                <strong class="d-block text-dark">Patient Intake</strong>
                                <span class="text-muted small">Register walk-in patient</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/admin/billing') }}" class="btn btn-outline-secondary w-100 p-3 text-start">
                                <i class="bi bi-credit-card-2-front-fill fs-4 text-warning d-block mb-1"></i>
                                <strong class="d-block text-dark">POS Bill Settlement</strong>
                                <span class="text-muted small">Generate itemized receipts</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
/**
 * Receptionist Dashboard Interactive Patient Management Actions
 */
function callPatientToChair(id, name, chair) {
    const statusEl = document.getElementById('status-' + id);
    const btnEl = document.getElementById('btn-call-' + id);
    if (statusEl) {
        statusEl.className = 'badge bg-success-subtle text-success';
        statusEl.innerHTML = '<i class="bi bi-check2-circle me-1"></i>In Chair (' + chair + ')';
    }
    if (btnEl) {
        btnEl.className = 'btn btn-sm btn-outline-secondary';
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="bi bi-check-all me-1"></i>Called to Chair';
    }
}

function checkInPatient(id, name) {
    const statusEl = document.getElementById('status-' + id);
    const btnEl = document.getElementById('btn-checkin-' + id);
    if (statusEl) {
        statusEl.className = 'badge bg-warning-subtle text-warning';
        statusEl.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Waiting Room';
    }
    if (btnEl) {
        btnEl.className = 'btn btn-sm btn-primary';
        btnEl.innerHTML = '<i class="bi bi-megaphone me-1"></i>Call to Chair';
        btnEl.onclick = function() { callPatientToChair(id, name, 'Chair 2'); };
    }
}
</script>

@endsection
