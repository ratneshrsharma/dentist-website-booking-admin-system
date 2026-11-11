@extends('layouts.admin')

@section('title', 'Interactive Dental Odontogram EMR - Advanced Dental Clinic')
@section('page_title', 'Digital Dental Chart (Odontogram EMR)')
@section('page_subtitle', 'Interactive 32-adult tooth anatomical surface mapping & staged treatment planning')

@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetAllTeeth()">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Chart
        </button>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#saveChartModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
            <i class="bi bi-cloud-check-fill me-1"></i> Save Clinical Chart
        </button>
    </div>
@endsection

@section('content')
<!-- Odontogram Alert Toast Container -->
<div id="odontogramAlertPlaceholder" class="mb-3"></div>

<div class="row g-4">
    <!-- Main Odontogram SVG Surface -->
    <div class="col-12 col-xl-8">
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <!-- Patient Banner -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <div>
                    <span class="text-muted small">Patient EMR:</span>
                    <strong class="text-dark ms-1">Sarah Jenkins</strong>
                    <span class="badge bg-secondary-subtle text-secondary ms-2">MRN: #DF-99248</span>
                    <span class="badge bg-danger-subtle text-danger ms-1"><i class="bi bi-exclamation-circle me-1"></i>Allergy: Penicillin</span>
                </div>
                <div>
                    <span class="text-muted small">Attending:</span>
                    <strong class="text-primary ms-1">Dr. Alexander Vance (Prosthodontist)</strong>
                </div>
            </div>

            <!-- Odontogram Chart Toolbar -->
            <div class="p-3 bg-light border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between">
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

            <div class="card-body p-4 text-center">
                <div class="mb-2 text-muted small fw-bold">MAXILLARY ARCH (UPPER JAW: TEETH #1 - #16)</div>
                <!-- Upper Jaw Teeth 1 - 16 -->
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4" id="upperJaw">
                    <!-- Populated dynamically via SVG tooth component -->
                </div>

                <hr class="my-4">

                <div class="mb-2 text-muted small fw-bold">MANDIBULAR ARCH (LOWER JAW: TEETH #17 - #32)</div>
                <!-- Lower Jaw Teeth 32 - 17 -->
                <div class="d-flex justify-content-center flex-wrap gap-2" id="lowerJaw">
                    <!-- Populated dynamically via SVG tooth component -->
                </div>
            </div>

            <div class="card-footer bg-light small text-muted d-flex justify-content-between py-2 px-3">
                <span><i class="bi bi-info-circle me-1"></i> Click on any anatomical surface: <strong>B</strong> (Buccal), <strong>L</strong> (Lingual), <strong>M</strong> (Mesial), <strong>D</strong> (Distal), or <strong>O</strong> (Occlusal).</span>
                <span>Universal Numbering System (1 - 32)</span>
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
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="finding-19">
                        <div>
                            <strong class="text-danger">Tooth #19 (Lower Left 1st Molar)</strong>
                            <div class="text-muted">Occlusal & Distal Deep Caries</div>
                        </div>
                        <span class="badge bg-danger">Caries</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="finding-14">
                        <div>
                            <strong class="text-primary">Tooth #14 (Upper Left 1st Molar)</strong>
                            <div class="text-muted">Existing MOD Composite Restoration</div>
                        </div>
                        <span class="badge bg-primary">Filled</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="finding-30">
                        <div>
                            <strong class="text-success">Tooth #30 (Lower Right 1st Molar)</strong>
                            <div class="text-muted">Missing tooth planned for Guided Implant</div>
                        </div>
                        <span class="badge bg-success">Implant</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Staged Clinical Treatment Plan Builder -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <span class="fw-bold"><i class="bi bi-card-checklist text-success me-2"></i>Proposed Treatment Plan</span>
                <span class="badge bg-success fs-6" id="totalPlanCost">$2,589.00</span>
            </div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Plan Reference: <strong>#TP-2026-0881</strong></span>
                        <span class="badge bg-primary-subtle text-primary small" id="totalPlanProceduresCount">3 Procedures</span>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 33%;"></div>
                    </div>
                    <span class="small text-muted mt-1 d-block">Stage 1 of 3: Emergency Infection Control</span>
                </div>

                <div class="list-group list-group-flush small" id="treatmentPlanList" style="max-height: 320px; overflow-y: auto;">
                    <div class="list-group-item p-3 treatment-item" data-fee="650">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger mb-1">Phase 1: Emergency</span>
                                <h6 class="mb-0 fw-bold">Tooth #19 Microscopic Pulpectomy</h6>
                                <p class="text-muted small mb-0">Rotary canal extirpation, calcium hydroxide medicament</p>
                            </div>
                            <div class="text-end">
                                <strong class="text-dark d-block">$650.00</strong>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item p-3 treatment-item" data-fee="850">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-warning text-dark mb-1">Phase 2: Restorative</span>
                                <h6 class="mb-0 fw-bold">Tooth #19 E-Max Core & Ceramic Crown</h6>
                                <p class="text-muted small mb-0">CAD/CAM milled full-contour porcelain crown</p>
                            </div>
                            <div class="text-end">
                                <strong class="text-dark d-block">$850.00</strong>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item p-3 treatment-item" data-fee="1089">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary mb-1">Phase 3: Implantology</span>
                                <h6 class="mb-0 fw-bold">Tooth #30 Guided Implant Placement</h6>
                                <p class="text-muted small mb-0">4.1mm Straumann bone-level fixture with surgical guide</p>
                            </div>
                            <div class="text-end">
                                <strong class="text-dark d-block">$1,089.00</strong>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0 small" onclick="removeTreatmentItem(this)"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2 py-3 border-top">
                <button type="button" class="btn btn-sm btn-outline-secondary w-50" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print Plan
                </button>
                <button type="button" class="btn btn-sm btn-primary w-50" data-bs-toggle="modal" data-bs-target="#addTreatmentModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-plus-circle me-1"></i> Add Procedure
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Treatment Line Item -->
<div class="modal fade" id="addTreatmentModal" tabindex="-1" aria-labelledby="addTreatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="addTreatmentModalLabel">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>Add Procedure to Treatment Plan
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
                            <label class="form-label fw-semibold small">Procedure Fee ($ USD) <span class="text-danger">*</span></label>
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
                        <i class="bi bi-plus-lg me-1"></i>Add Procedure
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Save Clinical Chart Confirmation -->
<div class="modal fade" id="saveChartModal" tabindex="-1" aria-labelledby="saveChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="saveChartModalLabel">
                    <i class="bi bi-shield-check text-success me-2"></i>Commit Dental Chart & EMR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-teal-subtle text-teal d-inline-flex align-items-center justify-content-center p-3 mb-2" style="background: #CCFBF1; color: #0F766E;">
                        <i class="bi bi-diagram-3-fill fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark">Sarah Jenkins (MRN: #DF-99248)</h6>
                    <p class="text-muted small">Commit updated anatomical tooth surface mapping and treatment plan to electronic medical record.</p>
                </div>
                <div class="bg-light p-3 rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Diagnostic Findings:</span>
                        <strong class="text-dark" id="saveSummaryFindings">3 Conditions Logged</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Proposed Treatment:</span>
                        <strong class="text-success" id="saveSummaryCost">$2,589.00</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Signing Clinician:</span>
                        <strong class="text-dark">Dr. Alexander Vance (Prosthodontist)</strong>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sendPatientCopyWhatsapp" checked>
                    <label class="form-check-label small text-muted" for="sendPatientCopyWhatsapp">
                        <i class="bi bi-whatsapp text-success me-1"></i> Send patient summary copy via WhatsApp & Patient Portal
                    </label>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4 justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="confirmSaveChart()" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-cloud-check me-1"></i>Sign & Commit EMR Chart
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeCondition = 'healthy';
    const toothConditions = {};

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

    // Condition button toggles
    document.querySelectorAll('#conditionToolGroup button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#conditionToolGroup button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeCondition = this.getAttribute('data-condition');
            document.getElementById('selectedToolLabel').innerText = this.innerText.trim();
        });
    });

    // Generate SVG Tooth Element
    function renderToothSvg(toothNum) {
        return `
            <div class="tooth-wrapper text-center" style="width: 44px;">
                <span class="small fw-bold text-muted d-block" style="font-size: 0.6875rem;">#${toothNum}</span>
                <svg width="42" height="42" viewBox="0 0 100 100" data-tooth="${toothNum}">
                    <!-- Buccal (Top) -->
                    <polygon points="10,10 90,10 70,30 30,30" class="tooth-surface" data-surface="buccal" onclick="paintSurface(${toothNum}, 'buccal', this)"/>
                    <!-- Lingual (Bottom) -->
                    <polygon points="30,70 70,70 90,90 10,90" class="tooth-surface" data-surface="lingual" onclick="paintSurface(${toothNum}, 'lingual', this)"/>
                    <!-- Mesial (Left) -->
                    <polygon points="10,10 30,30 30,70 10,90" class="tooth-surface" data-surface="mesial" onclick="paintSurface(${toothNum}, 'mesial', this)"/>
                    <!-- Distal (Right) -->
                    <polygon points="90,10 70,30 70,70 90,90" class="tooth-surface" data-surface="distal" onclick="paintSurface(${toothNum}, 'distal', this)"/>
                    <!-- Occlusal (Center) -->
                    <rect x="30" y="30" width="40" height="40" class="tooth-surface" data-surface="occlusal" onclick="paintSurface(${toothNum}, 'occlusal', this)"/>
                </svg>
            </div>
        `;
    }

    // Paint individual tooth surface
    function paintSurface(toothNum, surface, el) {
        // Clear old classes
        el.className.baseVal = 'tooth-surface';

        if (activeCondition !== 'healthy') {
            el.classList.add(activeCondition);
        }

        if (!toothConditions[toothNum]) {
            toothConditions[toothNum] = {};
        }
        toothConditions[toothNum][surface] = activeCondition;

        updateFindingsUI(toothNum, surface, activeCondition);
    }

    function updateFindingsUI(toothNum, surface, condition) {
        let count = 0;
        for (const t in toothConditions) {
            for (const s in toothConditions[t]) {
                if (toothConditions[t][s] !== 'healthy') count++;
            }
        }
        document.getElementById('findingsCount').innerText = `${count} Conditions`;
        document.getElementById('saveSummaryFindings').innerText = `${count} Conditions Logged`;

        // Dynamically add to findings list if non-healthy
        if (condition && condition !== 'healthy') {
            const list = document.getElementById('findingsList');
            const findingId = `finding-${toothNum}-${surface}`;
            const existing = document.getElementById(findingId);

            const badgeClass = condition === 'caries' ? 'bg-danger' :
                               (condition === 'filling' ? 'bg-primary' :
                               (condition === 'crown' ? 'bg-warning text-dark' :
                               (condition === 'root_canal' ? 'bg-info text-dark' : 'bg-success')));

            const surfaceName = surface.charAt(0).toUpperCase() + surface.slice(1);
            const conditionTitle = condition.replace('_', ' ').toUpperCase();

            const itemHtml = `
                <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="${findingId}">
                    <div>
                        <strong class="text-dark">Tooth #${toothNum} (${surfaceName})</strong>
                        <div class="text-muted small">Diagnostic tag: ${conditionTitle}</div>
                    </div>
                    <span class="badge ${badgeClass}">${conditionTitle}</span>
                </li>
            `;

            if (existing) {
                existing.outerHTML = itemHtml;
            } else {
                list.insertAdjacentHTML('afterbegin', itemHtml);
            }
        }
    }

    // Add Treatment Procedure Handler
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
                        <strong class="text-dark d-block">$${fee.toFixed(2)}</strong>
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

        showOdontogramAlert(`Procedure <strong>${title}</strong> added to Treatment Plan!`);
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

        const formatted = '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('totalPlanCost').innerText = formatted;
        document.getElementById('saveSummaryCost').innerText = formatted;
        document.getElementById('totalPlanProceduresCount').innerText = `${items.length} Procedures`;
    }

    function confirmSaveChart() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('saveChartModal'));
        if (modal) modal.hide();

        const sendWa = document.getElementById('sendPatientCopyWhatsapp').checked;
        const waMsg = sendWa ? ' Summary dispatched via WhatsApp.' : '';

        showOdontogramAlert(`Dental chart and clinical treatment plan successfully encrypted and committed to Patient EMR (MRN: #DF-99248)!${waMsg}`);
    }

    function resetAllTeeth() {
        if (!confirm('Reset all tooth conditions on this chart to healthy?')) return;
        document.querySelectorAll('.tooth-surface').forEach(el => {
            el.className.baseVal = 'tooth-surface';
        });
        for (const key in toothConditions) delete toothConditions[key];
        document.getElementById('findingsCount').innerText = '0 Conditions';
        document.getElementById('findingsList').innerHTML = '<li class="list-group-item text-center text-muted py-3">All 32 teeth charted as Healthy.</li>';
        showOdontogramAlert('Odontogram chart surfaces reset to healthy.', 'info');
    }

    // Populate Upper and Lower Jaws
    document.addEventListener('DOMContentLoaded', () => {
        const upper = document.getElementById('upperJaw');
        const lower = document.getElementById('lowerJaw');

        // Teeth 1 to 16
        for (let i = 1; i <= 16; i++) {
            upper.innerHTML += renderToothSvg(i);
        }

        // Teeth 32 to 17 (standard anatomic mandibular order)
        for (let i = 32; i >= 17; i--) {
            lower.innerHTML += renderToothSvg(i);
        }

        // Pre-paint sample findings for Tooth 19 & 14
        setTimeout(() => {
            const t19Occlusal = document.querySelector('svg[data-tooth="19"] [data-surface="occlusal"]');
            const t19Distal = document.querySelector('svg[data-tooth="19"] [data-surface="distal"]');
            if (t19Occlusal) t19Occlusal.classList.add('caries');
            if (t19Distal) t19Distal.classList.add('caries');

            const t14Occlusal = document.querySelector('svg[data-tooth="14"] [data-surface="occlusal"]');
            if (t14Occlusal) t14Occlusal.classList.add('filling');

            const t30Occlusal = document.querySelector('svg[data-tooth="30"] [data-surface="occlusal"]');
            if (t30Occlusal) t30Occlusal.classList.add('implant');

            toothConditions[19] = { occlusal: 'caries', distal: 'caries' };
            toothConditions[14] = { occlusal: 'filling' };
            toothConditions[30] = { occlusal: 'implant' };
        }, 200);
    });
</script>
@endpush
