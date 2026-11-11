@extends('layouts.admin')

@section('title', 'Patient Records (EHR) - Advanced Dental PRO')
@section('page_title', 'Patient Records (EHR)')
@section('page_subtitle', 'Comprehensive electronic health records, medical alerts, and dental charting history')

@section('page_actions')
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#newPatientModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
    <i class="bi bi-person-plus-fill me-1"></i> New Patient Intake
</button>
@endsection

@section('content')
<!-- Feedback Alert Toast -->
<div id="patientAlertPlaceholder" class="mb-3"></div>

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
                    <h3 class="fw-bold mb-0 text-dark" id="statPatientCount">1,428</h3>
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
            <div class="input-group input-group-sm" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="patientSearchInput" onkeyup="filterPatientsTable()" placeholder="Search by name, MRN, phone, allergy...">
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newPatientModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-person-plus-fill me-1"></i>New Intake
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="patientsTable">
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
                <tbody id="patientsTableBody">
                    <!-- Patient 1 -->
                    <tr id="patient-row-1" data-mrn="MRN-2026-0001" data-name="David Sample" data-age="38" data-gender="Male" data-phone="+1 (555) 019-2830" data-email="patient@example.com" data-alerts="Penicillin Allergy, Hypertension" data-doctor="Dr. Ethan Caldwell" data-treatment="Guided Implant #19" data-status="Active In-Treatment">
                        <td class="ps-3"><span class="fw-bold text-teal patient-mrn" style="color: #0D9488;">MRN-2026-0001</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center me-2 fw-semibold patient-avatar" style="width: 34px; height: 34px; background: #0D9488; font-size: 0.8rem;">
                                    DS
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block patient-name">David Sample</span>
                                    <small class="text-muted">Registered: 14 Jan 2026</small>
                                </div>
                            </div>
                        </td>
                        <td class="patient-age-gender">38 yrs / Male</td>
                        <td>
                            <span class="d-block small text-dark patient-phone"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-2830</span>
                            <small class="text-muted patient-email"><i class="bi bi-envelope me-1 text-muted"></i>patient@example.com</small>
                        </td>
                        <td class="patient-alerts-cell">
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1"><i class="bi bi-exclamation-circle me-1"></i>Penicillin Allergy</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle d-block">Hypertension</span>
                        </td>
                        <td><span class="fw-semibold text-dark patient-doctor">Dr. Ethan Caldwell</span></td>
                        <td>
                            <span class="d-block small text-dark patient-treatment">Guided Implant #19</span>
                            <small class="text-muted">3 days ago</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success patient-status-badge">Active In-Treatment</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openViewEhrModal('patient-row-1')" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditPatientModal('patient-row-1')" title="Edit Record">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="openDeletePatientModal('patient-row-1')" title="Archive Patient">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Patient 2 -->
                    <tr id="patient-row-2" data-mrn="MRN-2026-0042" data-name="Emma Jenkins" data-age="29" data-gender="Female" data-phone="+1 (555) 019-8472" data-email="emma.j@example.com" data-alerts="None" data-doctor="Dr. Maya Lin" data-treatment="Invisalign Tray 8 Fitting" data-status="Active In-Treatment">
                        <td class="ps-3"><span class="fw-bold text-teal patient-mrn" style="color: #0D9488;">MRN-2026-0042</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-indigo text-white d-flex align-items-center justify-content-center me-2 fw-semibold patient-avatar" style="width: 34px; height: 34px; background: #6366F1; font-size: 0.8rem;">
                                    EJ
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block patient-name">Emma Jenkins</span>
                                    <small class="text-muted">Registered: 28 Feb 2026</small>
                                </div>
                            </div>
                        </td>
                        <td class="patient-age-gender">29 yrs / Female</td>
                        <td>
                            <span class="d-block small text-dark patient-phone"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-8472</span>
                            <small class="text-muted patient-email"><i class="bi bi-envelope me-1 text-muted"></i>emma.j@example.com</small>
                        </td>
                        <td class="patient-alerts-cell">
                            <span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>
                        </td>
                        <td><span class="fw-semibold text-dark patient-doctor">Dr. Maya Lin</span></td>
                        <td>
                            <span class="d-block small text-dark patient-treatment">Invisalign Tray 8 Fitting</span>
                            <small class="text-muted">Yesterday</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success patient-status-badge">Active In-Treatment</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openViewEhrModal('patient-row-2')" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditPatientModal('patient-row-2')" title="Edit Record">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="openDeletePatientModal('patient-row-2')" title="Archive Patient">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Patient 3 -->
                    <tr id="patient-row-3" data-mrn="MRN-2026-0098" data-name="Michael Brown" data-age="52" data-gender="Male" data-phone="+1 (555) 019-3310" data-email="mbrown@example.com" data-alerts="Latex Allergy, Type 2 Diabetes" data-doctor="Dr. Marcus Vance" data-treatment="Endodontic RCT #30" data-status="Follow-Up Required">
                        <td class="ps-3"><span class="fw-bold text-teal patient-mrn" style="color: #0D9488;">MRN-2026-0098</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 fw-semibold patient-avatar" style="width: 34px; height: 34px; background: #0284C7; font-size: 0.8rem;">
                                    MB
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block patient-name">Michael Brown</span>
                                    <small class="text-muted">Registered: 05 Mar 2026</small>
                                </div>
                            </div>
                        </td>
                        <td class="patient-age-gender">52 yrs / Male</td>
                        <td>
                            <span class="d-block small text-dark patient-phone"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-3310</span>
                            <small class="text-muted patient-email"><i class="bi bi-envelope me-1 text-muted"></i>mbrown@example.com</small>
                        </td>
                        <td class="patient-alerts-cell">
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1"><i class="bi bi-exclamation-circle me-1"></i>Latex Allergy</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle d-block">Type 2 Diabetes</span>
                        </td>
                        <td><span class="fw-semibold text-dark patient-doctor">Dr. Marcus Vance</span></td>
                        <td>
                            <span class="d-block small text-dark patient-treatment">Endodontic RCT #30</span>
                            <small class="text-muted">12 Mar 2026</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning patient-status-badge">Follow-Up Required</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openViewEhrModal('patient-row-3')" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditPatientModal('patient-row-3')" title="Edit Record">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="openDeletePatientModal('patient-row-3')" title="Archive Patient">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Patient 4 -->
                    <tr id="patient-row-4" data-mrn="MRN-2026-0112" data-name="Sophia Turner" data-age="9" data-gender="Female" data-phone="+1 (555) 019-9941" data-email="turner.family@example.com" data-alerts="None" data-doctor="Dr. Olivia Harper" data-treatment="Pediatric Fluoride & Sealants" data-status="Routine Recall Due">
                        <td class="ps-3"><span class="fw-bold text-teal patient-mrn" style="color: #0D9488;">MRN-2026-0112</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2 fw-semibold patient-avatar" style="width: 34px; height: 34px; background: #EC4899; font-size: 0.8rem;">
                                    ST
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block patient-name">Sophia Turner</span>
                                    <small class="text-muted">Registered: 18 Mar 2026</small>
                                </div>
                            </div>
                        </td>
                        <td class="patient-age-gender">9 yrs / Female</td>
                        <td>
                            <span class="d-block small text-dark patient-phone"><i class="bi bi-telephone me-1 text-muted"></i>+1 (555) 019-9941</span>
                            <small class="text-muted patient-email"><i class="bi bi-envelope me-1 text-muted"></i>turner.family@example.com</small>
                        </td>
                        <td class="patient-alerts-cell">
                            <span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>
                        </td>
                        <td><span class="fw-semibold text-dark patient-doctor">Dr. Olivia Harper</span></td>
                        <td>
                            <span class="d-block small text-dark patient-treatment">Pediatric Fluoride & Sealants</span>
                            <small class="text-muted">19 Mar 2026</small>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary patient-status-badge">Routine Recall Due</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                                    <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openViewEhrModal('patient-row-4')" title="View Full EHR">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditPatientModal('patient-row-4')" title="Edit Record">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="openDeletePatientModal('patient-row-4')" title="Archive Patient">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between align-items-center">
        <span class="text-muted small" id="patientShowingLabel">Showing 4 of 1,428 patient clinical records</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--app-primary); border-color: var(--app-primary);">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>

<!-- Modal 1: New Patient Intake -->
<div class="modal fade" id="newPatientModal" tabindex="-1" aria-labelledby="newPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="newPatientModalLabel">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i>New Patient Clinical Intake
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newPatientForm" onsubmit="handleNewPatient(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newPatientName" required placeholder="e.g. Eleanor Vance">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Age <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="newPatientAge" min="1" max="115" value="32" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Gender</label>
                            <select class="form-select" id="newPatientGender">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Primary Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="newPatientPhone" required placeholder="+1 (555) 019-7712">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" class="form-control" id="newPatientEmail" placeholder="patient.email@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Assigned Doctor</label>
                            <select class="form-select" id="newPatientDoctor">
                                <option value="Dr. Ethan Caldwell">Dr. Ethan Caldwell (Prosthodontics)</option>
                                <option value="Dr. Maya Lin">Dr. Maya Lin (Orthodontics)</option>
                                <option value="Dr. Marcus Vance">Dr. Marcus Vance (Endodontics & Surgery)</option>
                                <option value="Dr. Olivia Harper">Dr. Olivia Harper (Pediatric & Prevention)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Medical & Allergy Alerts</label>
                            <select class="form-select" id="newPatientAlerts">
                                <option value="None">No Medical Alerts</option>
                                <option value="Penicillin Allergy">Penicillin Allergy</option>
                                <option value="Latex Allergy">Latex Allergy</option>
                                <option value="Hypertension">Hypertension</option>
                                <option value="Type 2 Diabetes">Type 2 Diabetes</option>
                                <option value="Penicillin Allergy, Hypertension">Penicillin Allergy + Hypertension</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Chief Complaint / Initial Treatment</label>
                            <input type="text" class="form-control" id="newPatientTreatment" placeholder="e.g. Comprehensive Dental Exam & Full-Mouth Radiographs">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-check2-circle me-1"></i>Register Patient Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: View Full EHR -->
<div class="modal fade" id="viewEhrModal" tabindex="-1" aria-labelledby="viewEhrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="modal-title fw-bold text-dark mb-0" id="viewEhrModalLabel">
                        <i class="bi bi-file-earmark-medical-fill text-teal me-1" style="color: #0D9488;"></i>Electronic Health Record
                    </h5>
                    <span class="badge bg-secondary-subtle text-secondary" id="viewEhrMrnBadge">MRN-2026-0001</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Patient Header Banner -->
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 fw-bold fs-5" id="viewEhrAvatar" style="width: 48px; height: 48px; background: #0D9488;">
                            DS
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark" id="viewEhrName">David Sample</h5>
                            <span class="text-muted small" id="viewEhrDemographics">38 yrs • Male • Active Patient</span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                            <i class="bi bi-diagram-3-fill me-1"></i>Open Odontogram Chart
                        </a>
                    </div>
                </div>

                <!-- Vitals & Alerts -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border border-danger-subtle bg-danger-subtle bg-opacity-10 p-3 rounded-3">
                            <span class="fw-bold text-danger small d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Clinical Medical Alerts</span>
                            <div id="viewEhrAlertsContainer">
                                <span class="badge bg-danger">Penicillin Allergy</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border p-3 rounded-3 bg-white">
                            <span class="fw-bold text-dark small d-block mb-1"><i class="bi bi-telephone me-1 text-primary"></i>Primary Contact</span>
                            <span class="d-block small text-dark" id="viewEhrPhone">+1 (555) 019-2830</span>
                            <small class="text-muted" id="viewEhrEmail">patient@example.com</small>
                        </div>
                    </div>
                </div>

                <!-- Treatment History Timeline -->
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clock-history me-1 text-muted"></i>Recent Clinical Procedures</h6>
                <div class="list-group list-group-flush border rounded-3 small mb-3">
                    <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-dark d-block" id="viewEhrLatestTreatment">Guided Implant #19</strong>
                            <span class="text-muted">Attending Clinician: <span id="viewEhrDoctor">Dr. Ethan Caldwell</span></span>
                        </div>
                        <span class="badge bg-success-subtle text-success">Completed</span>
                    </div>
                    <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-dark d-block">Pre-Surgical CBCT 3D Scan & Bone Density Analysis</strong>
                            <span class="text-muted">Radiology Suite • Metro Dental HQ</span>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary">Archived</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Edit Patient Record -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="editPatientModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Patient Health Record
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPatientForm" onsubmit="handleEditPatient(event)">
                <input type="hidden" id="editPatientRowId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editPatientName" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Age</label>
                            <input type="number" class="form-control" id="editPatientAge" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Gender</label>
                            <select class="form-select" id="editPatientGender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Phone Number</label>
                            <input type="tel" class="form-control" id="editPatientPhone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" class="form-control" id="editPatientEmail" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Assigned Clinician</label>
                            <input type="text" class="form-control" id="editPatientDoctor" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Clinical Status</label>
                            <select class="form-select" id="editPatientStatus">
                                <option value="Active In-Treatment">Active In-Treatment</option>
                                <option value="Follow-Up Required">Follow-Up Required</option>
                                <option value="Routine Recall Due">Routine Recall Due</option>
                                <option value="Treatment Plan Pending">Treatment Plan Pending</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Medical & Allergy Warnings</label>
                            <input type="text" class="form-control" id="editPatientAlerts" placeholder="e.g. Penicillin Allergy, Hypertension">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-save me-1"></i>Save Patient Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 4: Archive / Delete Patient -->
<div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold" id="deletePatientModalLabel">
                    <i class="bi bi-archive-fill me-2"></i>Archive Patient Health Record
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <input type="hidden" id="deletePatientRowId">
                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center p-3 mb-3">
                    <i class="bi bi-person-x fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" id="deletePatientNameDisplay">David Sample</h5>
                <p class="text-muted small mb-0">
                    Are you sure you want to archive this patient record? Clinical charting history will be preserved under HIPAA record retention protocols.
                </p>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4 justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletePatient()">
                    <i class="bi bi-archive me-1"></i>Confirm Archive
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showPatientAlert(message, type = 'success') {
        const placeholder = document.getElementById('patientAlertPlaceholder');
        placeholder.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        setTimeout(() => {
            const alert = placeholder.querySelector('.alert');
            if (alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }
        }, 4000);
    }

    // 1. Live Filter / Search
    function filterPatientsTable() {
        const query = document.getElementById('patientSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#patientsTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('patientShowingLabel').innerText = `Showing ${visibleCount} matching patient records`;
    }

    // 2. New Patient Intake Handler
    function handleNewPatient(event) {
        event.preventDefault();
        const name = document.getElementById('newPatientName').value.trim();
        const age = document.getElementById('newPatientAge').value;
        const gender = document.getElementById('newPatientGender').value;
        const phone = document.getElementById('newPatientPhone').value.trim();
        const email = document.getElementById('newPatientEmail').value.trim() || 'unspecified@example.com';
        const doctor = document.getElementById('newPatientDoctor').value;
        const alerts = document.getElementById('newPatientAlerts').value;
        const treatment = document.getElementById('newPatientTreatment').value.trim() || 'New Patient Comprehensive Exam';

        const randMrn = 'MRN-2026-' + String(Math.floor(Math.random() * 9000) + 1000);
        const rowId = 'patient-row-' + Date.now();
        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

        let alertBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>';
        if (alerts !== 'None') {
            alertBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1"><i class="bi bi-exclamation-circle me-1"></i>${alerts}</span>`;
        }

        const newRowHtml = `
            <tr id="${rowId}" data-mrn="${randMrn}" data-name="${name}" data-age="${age}" data-gender="${gender}" data-phone="${phone}" data-email="${email}" data-alerts="${alerts}" data-doctor="${doctor}" data-treatment="${treatment}" data-status="Active In-Treatment">
                <td class="ps-3"><span class="fw-bold text-teal patient-mrn" style="color: #0D9488;">${randMrn}</span></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2 fw-semibold patient-avatar" style="width: 34px; height: 34px; background: #0D9488; font-size: 0.8rem;">
                            ${initials}
                        </div>
                        <div>
                            <span class="fw-bold text-dark d-block patient-name">${name}</span>
                            <small class="text-muted">Registered: Today (New)</small>
                        </div>
                    </div>
                </td>
                <td class="patient-age-gender">${age} yrs / ${gender}</td>
                <td>
                    <span class="d-block small text-dark patient-phone"><i class="bi bi-telephone me-1 text-muted"></i>${phone}</span>
                    <small class="text-muted patient-email"><i class="bi bi-envelope me-1 text-muted"></i>${email}</small>
                </td>
                <td class="patient-alerts-cell">${alertBadge}</td>
                <td><span class="fw-semibold text-dark patient-doctor">${doctor}</span></td>
                <td>
                    <span class="d-block small text-dark patient-treatment">${treatment}</span>
                    <small class="text-muted">Registered today</small>
                </td>
                <td><span class="badge bg-success-subtle text-success patient-status-badge">Active In-Treatment</span></td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ url('/admin/emr/odontogram') }}" class="btn btn-outline-secondary" title="Open Odontogram Chart">
                            <i class="bi bi-diagram-3-fill text-teal" style="color: #0D9488;"></i>
                        </a>
                        <button type="button" class="btn btn-outline-secondary" onclick="openViewEhrModal('${rowId}')" title="View Full EHR">
                            <i class="bi bi-file-earmark-medical"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="openEditPatientModal('${rowId}')" title="Edit Record">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="openDeletePatientModal('${rowId}')" title="Archive Patient">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('patientsTableBody').insertAdjacentHTML('afterbegin', newRowHtml);

        const modal = bootstrap.Modal.getInstance(document.getElementById('newPatientModal'));
        if (modal) modal.hide();
        document.getElementById('newPatientForm').reset();

        showPatientAlert(`Patient <strong>${name}</strong> (${randMrn}) registered successfully!`);
    }

    // 3. View Full EHR Modal
    function openViewEhrModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        const mrn = row.getAttribute('data-mrn');
        const name = row.getAttribute('data-name');
        const age = row.getAttribute('data-age');
        const gender = row.getAttribute('data-gender');
        const phone = row.getAttribute('data-phone');
        const email = row.getAttribute('data-email');
        const alerts = row.getAttribute('data-alerts');
        const doctor = row.getAttribute('data-doctor');
        const treatment = row.getAttribute('data-treatment');

        document.getElementById('viewEhrMrnBadge').innerText = mrn;
        document.getElementById('viewEhrName').innerText = name;
        document.getElementById('viewEhrDemographics').innerText = `${age} yrs • ${gender} • Active Patient`;
        document.getElementById('viewEhrPhone').innerText = phone;
        document.getElementById('viewEhrEmail').innerText = email;
        document.getElementById('viewEhrDoctor').innerText = doctor;
        document.getElementById('viewEhrLatestTreatment').innerText = treatment;

        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        document.getElementById('viewEhrAvatar').innerText = initials;

        const alertsContainer = document.getElementById('viewEhrAlertsContainer');
        if (alerts === 'None' || !alerts) {
            alertsContainer.innerHTML = '<span class="badge bg-success">No Known Drug Allergies (NKDA)</span>';
        } else {
            alertsContainer.innerHTML = alerts.split(',').map(a => `<span class="badge bg-danger me-1 mb-1">${a.trim()}</span>`).join('');
        }

        const modal = new bootstrap.Modal(document.getElementById('viewEhrModal'));
        modal.show();
    }

    // 4. Edit Patient Modal
    function openEditPatientModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('editPatientRowId').value = rowId;
        document.getElementById('editPatientName').value = row.getAttribute('data-name');
        document.getElementById('editPatientAge').value = row.getAttribute('data-age');
        document.getElementById('editPatientGender').value = row.getAttribute('data-gender');
        document.getElementById('editPatientPhone').value = row.getAttribute('data-phone');
        document.getElementById('editPatientEmail').value = row.getAttribute('data-email');
        document.getElementById('editPatientDoctor').value = row.getAttribute('data-doctor');
        document.getElementById('editPatientAlerts').value = row.getAttribute('data-alerts');
        document.getElementById('editPatientStatus').value = row.getAttribute('data-status');

        const modal = new bootstrap.Modal(document.getElementById('editPatientModal'));
        modal.show();
    }

    function handleEditPatient(event) {
        event.preventDefault();
        const rowId = document.getElementById('editPatientRowId').value;
        const row = document.getElementById(rowId);
        if (!row) return;

        const name = document.getElementById('editPatientName').value.trim();
        const age = document.getElementById('editPatientAge').value;
        const gender = document.getElementById('editPatientGender').value;
        const phone = document.getElementById('editPatientPhone').value.trim();
        const email = document.getElementById('editPatientEmail').value.trim();
        const doctor = document.getElementById('editPatientDoctor').value.trim();
        const alerts = document.getElementById('editPatientAlerts').value.trim();
        const status = document.getElementById('editPatientStatus').value;

        // Update dataset
        row.setAttribute('data-name', name);
        row.setAttribute('data-age', age);
        row.setAttribute('data-gender', gender);
        row.setAttribute('data-phone', phone);
        row.setAttribute('data-email', email);
        row.setAttribute('data-doctor', doctor);
        row.setAttribute('data-alerts', alerts);
        row.setAttribute('data-status', status);

        // Update DOM
        row.querySelector('.patient-name').innerText = name;
        row.querySelector('.patient-age-gender').innerText = `${age} yrs / ${gender}`;
        row.querySelector('.patient-phone').innerHTML = `<i class="bi bi-telephone me-1 text-muted"></i>${phone}`;
        row.querySelector('.patient-email').innerHTML = `<i class="bi bi-envelope me-1 text-muted"></i>${email}`;
        row.querySelector('.patient-doctor').innerText = doctor;
        row.querySelector('.patient-status-badge').innerText = status;

        const alertsCell = row.querySelector('.patient-alerts-cell');
        if (alerts === 'None' || !alerts) {
            alertsCell.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle">No Medical Alerts</span>';
        } else {
            alertsCell.innerHTML = alerts.split(',').map(a => `<span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>${a.trim()}</span>`).join('');
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('editPatientModal'));
        if (modal) modal.hide();

        showPatientAlert(`Patient record for <strong>${name}</strong> successfully updated!`);
    }

    // 5. Delete Patient Modal
    function openDeletePatientModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('deletePatientRowId').value = rowId;
        document.getElementById('deletePatientNameDisplay').innerText = row.getAttribute('data-name');

        const modal = new bootstrap.Modal(document.getElementById('deletePatientModal'));
        modal.show();
    }

    function confirmDeletePatient() {
        const rowId = document.getElementById('deletePatientRowId').value;
        const row = document.getElementById(rowId);
        const name = row ? row.getAttribute('data-name') : 'Patient';

        if (row) {
            row.remove();
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('deletePatientModal'));
        if (modal) modal.hide();

        showPatientAlert(`Patient record for <strong>${name}</strong> has been safely archived.`, 'warning');
    }
</script>
@endpush
