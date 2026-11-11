@extends('layouts.admin')

@section('title', 'Staff Directory & RBAC Security Roles - Advanced Dental PRO')
@section('page_title', 'Staff RBAC & Security Roles')
@section('page_subtitle', 'Role-based access control, cryptographic permissions, 2FA credentials, and clinical audit ledger')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Authorized Staff</span>
                    <h3 class="fw-bold mb-0 text-dark">28 Members</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">All accounts active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #E0E7FF; color: #4338CA;">
                    <i class="bi bi-shield-lock-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Configured Roles</span>
                    <h3 class="fw-bold mb-0 text-dark">6 Levels</h3>
                    <span class="text-muted small mt-1">Granular RBAC Matrix</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #DCFCE7; color: #15803D;">
                    <i class="bi bi-phone-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">2FA Enforced</span>
                    <h3 class="fw-bold mb-0 text-dark">100% Active</h3>
                    <span class="text-muted small mt-1">TOTP / Hardware Keys</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Active Sessions</span>
                    <h3 class="fw-bold mb-0 text-dark">7 Online</h3>
                    <span class="text-muted small mt-1">TLS 1.3 / Zero Leaks</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RBAC Permission Matrix Card -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-check text-teal me-2" style="color: #0D9488;"></i>Role-Based Access Control (RBAC) Permission Matrix</h5>
        <span class="text-muted small">Strict data barrier preventing non-clinical staff from accessing medical EMR charts and protecting financial ledgers</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 text-center text-sm">
                <thead class="table-light">
                    <tr>
                        <th class="text-start ps-3" style="min-width: 220px;">Module / Clinical Domain</th>
                        <th>👑 Super Admin</th>
                        <th>🏥 Clinic Admin</th>
                        <th>🩺 Doctor (EMR)</th>
                        <th>📅 Appt. Manager</th>
                        <th>🌐 Website Mgr</th>
                        <th>💳 Billing Officer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Practice Dashboard</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-primary-subtle text-primary">Doctor KPIs</span></td>
                        <td><span class="badge bg-info-subtle text-info">Appt KPIs</span></td>
                        <td><span class="badge bg-secondary-subtle text-secondary">CMS KPIs</span></td>
                        <td><span class="badge bg-warning-subtle text-warning">Finance KPIs</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Scheduler & Calendar</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Own + Branch</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-light text-muted border">View Only</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Odontogram EMR</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full Clinical</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Patient Records (EHR)</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full Clinical</span></td>
                        <td><span class="badge bg-info-subtle text-info">Basic Intake Only</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-light text-muted border">Billing Profile Only</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Multi-Clinic Manager</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> All Branches</span></td>
                        <td><span class="badge bg-primary-subtle text-primary">Own Branch Only</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Dental Supplies & Stock</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-light text-dark border">View Materials</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Purchase Orders</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Billing, Invoices & POS</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full POS & Claims</span></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3 fw-semibold">Theme & SEO Customizer</td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> Full CMS & SEO</span></td>
                        <td><span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-lg"></i> 403 Forbidden</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Staff Users Directory Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Staff Users & Role Assignments</h5>
            <span class="text-muted small">Manage clinician accounts, staff credentials, and role privileges</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-person-plus-fill me-1"></i>Provision New Staff Account
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Staff Name</th>
                        <th>Email Address</th>
                        <th>Assigned Role</th>
                        <th>Assigned Facility</th>
                        <th>2FA Status</th>
                        <th>Last Active</th>
                        <th>Account Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- User 1 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                    DA
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Demo Administrator</span>
                                    <small class="text-muted">Master System Super-Admin</small>
                                </div>
                            </div>
                        </td>
                        <td>admin@example.com</td>
                        <td><span class="badge bg-warning-subtle text-warning border"><i class="bi bi-crown-fill me-1"></i>Super Administrator</span></td>
                        <td>All Branches</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-teal fw-semibold" style="color: #0D9488;">Online Now</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>

                    <!-- User 2 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                    SM
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Sarah Miller</span>
                                    <small class="text-muted">Practice General Manager</small>
                                </div>
                            </div>
                        </td>
                        <td>clinic.admin@example.com</td>
                        <td><span class="badge bg-primary-subtle text-primary border"><i class="bi bi-hospital me-1"></i>Clinic Administrator</span></td>
                        <td>Metro Dental Central</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-muted">2 hours ago</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>

                    <!-- User 3 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; background: #0D9488; font-size: 0.8rem;">
                                    EC
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Dr. Ethan Caldwell, DDS</span>
                                    <small class="text-muted">Prosthodontics Specialist</small>
                                </div>
                            </div>
                        </td>
                        <td>dr.caldwell@example.com</td>
                        <td><span class="badge bg-teal-subtle text-teal border" style="background: #CCFBF1; color: #0F766E;"><i class="bi bi-heart-pulse me-1"></i>Doctor (EMR)</span></td>
                        <td>Metro Dental Central</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-muted">15 mins ago</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>

                    <!-- User 4 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                    EW
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Emily Watson</span>
                                    <small class="text-muted">Lead Patient Coordinator</small>
                                </div>
                            </div>
                        </td>
                        <td>reception@example.com</td>
                        <td><span class="badge bg-info-subtle text-info border"><i class="bi bi-calendar-check me-1"></i>Appointment Manager</span></td>
                        <td>Metro Dental Central</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-muted">1 hour ago</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>

                    <!-- User 5 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                    WM
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Alex Rivera</span>
                                    <small class="text-muted">Lead Digital Webmaster</small>
                                </div>
                            </div>
                        </td>
                        <td>webmaster@example.com</td>
                        <td><span class="badge bg-success-subtle text-success border"><i class="bi bi-globe me-1"></i>Website Manager</span></td>
                        <td>Digital Marketing</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-muted">Yesterday</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>

                    <!-- User 6 -->
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                    RF
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Robert Fox</span>
                                    <small class="text-muted">Accounts & Insurance Billing</small>
                                </div>
                            </div>
                        </td>
                        <td>billing@example.com</td>
                        <td><span class="badge bg-secondary-subtle text-secondary border"><i class="bi bi-receipt me-1"></i>Billing Officer</span></td>
                        <td>Finance Department</td>
                        <td><span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Enforced</span></td>
                        <td><span class="small text-muted">3 hours ago</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-key"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
