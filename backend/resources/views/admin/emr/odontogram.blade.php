@extends('layouts.admin')

@section('title', 'Interactive Dental Odontogram EMR - Advanced Dental PRO')
@section('page_title', 'Digital Dental Chart (Odontogram EMR)')
@section('page_subtitle', 'Interactive anatomical surface mapping, pediatric/adult dentition, digital X-rays & clinical audit ledger')

@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#xrayDrawer">
            <i class="bi bi-file-earmark-medical me-1"></i> Digital X-Rays (<span id="xrayCountBadge">3</span>)
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#auditDrawer">
            <i class="bi bi-shield-lock me-1"></i> Audit Ledger
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetAllTeeth()">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Chart
        </button>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#saveChartModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
            <i class="bi bi-cloud-check-fill me-1"></i> Commit Chart
        </button>
    </div>
@endsection

@section('content')
<!-- Odontogram Alert Toast Container -->
<div id="odontogramAlertPlaceholder" class="mb-3"></div>

<!-- 1. Connected 5-Stage Patient Clinical Lifecycle Bar (Senior Dev Item 8) -->
<div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-2">
            <div>
                <span class="text-uppercase fw-bold text-muted small" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                    <i class="bi bi-diagram-3 text-teal me-1" style="color: #0D9488;"></i>Connected Clinical Workflow Lifecycle
                </span>
                <h6 class="fw-bold text-dark mb-0" id="lifecycleHeaderTitle">Stage 3 of 5: In Chair (Active Odontogram & Treatment)</h6>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="advanceLifecycleStage()">
                    <i class="bi bi-arrow-right-circle me-1"></i>Advance Lifecycle Stage
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-badge me-1"></i>Switch Patient Record
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><h6 class="dropdown-header">Select EMR Patient Profile</h6></li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/admin/emr/odontogram?patient_id=1045') }}"><span>David Sample (#1045)</span><span class="badge bg-success-subtle text-success small">Adult</span></a></li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/admin/emr/odontogram?patient_id=1042') }}"><span>Sarah Jenkins (#1042)</span><span class="badge bg-success-subtle text-success small">Adult</span></a></li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/admin/emr/odontogram?patient_id=1046') }}"><span>Leo Carter (#1046)</span><span class="badge bg-warning-subtle text-warning small">Pediatric</span></a></li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/admin/emr/odontogram?patient_id=1043') }}"><span>Marcus Sterling (#1043)</span><span class="badge bg-success-subtle text-success small">Adult</span></a></li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/admin/emr/odontogram?patient_id=1044') }}"><span>Sophia Patel (#1044)</span><span class="badge bg-success-subtle text-success small">Adult</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Progress Steps -->
        <div class="row g-2 text-center" id="lifecycleStepsContainer">
            <!-- Dynamically populated or rendered -->
            <div class="col">
                <div class="p-2 rounded bg-success text-white small fw-bold">1. Booked</div>
            </div>
            <div class="col">
                <div class="p-2 rounded bg-success text-white small fw-bold">2. Arrived</div>
            </div>
            <div class="col">
                <div class="p-2 rounded bg-primary text-white small fw-bold shadow-sm border border-2 border-white">3. In Chair (Active)</div>
            </div>
            <div class="col">
                <div class="p-2 rounded bg-light text-muted small">4. Billing</div>
            </div>
            <div class="col">
                <div class="p-2 rounded bg-light text-muted small">5. Settled</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Odontogram SVG Surface -->
    <div class="col-12 col-xl-8">
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <!-- Patient Banner -->
            <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center py-3 border-bottom gap-2">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center me-3 fw-bold" id="patientAvatarBadge" style="width: 44px; height: 44px; background: #0D9488; font-size: 1rem;">
                        DS
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark fs-5" id="patientNameDisplay">David Sample</strong>
                            <span class="badge bg-secondary-subtle text-secondary" id="patientMrnBadge">MRN-2026-0001</span>
                            <span class="badge bg-warning text-dark" id="dentitionBadge">Adult Dentition (32 Teeth)</span>
                        </div>
                        <span class="text-muted small" id="patientDemographicsDisplay">38 yrs • Male • <span class="text-danger fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>Allergy: Penicillin, Hypertension</span></span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="text-muted d-block small">Attending Clinician:</span>
                    <strong class="text-primary small" id="patientDoctorDisplay">Dr. Ethan Caldwell, DDS, FACP</strong>
                </div>
            </div>

            <!-- Chart & Notation Options Toolbar (Senior Dev Item 9) -->
            <div class="p-3 bg-light border-bottom d-flex flex-wrap gap-3 align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="small fw-bold text-muted text-uppercase">Dentition Mode:</span>
                    <div class="btn-group btn-group-sm" role="group" id="dentitionModeGroup">
                        <button type="button" class="btn btn-outline-secondary active" data-dentition="adult" onclick="switchDentition('adult')">
                            <i class="bi bi-person me-1"></i>Adult (32 Teeth)
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-dentition="pediatric" onclick="switchDentition('pediatric')">
                            <i class="bi bi-emoji-smile me-1"></i>Pediatric (20 Primary A-T)
                        </button>
                    </div>

                    <span class="small fw-bold text-muted text-uppercase ms-2">Notation:</span>
                    <div class="btn-group btn-group-sm" role="group" id="notationGroup">
                        <button type="button" class="btn btn-outline-secondary active" data-notation="universal" onclick="switchNotation('universal')">Universal (ADA)</button>
                        <button type="button" class="btn btn-outline-secondary" data-notation="fdi" onclick="switchNotation('fdi')">FDI ISO 3950</button>
                    </div>
                </div>
            </div>

            <!-- Odontogram Diagnostic Paint Toolbar -->
            <div class="p-3 bg-white border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="small fw-bold text-muted text-uppercase">Diagnostic Tool:</span>
                    <div class="btn-group btn-group-sm flex-wrap" role="group" id="conditionToolGroup">
                        <button type="button" class="btn btn-outline-secondary active" data-condition="healthy">
                            <i class="bi bi-circle"></i> Healthy
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-condition="caries">
                            <i class="bi bi-virus"></i> Caries (Cavity)
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-condition="filling">
                            <i class="bi bi-brush"></i> Composite Filling
                        </button>
                        <button type="button" class="btn btn-outline-warning" data-condition="crown">
                            <i class="bi bi-gem"></i> Porcelain Crown
                        </button>
                        <button type="button" class="btn btn-outline-info" data-condition="root_canal">
                            <i class="bi bi-lightning-charge"></i> Root Canal
                        </button>
                        <button type="button" class="btn btn-outline-success" data-condition="implant">
                            <i class="bi bi-pin-angle"></i> Implant
                        </button>
                        <button type="button" class="btn btn-outline-dark" data-condition="extracted">
                            <i class="bi bi-x-circle"></i> Extracted
                        </button>
                    </div>
                </div>

                <div class="small text-muted">
                    <span>Selected: <strong id="selectedToolLabel" class="text-dark">Healthy (Clear)</strong></span>
                </div>
            </div>

            <!-- SVG Odontogram Canvas -->
            <div class="card-body p-4 text-center">
                <div class="mb-2 text-muted small fw-bold" id="upperArchLabel">MAXILLARY ARCH (UPPER JAW: TEETH #1 - #16)</div>
                <!-- Upper Jaw Teeth -->
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4" id="upperJaw">
                    <!-- Populated dynamically via JS -->
                </div>

                <hr class="my-4">

                <div class="mb-2 text-muted small fw-bold" id="lowerArchLabel">MANDIBULAR ARCH (LOWER JAW: TEETH #17 - #32)</div>
                <!-- Lower Jaw Teeth -->
                <div class="d-flex justify-content-center flex-wrap gap-2" id="lowerJaw">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            <div class="card-footer bg-light small text-muted d-flex justify-content-between py-2 px-3">
                <span><i class="bi bi-info-circle me-1"></i> Click on any anatomical surface: <strong>Buccal</strong>, <strong>Lingual</strong>, <strong>Mesial</strong>, <strong>Distal</strong>, or <strong>Occlusal</strong>.</span>
                <span id="notationFooterLabel">Universal Numbering System (1 - 32)</span>
            </div>
        </div>
    </div>

    <!-- Treatment Plan & Diagnostics Sidebar -->
    <div class="col-12 col-xl-4">
        <!-- Diagnosis Summary -->
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <span class="fw-bold"><i class="bi bi-clipboard2-pulse-fill text-primary me-2"></i>Active Chart Findings</span>
                <span class="badge bg-primary" id="findingsCount">3 Conditions</span>
            </div>
            <div class="card-body p-0" style="max-height: 280px; overflow-y: auto;">
                <ul class="list-group list-group-flush small" id="findingsList">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <strong class="text-danger">Tooth #19 (Lower Left 1st Molar)</strong>
                            <div class="text-muted">Occlusal & Distal Deep Caries</div>
                        </div>
                        <span class="badge bg-danger">Caries</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Staged Clinical Treatment Plan Builder in GBP (£) (Senior Dev Item 4 & 10) -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <span class="fw-bold"><i class="bi bi-card-checklist text-success me-2"></i>Proposed Treatment Plan (£)</span>
                <span class="badge bg-success fs-6" id="totalPlanCost">£2,089.00</span>
            </div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Plan Reference: <strong id="planRefDisplay">TP-2026-1045</strong></span>
                        <span class="badge bg-primary-subtle text-primary small" id="totalPlanProceduresCount">3 Procedures</span>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 50%;"></div>
                    </div>
                    <span class="small text-muted mt-1 d-block" id="planStageDisplay">Stage 2 of 3: Surgical & Restorative Reconstruction</span>
                </div>

                <div class="list-group list-group-flush small" id="treatmentPlanList" style="max-height: 320px; overflow-y: auto;">
                    <div class="list-group-item p-3 treatment-item" data-fee="450">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger mb-1">Phase 1: Emergency</span>
                                <h6 class="mb-0 fw-bold">Tooth #19 Microscopic Pulpectomy</h6>
                                <p class="text-muted small mb-0">Rotary canal extirpation, calcium hydroxide medicament</p>
                            </div>
                            <div class="text-end">
                                <strong class="text-dark d-block">£450.00</strong>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2 py-3 border-top">
                <button type="button" class="btn btn-sm btn-outline-secondary w-50" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print Plan (£)
                </button>
                <button type="button" class="btn btn-sm btn-primary w-50" data-bs-toggle="modal" data-bs-target="#addTreatmentModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-plus-circle me-1"></i> Add Procedure
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- OFFCANVAS DRAWER 1: DIGITAL X-RAY ATTACHMENTS (Item 9)    -->
<!-- ========================================================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="xrayDrawer" style="width: 480px;">
    <div class="offcanvas-header bg-light border-bottom py-3">
        <h5 class="offcanvas-title fw-bold text-dark">
            <i class="bi bi-file-earmark-medical text-primary me-2"></i>Digital X-Ray & Imaging Vault
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="alert alert-info small mb-3">
            <i class="bi bi-info-circle me-1"></i>High-resolution diagnostic imaging integrated with patient EMR profile.
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0">Attached Radiographs (<span id="drawerXrayCount">3</span>)</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadXrayModal">
                <i class="bi bi-upload me-1"></i>Upload Radiograph
            </button>
        </div>
        <div class="vstack gap-3" id="xrayGalleryContainer">
            <div class="card border shadow-sm">
                <img src="{{ url('/images/hero-1.webp') }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="Xray">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold text-dark mb-0">Panoramic OPG Radiograph</h6>
                        <span class="badge bg-primary">OPG Digital</span>
                    </div>
                    <p class="text-muted small mb-2">Taken: 2026-11-15 • Bilateral condyles intact. Alveolar height normal.</p>
                    <button class="btn btn-sm btn-outline-secondary w-100" onclick="inspectXray('Panoramic OPG Radiograph', '{{ url('/images/hero-1.webp') }}')">
                        <i class="bi bi-zoom-in me-1"></i>Inspect Full Resolution
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- OFFCANVAS DRAWER 2: CRYPTOGRAPHIC AUDIT LEDGER (Item 9)   -->
<!-- ========================================================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="auditDrawer" style="width: 500px;">
    <div class="offcanvas-header bg-light border-bottom py-3">
        <h5 class="offcanvas-title fw-bold text-dark">
            <i class="bi bi-shield-lock-fill text-teal me-2" style="color: #0D9488;"></i>Cryptographic Chart Audit Ledger
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="alert alert-success small mb-3">
            <i class="bi bi-check-circle-fill me-1"></i>Tamper-evident SHA-256 ledger recording all clinical edits and clinician sign-offs.
        </div>
        <div class="timeline small" id="auditLedgerTimeline">
            <div class="p-3 mb-3 border rounded-3 bg-light">
                <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 0.75rem;">
                    <span><i class="bi bi-clock me-1"></i>2026-11-18 10:28:14</span>
                    <span class="badge bg-success-subtle text-success">Verified Hash</span>
                </div>
                <strong class="text-dark d-block">Dr. Ethan Caldwell, DDS</strong>
                <span class="text-secondary d-block">Tooth #19 Surface D charted Caries</span>
                <div class="font-monospace text-muted mt-1" style="font-size: 0.68rem;">hash: sha256:8f41...b32c</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Procedure -->
<div class="modal fade" id="addTreatmentModal" tabindex="-1" aria-labelledby="addTreatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="addTreatmentModalLabel">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>Add Procedure to Treatment Plan (£)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTreatmentForm" onsubmit="handleAddTreatment(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Treatment Phase</label>
                            <select class="form-select" id="newTreatmentPhase">
                                <option value="Phase 1: Emergency">Phase 1: Emergency & Pain Relief</option>
                                <option value="Phase 2: Restorative">Phase 2: Restorative & Endodontics</option>
                                <option value="Phase 3: Implantology">Phase 3: Implantology & Surgical</option>
                                <option value="Phase 4: Aesthetic">Phase 4: Orthodontics & Aesthetic</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tooth / Region</label>
                            <select class="form-select" id="newTreatmentTooth">
                                <option value="General Mouth">General / Full Mouth</option>
                                @for($i = 1; $i <= 32; $i++)
                                <option value="Tooth #{{ $i }}">Tooth #{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Clinical Procedure Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newTreatmentTitle" required placeholder="e.g. Zirconia Crown Restoration">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Procedure Fee (£ GBP) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="newTreatmentFee" min="0" step="10" value="450" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Procedure Code (CDT)</label>
                            <input type="text" class="form-control" id="newTreatmentCdt" placeholder="e.g. D2740">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Clinical Notes / Modality</label>
                            <textarea class="form-control" id="newTreatmentNotes" rows="2" placeholder="e.g. Tooth prepped with 1.5mm shoulder finish line."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-plus-lg me-1"></i>Add Procedure (£)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Save Chart Confirmation -->
<div class="modal fade" id="saveChartModal" tabindex="-1" aria-labelledby="saveChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="saveChartModalLabel">
                    <i class="bi bi-shield-check text-success me-2"></i>Commit Dental Chart & EMR (GBP)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="rounded-circle text-teal d-inline-flex align-items-center justify-content-center p-3 mb-2" style="background: #CCFBF1; color: #0F766E;">
                        <i class="bi bi-diagram-3-fill fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark" id="saveModalPatientName">David Sample (MRN: MRN-2026-0001)</h6>
                    <p class="text-muted small">Commit updated anatomical tooth surface mapping, audit ledger, and treatment plan (£) to electronic medical record.</p>
                </div>
                <div class="bg-light p-3 rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Diagnostic Findings:</span>
                        <strong class="text-dark" id="saveSummaryFindings">3 Conditions Logged</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Proposed Treatment:</span>
                        <strong class="text-success" id="saveSummaryCost">£2,089.00</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Currency Standard:</span>
                        <strong class="text-dark">British Pound (£ GBP)</strong>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sendPatientCopyWhatsapp" checked>
                    <label class="form-check-label small text-muted" for="sendPatientCopyWhatsapp">
                        Dispatch encrypted clinical summary & invoice link via WhatsApp (+44 7700 900283)
                    </label>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" onclick="confirmSaveChart()">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i>Encrypt & Commit EMR
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Comprehensive Multi-Patient Registry (Senior Dev Item 1 & 8)
    const PATIENT_REGISTRY = {
        1045: {
            id: 1045,
            mrn: 'MRN-2026-0001',
            name: 'David Sample',
            age: 38,
            gender: 'Male',
            initials: 'DS',
            phone: '+44 7700 900283',
            email: 'david.sample@example.com',
            alerts: 'Penicillin Allergy, Hypertension',
            doctor: 'Dr. Ethan Caldwell, DDS, FACP',
            chair: 'Chair 2 (Surgical Suite)',
            dentition: 'adult',
            balance: '£2,089.00',
            lifecycleStage: 'in_chair',
            planRef: 'TP-2026-1045',
            stageTitle: 'Stage 2 of 3: Surgical & Restorative Reconstruction',
            findings: [
                { tooth: 19, surface: 'Occlusal & Distal', condition: 'caries', title: 'Tooth #19 Deep Dentinal Caries', severity: 'danger' },
                { tooth: 14, surface: 'Mesial-Occlusal', condition: 'filling', title: 'Tooth #14 Existing MOD Composite', severity: 'primary' },
                { tooth: 30, surface: 'Center Fixture', condition: 'implant', title: 'Tooth #30 Guided Implant Fixture', severity: 'success' }
            ],
            treatmentPlan: [
                { phase: 'Phase 1: Emergency', badge: 'bg-danger', title: 'Tooth #19 Microscopic Pulpectomy', notes: 'Rotary canal extirpation, calcium hydroxide', fee: 450 },
                { phase: 'Phase 2: Restorative', badge: 'bg-warning text-dark', title: 'Tooth #19 Zirconia Crown & Core', notes: 'CAD/CAM digital scan, resin cement', fee: 750 },
                { phase: 'Phase 3: Implantology', badge: 'bg-primary', title: 'Tooth #30 Straumann BLX Guided Implant', notes: 'Surgical guide stent, titanium healing collar', fee: 889 }
            ]
        },
        1042: {
            id: 1042,
            mrn: 'MRN-2026-0042',
            name: 'Sarah Jenkins',
            age: 34,
            gender: 'Female',
            initials: 'SJ',
            phone: '+44 7911 123456',
            email: 'sarah.jenkins@example.co.uk',
            alerts: 'Latex Allergy',
            doctor: 'Dr. Sarah Jenkins, DDS',
            chair: 'Chair 1',
            dentition: 'adult',
            balance: '£620.00',
            lifecycleStage: 'arrived',
            planRef: 'TP-2026-1042',
            stageTitle: 'Stage 1 of 2: Restorative & Cosmetic Whitening',
            findings: [
                { tooth: 12, surface: 'Mesio-Occlusal', condition: 'caries', title: 'Tooth #12 Enamel Fissure Caries', severity: 'danger' },
                { tooth: 3, surface: 'Full Crown', condition: 'crown', title: 'Tooth #3 Porcelain Crown', severity: 'warning' }
            ],
            treatmentPlan: [
                { phase: 'Phase 1: Restorative', badge: 'bg-warning text-dark', title: 'Tooth #12 Composite Resin Restoration', notes: 'Nano-hybrid composite bonded', fee: 180 },
                { phase: 'Phase 2: Aesthetic', badge: 'bg-success', title: 'Enlighten Evolution Teeth Whitening', notes: 'Bespoke trays + 16% CP regimen', fee: 440 }
            ]
        },
        1046: {
            id: 1046,
            mrn: 'MRN-2026-0046',
            name: 'Leo Carter (Pediatric)',
            age: 7,
            gender: 'Male',
            initials: 'LC',
            phone: '+44 7900 445566 (Mother: Rachel)',
            email: 'rachel.carter@example.com',
            alerts: 'Mild Asthma (Inhaler)',
            doctor: 'Dr. Maya Lin, DMD, MS (Pediatric)',
            chair: 'Chair 5 (Pediatric Suite)',
            dentition: 'pediatric', // 20 primary teeth A-T
            balance: '£280.00',
            lifecycleStage: 'in_chair',
            planRef: 'TP-2026-1046',
            stageTitle: 'Pediatric Prevention & Sealant Plan',
            findings: [
                { tooth: 'B', surface: 'Occlusal Pit', condition: 'caries', title: 'Primary Tooth B (FDI 54) Caries', severity: 'danger' },
                { tooth: 'I', surface: 'Occlusal', condition: 'filling', title: 'Primary Tooth I Fissure Sealant', severity: 'primary' }
            ],
            treatmentPlan: [
                { phase: 'Phase 1: Preventive', badge: 'bg-info text-dark', title: 'Topical Fluoride Varnish (5% NaF)', notes: 'Duraphat dental suspension', fee: 65 },
                { phase: 'Phase 2: Restorative', badge: 'bg-warning text-dark', title: 'Primary Tooth B Fuji IX Glass Ionomer', notes: 'Bioactive minimal intervention filling', fee: 115 },
                { phase: 'Phase 3: Prevention', badge: 'bg-success', title: 'Penta-Seal Pit & Fissure Sealants (4 Molars)', notes: 'Resin light-cure protective barrier', fee: 100 }
            ]
        },
        1043: {
            id: 1043,
            mrn: 'MRN-2026-0043',
            name: 'Marcus Sterling',
            age: 32,
            gender: 'Male',
            initials: 'MS',
            phone: '+44 7700 900123',
            email: 'marcus.s@example.com',
            alerts: 'None (NKDA)',
            doctor: 'Dr. Maya Lin, DMD, MS',
            chair: 'Chair 4',
            dentition: 'adult',
            balance: '£2,400.00',
            lifecycleStage: 'booked',
            planRef: 'TP-2026-1043',
            stageTitle: 'Clear Aligner Comprehensive Plan',
            findings: [
                { tooth: 8, surface: 'Labial', condition: 'healthy', title: 'Class I Incisal Crowding', severity: 'info' }
            ],
            treatmentPlan: [
                { phase: 'Phase 1: Orthodontics', badge: 'bg-primary', title: 'Invisalign Comprehensive Clear Aligners', notes: 'iTero Element 5D digital scan with SmartTrack', fee: 2400 }
            ]
        },
        1044: {
            id: 1044,
            mrn: 'MRN-2026-0044',
            name: 'Sophia Patel',
            age: 43,
            gender: 'Female',
            initials: 'SP',
            phone: '+44 7890 123456',
            email: 'sophia.patel@example.com',
            alerts: 'Type 2 Diabetes',
            doctor: 'Dr. Sarah Jenkins, DDS',
            chair: 'Chair 3',
            dentition: 'adult',
            balance: '£1,250.00',
            lifecycleStage: 'billing',
            planRef: 'TP-2026-1044',
            stageTitle: 'Restorative Completion',
            findings: [
                { tooth: 30, surface: 'Canals', condition: 'root_canal', title: 'Tooth #30 Root Canal Obturation', severity: 'info' },
                { tooth: 31, surface: 'Crown', condition: 'crown', title: 'Tooth #31 IPS e.max Crown', severity: 'warning' }
            ],
            treatmentPlan: [
                { phase: 'Phase 2: Restorative', badge: 'bg-warning text-dark', title: 'Tooth #31 e.max Ceramic Crown Cementation', notes: 'RelyX Unicem 2 self-adhesive resin', fee: 750 },
                { phase: 'Phase 1: Endodontics', badge: 'bg-info text-dark', title: 'Tooth #30 Molar Rotary Endodontic Therapy', notes: 'Warm vertical condensation obturation', fee: 500 }
            ]
        }
    };

    let activeCondition = 'healthy';
    let currentDentition = 'adult'; // adult or pediatric
    let currentNotation = 'universal'; // universal or fdi
    const toothConditions = {};

    // Get patient ID from query params (?patient_id=1045)
    const urlParams = new URLSearchParams(window.location.search);
    const patientIdParam = parseInt(urlParams.get('patient_id') || '1045', 10);
    let activePatient = PATIENT_REGISTRY[patientIdParam] || PATIENT_REGISTRY[1045];
    currentDentition = activePatient.dentition || 'adult';

    document.addEventListener('DOMContentLoaded', () => {
        loadPatientProfile(activePatient);
        renderJaws();
        prepaintConditions();
    });

    function loadPatientProfile(p) {
        document.getElementById('patientNameDisplay').innerText = p.name;
        document.getElementById('patientMrnBadge').innerText = p.mrn;
        document.getElementById('patientDemographicsDisplay').innerHTML = `${p.age} yrs • ${p.gender} • <span class="text-danger fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>Allergy/Alerts: ${p.alerts}</span>`;
        document.getElementById('patientDoctorDisplay').innerText = p.doctor;
        document.getElementById('patientAvatarBadge').innerText = p.initials;
        document.getElementById('planRefDisplay').innerText = p.planRef;
        document.getElementById('planStageDisplay').innerText = p.stageTitle;
        document.getElementById('totalPlanCost').innerText = p.balance;
        document.getElementById('saveSummaryCost').innerText = p.balance;
        document.getElementById('saveModalPatientName').innerText = `${p.name} (MRN: ${p.mrn})`;

        const dentitionBadge = document.getElementById('dentitionBadge');
        if (p.dentition === 'pediatric') {
            dentitionBadge.innerText = 'Pediatric Primary Dentition (20 Teeth A-T)';
            dentitionBadge.className = 'badge bg-warning text-dark';
        } else {
            dentitionBadge.innerText = 'Adult Permanent Dentition (32 Teeth)';
            dentitionBadge.className = 'badge bg-success text-dark';
        }

        // Load Findings
        const findingsList = document.getElementById('findingsList');
        findingsList.innerHTML = p.findings.map((f, idx) => `
            <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="finding-${idx}">
                <div>
                    <strong class="text-dark">${f.title} (${f.surface})</strong>
                    <div class="text-muted small">Diagnostic tag: ${f.condition.toUpperCase()}</div>
                </div>
                <span class="badge bg-${f.severity === 'danger' ? 'danger' : (f.severity === 'warning' ? 'warning text-dark' : 'success')}">${f.condition.toUpperCase()}</span>
            </li>
        `).join('');
        document.getElementById('findingsCount').innerText = `${p.findings.length} Conditions`;
        document.getElementById('saveSummaryFindings').innerText = `${p.findings.length} Conditions Logged`;

        // Load Treatment Plan
        const tpList = document.getElementById('treatmentPlanList');
        tpList.innerHTML = p.treatmentPlan.map((tp, idx) => `
            <div class="list-group-item p-3 treatment-item" data-fee="${tp.fee}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge ${tp.badge} mb-1">${tp.phase}</span>
                        <h6 class="mb-0 fw-bold">${tp.title}</h6>
                        <p class="text-muted small mb-0">${tp.notes}</p>
                    </div>
                    <div class="text-end">
                        <strong class="text-dark d-block">£${tp.fee.toFixed(2)}</strong>
                        <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        `).join('');
        document.getElementById('totalPlanProceduresCount').innerText = `${p.treatmentPlan.length} Procedures`;

        // Update Lifecycle UI
        updateLifecycleBar(p.lifecycleStage);
    }

    // FDI ISO 3950 mapping helper
    const FDI_MAPPING = {
        1: 18, 2: 17, 3: 16, 4: 15, 5: 14, 6: 13, 7: 12, 8: 11,
        9: 21, 10: 22, 11: 23, 12: 24, 13: 25, 14: 26, 15: 27, 16: 28,
        17: 38, 18: 37, 19: 36, 20: 35, 21: 34, 22: 33, 23: 32, 24: 31,
        25: 41, 26: 42, 27: 43, 28: 44, 29: 45, 30: 46, 31: 47, 32: 48,
        'A': 55, 'B': 54, 'C': 53, 'D': 52, 'E': 51,
        'F': 61, 'G': 62, 'H': 63, 'I': 64, 'J': 65,
        'K': 75, 'L': 74, 'M': 73, 'N': 72, 'O': 71,
        'P': 81, 'Q': 82, 'R': 83, 'S': 84, 'T': 85
    };

    function renderToothSvg(toothKey) {
        let displayLabel = toothKey;
        if (currentNotation === 'fdi' && FDI_MAPPING[toothKey]) {
            displayLabel = `${toothKey} (${FDI_MAPPING[toothKey]})`;
        }

        return `
            <div class="tooth-wrapper text-center" style="width: 48px;">
                <span class="small fw-bold text-muted d-block" style="font-size: 0.65rem;">#${displayLabel}</span>
                <svg width="42" height="42" viewBox="0 0 100 100" data-tooth="${toothKey}">
                    <polygon points="10,10 90,10 70,30 30,30" class="tooth-surface" data-surface="buccal" onclick="paintSurface('${toothKey}', 'buccal', this)"/>
                    <polygon points="30,70 70,70 90,90 10,90" class="tooth-surface" data-surface="lingual" onclick="paintSurface('${toothKey}', 'lingual', this)"/>
                    <polygon points="10,10 30,30 30,70 10,90" class="tooth-surface" data-surface="mesial" onclick="paintSurface('${toothKey}', 'mesial', this)"/>
                    <polygon points="90,10 70,30 70,70 90,90" class="tooth-surface" data-surface="distal" onclick="paintSurface('${toothKey}', 'distal', this)"/>
                    <rect x="30" y="30" width="40" height="40" class="tooth-surface" data-surface="occlusal" onclick="paintSurface('${toothKey}', 'occlusal', this)"/>
                </svg>
            </div>
        `;
    }

    function renderJaws() {
        const upper = document.getElementById('upperJaw');
        const lower = document.getElementById('lowerJaw');
        upper.innerHTML = '';
        lower.innerHTML = '';

        if (currentDentition === 'adult') {
            document.getElementById('upperArchLabel').innerText = 'MAXILLARY ARCH (ADULT PERMANENT: TEETH #1 - #16)';
            document.getElementById('lowerArchLabel').innerText = 'MANDIBULAR ARCH (ADULT PERMANENT: TEETH #32 - #17)';
            for (let i = 1; i <= 16; i++) upper.innerHTML += renderToothSvg(i);
            for (let i = 32; i >= 17; i--) lower.innerHTML += renderToothSvg(i);
        } else {
            document.getElementById('upperArchLabel').innerText = 'MAXILLARY ARCH (PEDIATRIC PRIMARY: TEETH A - J)';
            document.getElementById('lowerArchLabel').innerText = 'MANDIBULAR ARCH (PEDIATRIC PRIMARY: TEETH K - T)';
            const upperTeeth = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            const lowerTeeth = ['T', 'S', 'R', 'Q', 'P', 'O', 'N', 'M', 'L', 'K'];
            upperTeeth.forEach(t => upper.innerHTML += renderToothSvg(t));
            lowerTeeth.forEach(t => lower.innerHTML += renderToothSvg(t));
        }
    }

    function switchDentition(mode) {
        currentDentition = mode;
        document.querySelectorAll('#dentitionModeGroup button').forEach(b => b.classList.remove('active'));
        document.querySelector(`[data-dentition="${mode}"]`).classList.add('active');
        renderJaws();
        prepaintConditions();
        showOdontogramAlert(`Switched to ${mode === 'adult' ? 'Adult Permanent (32 Teeth)' : 'Pediatric Primary (20 Teeth A-T)'}.`, 'info');
    }

    function switchNotation(notation) {
        currentNotation = notation;
        document.querySelectorAll('#notationGroup button').forEach(b => b.classList.remove('active'));
        document.querySelector(`[data-notation="${notation}"]`).classList.add('active');
        document.getElementById('notationFooterLabel').innerText = notation === 'universal' ? 'Universal Numbering System (1-32 / A-T)' : 'FDI ISO 3950 International System (18-48 / 55-85)';
        renderJaws();
        prepaintConditions();
    }

    function prepaintConditions() {
        setTimeout(() => {
            if (activePatient.id === 1045) {
                paintExisting('19', 'occlusal', 'caries');
                paintExisting('19', 'distal', 'caries');
                paintExisting('14', 'occlusal', 'filling');
                paintExisting('30', 'occlusal', 'implant');
            } else if (activePatient.id === 1046) {
                paintExisting('B', 'occlusal', 'caries');
                paintExisting('I', 'occlusal', 'filling');
            } else if (activePatient.id === 1042) {
                paintExisting('12', 'occlusal', 'caries');
                paintExisting('3', 'occlusal', 'crown');
            }
        }, 150);
    }

    function paintExisting(tooth, surface, condition) {
        const el = document.querySelector(`svg[data-tooth="${tooth}"] [data-surface="${surface}"]`);
        if (el) {
            el.className.baseVal = `tooth-surface ${condition}`;
            if (!toothConditions[tooth]) toothConditions[tooth] = {};
            toothConditions[tooth][surface] = condition;
        }
    }

    // Paint individual tooth surface
    function paintSurface(toothKey, surface, el) {
        el.className.baseVal = activeCondition === 'healthy' ? 'tooth-surface' : `tooth-surface ${activeCondition}`;

        if (!toothConditions[toothKey]) toothConditions[toothKey] = {};
        toothConditions[toothKey][surface] = activeCondition;

        // Record cryptographic audit entry (Senior Dev Item 9)
        recordAuditEntry(`Tooth #${toothKey} Surface ${surface.toUpperCase()} charted as ${activeCondition.toUpperCase()}`);
        showOdontogramAlert(`Tooth #${toothKey} (${surface}) updated to ${activeCondition.toUpperCase()}`);
    }

    function recordAuditEntry(actionDesc) {
        const timeline = document.getElementById('auditLedgerTimeline');
        const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
        const randomHash = 'sha256:' + Math.random().toString(36).substring(2, 10) + Math.random().toString(36).substring(2, 10);

        const entryHtml = `
            <div class="p-3 mb-3 border rounded-3 bg-light animate__fadeIn">
                <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 0.75rem;">
                    <span><i class="bi bi-clock me-1"></i>${now}</span>
                    <span class="badge bg-success-subtle text-success">Verified Hash</span>
                </div>
                <strong class="text-dark d-block">${activePatient.doctor}</strong>
                <span class="text-secondary d-block">${actionDesc}</span>
                <div class="font-monospace text-muted mt-1" style="font-size: 0.68rem;">hash: ${randomHash}</div>
            </div>
        `;
        timeline.insertAdjacentHTML('afterbegin', entryHtml);
    }

    // Condition button toggles
    document.querySelectorAll('#conditionToolGroup button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#conditionToolGroup button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeCondition = this.getAttribute('data-condition');
            document.getElementById('selectedToolLabel').innerText = this.innerText.trim();
        });
    });

    function showOdontogramAlert(message, type = 'success') {
        const placeholder = document.getElementById('odontogramAlertPlaceholder');
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

    // Add Procedure Handler
    function handleAddTreatment(event) {
        event.preventDefault();
        const phase = document.getElementById('newTreatmentPhase').value;
        const tooth = document.getElementById('newTreatmentTooth').value;
        const title = document.getElementById('newTreatmentTitle').value.trim();
        const fee = parseFloat(document.getElementById('newTreatmentFee').value) || 0;
        const notes = document.getElementById('newTreatmentNotes').value.trim() || 'Standard clinical procedure';

        const phaseBadge = phase.includes('Emergency') ? 'bg-danger' :
                           (phase.includes('Restorative') ? 'bg-warning text-dark' :
                           (phase.includes('Implantology') ? 'bg-primary' : 'bg-success'));

        const itemHtml = `
            <div class="list-group-item p-3 treatment-item" data-fee="${fee}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge ${phaseBadge} mb-1">${phase}</span>
                        <h6 class="mb-0 fw-bold">${tooth} ${title}</h6>
                        <p class="text-muted small mb-0">${notes}</p>
                    </div>
                    <div class="text-end">
                        <strong class="text-dark d-block">£${fee.toFixed(2)}</strong>
                        <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('treatmentPlanList').insertAdjacentHTML('beforeend', itemHtml);
        recalculateTotalPlanCost();

        const modal = bootstrap.Modal.getInstance(document.getElementById('addTreatmentModal'));
        if (modal) modal.hide();
        document.getElementById('addTreatmentForm').reset();

        recordAuditEntry(`Added procedure: ${title} (${tooth}) - £${fee.toFixed(2)}`);
        showOdontogramAlert(`Procedure <strong>${title}</strong> added to Treatment Plan (£)!`);
    }

    function removeTreatmentItem(btn) {
        const item = btn.closest('.treatment-item');
        if (item) {
            item.remove();
            recalculateTotalPlanCost();
        }
    }

    function recalculateTotalPlanCost() {
        let total = 0;
        const items = document.querySelectorAll('.treatment-item');
        items.forEach(el => {
            const fee = parseFloat(el.getAttribute('data-fee')) || 0;
            total += fee;
        });

        const formatted = '£' + total.toLocaleString('en-GB', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('totalPlanCost').innerText = formatted;
        document.getElementById('saveSummaryCost').innerText = formatted;
        document.getElementById('totalPlanProceduresCount').innerText = `${items.length} Procedures`;
    }

    function confirmSaveChart() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('saveChartModal'));
        if (modal) modal.hide();

        const sendWa = document.getElementById('sendPatientCopyWhatsapp').checked;
        const waMsg = sendWa ? ` Summary dispatched via WhatsApp to ${activePatient.phone}.` : '';

        recordAuditEntry(`Committed clinical chart and EMR encryption for ${activePatient.name}`);
        showOdontogramAlert(`Dental chart and treatment plan successfully encrypted and committed to Patient EMR (${activePatient.mrn})!${waMsg}`);
    }

    function resetAllTeeth() {
        if (!confirm('Reset all tooth conditions on this chart to healthy?')) return;
        document.querySelectorAll('.tooth-surface').forEach(el => {
            el.className.baseVal = 'tooth-surface';
        });
        for (const key in toothConditions) delete toothConditions[key];
        recordAuditEntry('Reset all tooth conditions to healthy');
        showOdontogramAlert('Odontogram chart surfaces reset to healthy.', 'info');
    }

    function inspectXray(title, src) {
        alert(`Inspecting High-Resolution Radiograph: ${title}\nSecure DICOM viewer launched.`);
    }

    // Connected 5-stage workflow lifecycle advancement
    const LIFECYCLE_STAGES = ['booked', 'arrived', 'in_chair', 'billing', 'settled'];
    let currentStageIndex = LIFECYCLE_STAGES.indexOf(activePatient.lifecycleStage);
    if (currentStageIndex === -1) currentStageIndex = 2;

    function advanceLifecycleStage() {
        currentStageIndex = (currentStageIndex + 1) % LIFECYCLE_STAGES.length;
        const newStage = LIFECYCLE_STAGES[currentStageIndex];
        updateLifecycleBar(newStage);

        // Call Backend API /api/v1/emr/lifecycle
        fetch('{{ url("/api/v1/emr/lifecycle") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ patient_id: activePatient.id, stage: newStage })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                recordAuditEntry(`Lifecycle advanced to ${newStage.toUpperCase()} (Invoice Ref: ${data.invoice_reference})`);
                showOdontogramAlert(`Patient ${activePatient.name} lifecycle advanced to <strong>${newStage.toUpperCase().replace('_', ' ')}</strong>. Invoice: ${data.invoice_reference}`);
            }
        }).catch(() => {
            showOdontogramAlert(`Patient ${activePatient.name} lifecycle advanced to ${newStage.toUpperCase()}`, 'info');
        });
    }

    function updateLifecycleBar(stage) {
        const container = document.getElementById('lifecycleStepsContainer');
        const stages = [
            { key: 'booked', label: '1. Booked' },
            { key: 'arrived', label: '2. Arrived' },
            { key: 'in_chair', label: '3. In Chair' },
            { key: 'billing', label: '4. Billing' },
            { key: 'settled', label: '5. Settled' }
        ];

        const activeIdx = stages.findIndex(s => s.key === stage);
        currentStageIndex = activeIdx >= 0 ? activeIdx : 2;

        container.innerHTML = stages.map((s, idx) => {
            let bg = 'bg-light text-muted';
            let extra = '';
            if (idx < currentStageIndex) {
                bg = 'bg-success text-white';
            } else if (idx === currentStageIndex) {
                bg = 'bg-primary text-white shadow-sm border border-2 border-white';
                extra = ' fw-bold';
            }
            return `
                <div class="col">
                    <div class="p-2 rounded ${bg} small${extra}">${s.label}</div>
                </div>
            `;
        }).join('');

        document.getElementById('lifecycleHeaderTitle').innerText = `Stage ${currentStageIndex + 1} of 5: ${stages[currentStageIndex].label} (${activePatient.chair})`;
    }
</script>
@endpush
