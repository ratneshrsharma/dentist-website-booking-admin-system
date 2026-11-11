@extends('layouts.admin')

@section('title', 'Patient Records (EHR) - Advanced Dental PRO')
@section('page_title', 'Patient Records (EHR)')
@section('page_subtitle', 'Comprehensive electronic health records, medical alerts, and dental charting history')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 bg-teal-subtle text-teal p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Active Patients</span>
                    <h3 class="fw-bold mb-0 text-dark">1,428</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">+48 this month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 bg-danger-subtle text-danger p-3 me-3" style="background-color: #FEE2E2; color: #DC2626;">
                    <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Medical Alert Tags</span>
                    <h3 class="fw-bold mb-0 text-dark">184</h3>
                    <span class="text-muted small mt-1">Allergies & Systemic</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 bg-warning-subtle text-warning p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-bell-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Recalls Due (6-Mo)</span>
                    <h3 class="fw-bold mb-0 text-dark">92</h3>
                    <span class="text-muted small mt-1">Prophylaxis follow-up</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 bg-primary-subtle text-primary p-3 me-3" style="background-color: #E0E7FF; color: #4338CA;">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">HIPAA Verified</span>
                    <h3 class="fw-bold mb-0 text-dark">100%</h3>
                    <span class="text-muted small mt-1">Signed consent forms</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Patient Records Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Electronic Health Records Directory</h5>
            <span class="text-muted small">Search, filter, and review clinical dental records & charts</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 280px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search by name, MRN, phone...">
            </div>
            <button class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-person-plus-fill me-1"></i>New Patient Intake
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">MRN / ID</th>
                        <th>Patient Name</th>
                        <th>Age / Gender</th>
                        <th>Primary Contact</th>
                        <th>Medical Alerts</th>
                        <th>Assigned Doctor</th>
                        <th>Last Treatment</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-3"><span class="fw-bold text-teal" style="color: #0D9488;">MRN-2026-0001</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center me-2 fw-semibold" style="width: 34px; height: 34px; background: #0D9488; font-size: 0.8rem;">
                                    DS
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">David Sample</span>
                                    <small class="text-muted">Registered: 14 Jan 2026</small>
                                </div>
                            </div>
                        </td>
                        <td>38 yrs / Male</td>
                        <td>
                            <span class="d-block small text-dark"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-2830</span>
                            <small class="text-muted"><i class="bi bi-envelope me-1 text-muted"></i>patient@example.com</small>
                        </td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1"><i class="bi bi-exclamation-circle me-1"></i>Penicillin Allergy</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle d-block">Hypertension</span>
                        </td>
                        <td><span class="fw-semibold text-dark">Dr. Ethan Caldwell</span></td>
                        <td>
                            <span class="d-block small text-dark">Guided Implant #19</span>
                            <small class="text-muted">3 days ago</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">Active In-Treatment</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="ps-3"><span class="fw-bold text-teal" style="color: #0D9488;">MRN-2026-0042</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-indigo text-white d-flex align-items-center justify-content-center me-2 fw-semibold" style="width: 34px; height: 34px; background: #6366F1; font-size: 0.8rem;">
                                    EJ
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Emma Jenkins</span>
                                    <small class="text-muted">Registered: 28 Feb 2026</small>
                                </div>
                            </div>
                        </td>
                        <td>29 yrs / Female</td>
                        <td>
                            <span class="d-block small text-dark"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-8472</span>
                            <small class="text-muted"><i class="bi bi-envelope me-1 text-muted"></i>emma.j@example.com</small>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>
                        </td>
                        <td><span class="fw-semibold text-dark">Dr. Maya Lin</span></td>
                        <td>
                            <span class="d-block small text-dark">Invisalign Tray 8 Fitting</span>
                            <small class="text-muted">Yesterday</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">Active In-Treatment</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="ps-3"><span class="fw-bold text-teal" style="color: #0D9488;">MRN-2026-0098</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 fw-semibold" style="width: 34px; height: 34px; background: #0284C7; font-size: 0.8rem;">
                                    MB
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Michael Brown</span>
                                    <small class="text-muted">Registered: 05 Mar 2026</small>
                                </div>
                            </div>
                        </td>
                        <td>52 yrs / Male</td>
                        <td>
                            <span class="d-block small text-dark"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-3310</span>
                            <small class="text-muted"><i class="bi bi-envelope me-1 text-muted"></i>mbrown@example.com</small>
                        </td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1"><i class="bi bi-exclamation-circle me-1"></i>Latex Allergy</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle d-block">Type 2 Diabetes</span>
                        </td>
                        <td><span class="fw-semibold text-dark">Dr. Marcus Vance</span></td>
                        <td>
                            <span class="d-block small text-dark">Endodontic RCT #30</span>
                            <small class="text-muted">12 Mar 2026</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning">Follow-Up Required</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="ps-3"><span class="fw-bold text-teal" style="color: #0D9488;">MRN-2026-0112</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-pink text-white d-flex align-items-center justify-content-center me-2 fw-semibold" style="width: 34px; height: 34px; background: #EC4899; font-size: 0.8rem;">
                                    ST
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">Sophia Turner</span>
                                    <small class="text-muted">Registered: 18 Mar 2026</small>
                                </div>
                            </div>
                        </td>
                        <td>9 yrs / Female</td>
                        <td>
                            <span class="d-block small text-dark"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-9941</span>
                            <small class="text-muted"><i class="bi bi-envelope me-1 text-muted"></i>turner.family@example.com</small>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>
                        </td>
                        <td><span class="fw-semibold text-dark">Dr. Olivia Harper</span></td>
                        <td>
                            <span class="d-block small text-dark">Pediatric Fluoride & Sealants</span>
                            <small class="text-muted">19 Mar 2026</small>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary">Routine Recall Due</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing 1 to 4 of 1,428 patient clinical records</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--app-primary); border-color: var(--app-primary);">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>
@endsection
