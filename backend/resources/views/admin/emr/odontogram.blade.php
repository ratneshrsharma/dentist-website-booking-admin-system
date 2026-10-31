@extends('layouts.admin')

@section('title', 'Interactive Dental Odontogram EMR - Advanced Dental Clinic')
@section('page_title', 'Digital Dental Chart (Odontogram EMR)')
@section('page_subtitle', 'Interactive 32-adult tooth anatomical surface mapping & staged treatment planning')

@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetAllTeeth()">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Chart
        </button>
        <button type="button" class="btn btn-sm btn-primary" onclick="saveDentalChart()">
            <i class="bi bi-cloud-check-fill me-1"></i> Save Clinical Chart & Treatment Plan
        </button>
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Main Odontogram SVG Surface -->
    <div class="col-12 col-xl-8">
        <div class="card shadow-sm mb-4">
            <!-- Patient Banner -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">Patient EMR:</span>
                    <strong class="text-dark ms-1">Sarah Jenkins</strong>
                    <span class="badge bg-secondary-subtle text-secondary ms-2">MRN: #DF-99248</span>
                    <span class="badge bg-danger-subtle text-danger ms-1">Allergy: Penicillin</span>
                </div>
                <div>
                    <span class="text-muted small">Attending:</span>
                    <strong class="text-primary ms-1">Dr. Alexander Vance (Prosthodontist)</strong>
                </div>
            </div>

            <!-- Odontogram Chart Toolbar -->
            <div class="p-3 bg-light border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="small fw-bold text-muted text-uppercase">Diagnostic Tool:</span>
                    <div class="btn-group btn-group-sm" role="group" id="conditionToolGroup">
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

            <div class="card-footer bg-light small text-muted d-flex justify-content-between">
                <span><i class="bi bi-info-circle me-1"></i> Click on any anatomical surface: <strong>B</strong> (Buccal), <strong>L</strong> (Lingual), <strong>M</strong> (Mesial), <strong>D</strong> (Distal), or <strong>O</strong> (Occlusal).</span>
                <span>Universal Numbering System (1 - 32)</span>
            </div>
        </div>
    </div>

    <!-- Treatment Plan & Diagnostics Sidebar -->
    <div class="col-12 col-xl-4">
        <!-- Diagnosis Summary -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="bi bi-clipboard2-pulse-fill text-primary me-2"></i>Active Chart Findings</span>
                <span class="badge bg-primary" id="findingsCount">3 Conditions</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush small" id="findingsList">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <strong class="text-danger">Tooth #19 (Lower Left 1st Molar)</strong>
                            <div class="text-muted">Occlusal & Distal Deep Caries (Pain 8/10)</div>
                        </div>
                        <span class="badge bg-danger">Caries</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <strong class="text-primary">Tooth #14 (Upper Left 1st Molar)</strong>
                            <div class="text-muted">Existing MOD Composite Restoration</div>
                        </div>
                        <span class="badge bg-primary">Filled</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <strong class="text-success">Tooth #30 (Lower Right 1st Molar)</strong>
                            <div class="text-muted">Missing tooth planned for Guided Titanium Implant</div>
                        </div>
                        <span class="badge bg-success">Implant</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Staged Clinical Treatment Plan Builder -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="bi bi-card-checklist text-success me-2"></i>Proposed Treatment Plan</span>
                <span class="badge bg-success" id="totalPlanCost">$2,589.00</span>
            </div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-light">
                    <span class="text-muted small">Plan Reference: <strong>#TP-2026-0881</strong></span>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 33%;"></div>
                    </div>
                    <span class="small text-muted mt-1 d-block">Stage 1 of 3: Emergency Infection Control</span>
                </div>

                <div class="list-group list-group-flush small">
                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger mb-1">Phase 1: Emergency</span>
                                <h6 class="mb-0 fw-bold">Tooth #19 Microscopic Pulpectomy</h6>
                                <p class="text-muted small mb-0">Rotary canal extirpation, calcium hydroxide medicament</p>
                            </div>
                            <strong class="text-dark">$650.00</strong>
                        </div>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-warning text-dark mb-1">Phase 2: Restorative</span>
                                <h6 class="mb-0 fw-bold">Tooth #19 E-Max Core & Ceramic Crown</h6>
                                <p class="text-muted small mb-0">CAD/CAM milled full-contour porcelain crown</p>
                            </div>
                            <strong class="text-dark">$850.00</strong>
                        </div>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary mb-1">Phase 3: Implantology</span>
                                <h6 class="mb-0 fw-bold">Tooth #30 Guided Implant Placement</h6>
                                <p class="text-muted small mb-0">4.1mm Straumann bone-level fixture with surgical guide</p>
                            </div>
                            <strong class="text-dark">$1,089.00</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary w-50" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print Plan
                </button>
                <button type="button" class="btn btn-sm btn-success w-50" onclick="alert('Digital prescription & consent dispatched to Sarah Jenkins via WhatsApp and Patient Portal!')">
                    <i class="bi bi-send-check-fill me-1"></i> Send Consent
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

        updateFindingsUI();
    }

    function updateFindingsUI() {
        let count = 0;
        for (const t in toothConditions) {
            for (const s in toothConditions[t]) {
                if (toothConditions[t][s] !== 'healthy') count++;
            }
        }
        document.getElementById('findingsCount').innerText = `${count + 3} Conditions Recorded`;
    }

    function resetAllTeeth() {
        if (!confirm('Reset all tooth conditions on this chart to healthy?')) return;
        document.querySelectorAll('.tooth-surface').forEach(el => {
            el.className.baseVal = 'tooth-surface';
        });
        for (const key in toothConditions) delete toothConditions[key];
        document.getElementById('findingsCount').innerText = '0 Conditions';
    }

    function saveDentalChart() {
        alert('Dental chart and clinical treatment plan successfully encrypted and committed to Patient EMR (MRN: #DF-99248)!');
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
        }, 300);
    });
</script>
@endpush
