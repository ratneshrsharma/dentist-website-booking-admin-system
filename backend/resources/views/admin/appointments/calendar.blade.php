@extends('layouts.admin')

@section('title', 'Clinical Scheduler & Chair Concurrency - Advanced Dental PRO')
@section('page_title', 'Doctor Appointment Scheduler')
@section('page_subtitle', 'FullCalendar 6 Resource TimeGrid with real-time chair concurrency, patient search & double-booking prevention')

@section('page_actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#newApptModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
            <i class="bi bi-calendar-plus me-1"></i> New Walk-In Appointment
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshCalendarEvents()">
            <i class="bi bi-arrow-clockwise me-1"></i> Sync Roster
        </button>
    </div>
@endsection

@section('content')
<!-- Appointment Status Alert Placeholder -->
<div id="calendarAlertPlaceholder" class="mb-3"></div>

<div class="row g-4">
    <!-- Left Filter & Resource Concurrency Column -->
    <div class="col-12 col-xl-3">
        <!-- Live Chair Concurrency Status (Senior Dev Item 7) -->
        <div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-diagram-3-fill text-teal me-2" style="color: #0D9488;"></i>Operatory Chairs</span>
                <span class="badge bg-teal" style="background-color: #0D9488;">6 Operatories</span>
            </div>
            <div class="card-body p-3">
                <div class="vstack gap-2" id="chairLiveList">
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 1: Surgical Unit (HQ)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">Sterile Surgical Setup</span>
                        </div>
                        <span class="badge bg-success-subtle text-success small">Available</span>
                    </div>
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 2: Restorative (HQ)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">David Sample (10:30 - 11:30)</span>
                        </div>
                        <span class="badge bg-danger-subtle text-danger small">In Chair</span>
                    </div>
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 3: Aesthetics (HQ)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">Sophia Patel (14:00 - 15:00)</span>
                        </div>
                        <span class="badge bg-primary-subtle text-primary small">Reserved</span>
                    </div>
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 4: Orthodontics (HQ)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">Marcus Sterling (11:15 - 12:00)</span>
                        </div>
                        <span class="badge bg-danger-subtle text-danger small">In Chair</span>
                    </div>
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 5: Pediatric Suite (HQ)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">Leo Carter (09:30 - 10:15)</span>
                        </div>
                        <span class="badge bg-success-subtle text-success small">Available</span>
                    </div>
                    <div class="p-2 border rounded-2 d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <strong class="d-block text-dark small">Chair 6: Operatory A (Westside)</strong>
                            <span class="text-muted" style="font-size: 0.72rem;">Westside Branch</span>
                        </div>
                        <span class="badge bg-success-subtle text-success small">Available</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Doctors Card -->
        <div class="card shadow-sm border-0 rounded-3 mb-4 bg-white">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-bold text-dark"><i class="bi bi-funnel-fill text-primary me-2"></i>Filter Clinicians</span>
            </div>
            <div class="card-body p-3">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Clinic Branch</label>
                    <select class="form-select form-select-sm" id="branchFilter">
                        <option value="1" selected>Central Practice (HQ - 5 Chairs)</option>
                        <option value="2">Westside Studio (1 Chair)</option>
                    </select>
                </div>

                <label class="form-label small fw-bold text-muted">Clinicians</label>
                <div class="vstack gap-2">
                    <label class="form-check small d-flex align-items-center gap-2 m-0 p-0 ps-4">
                        <input class="form-check-input doctor-filter" type="checkbox" value="1" checked onchange="filterCalendar()">
                        <span class="badge rounded-circle p-1" style="background-color: #0D9488;">&nbsp;</span>
                        <span class="text-dark fw-semibold">Dr. Ethan Caldwell, DDS</span>
                    </label>
                    <label class="form-check small d-flex align-items-center gap-2 m-0 p-0 ps-4">
                        <input class="form-check-input doctor-filter" type="checkbox" value="2" checked onchange="filterCalendar()">
                        <span class="badge rounded-circle p-1" style="background-color: #3B82F6;">&nbsp;</span>
                        <span class="text-dark fw-semibold">Dr. Maya Lin, DMD, MS</span>
                    </label>
                    <label class="form-check small d-flex align-items-center gap-2 m-0 p-0 ps-4">
                        <input class="form-check-input doctor-filter" type="checkbox" value="3" checked onchange="filterCalendar()">
                        <span class="badge rounded-circle p-1" style="background-color: #F59E0B;">&nbsp;</span>
                        <span class="text-dark fw-semibold">Dr. Sarah Jenkins, DDS</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Color Legend -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-bold text-dark small"><i class="bi bi-palette-fill text-secondary me-2"></i>Status Palette</span>
            </div>
            <div class="card-body p-3 small">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #0D9488;"></div>
                    <span class="text-dark">Confirmed Consultation</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #3B82F6;"></div>
                    <span class="text-dark">In Chair / In-Progress</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #10B981;"></div>
                    <span class="text-dark">Completed & Invoiced (£)</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 14px; height: 14px; border-radius: 3px; background: #EF4444;"></div>
                    <span class="text-dark">Urgent Emergency / Trauma</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: FullCalendar Interactive Surface -->
    <div class="col-12 col-xl-9">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-body p-3">
                <div id="clinicalCalendar" style="min-height: 750px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: ADVANCED APPOINTMENT BOOKING WITH PATIENT SEARCH & CONCURRENCY (Item 7) -->
<!-- ========================================================================= -->
<div class="modal fade" id="newApptModal" tabindex="-1" aria-labelledby="newApptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="newApptModalLabel">
                    <i class="bi bi-calendar-check-fill text-teal me-2" style="color: #0D9488;"></i>Schedule Clinical Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="appointmentBookingForm" onsubmit="handleBookingSubmit(event)">
                <div class="modal-body p-4">
                    <!-- Inline Conflict Alert Container -->
                    <div id="modalConflictAlert" class="d-none alert alert-danger border-danger small mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                            <div id="modalConflictMessage">Double booking conflict detected.</div>
                        </div>
                    </div>

                    <!-- 1. Existing Patient vs New Patient Toggle (Item 7) -->
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-uppercase text-muted">
                                <i class="bi bi-person-bounding-box me-1"></i>Patient Identification:
                            </span>
                            <div class="btn-group btn-group-sm" role="group">
                                <input type="radio" class="btn-check" name="patient_mode" id="modeExisting" value="existing" checked onchange="togglePatientMode('existing')">
                                <label class="btn btn-outline-primary" for="modeExisting">Existing Registered Patient</label>

                                <input type="radio" class="btn-check" name="patient_mode" id="modeNew" value="new" onchange="togglePatientMode('new')">
                                <label class="btn btn-outline-primary" for="modeNew">New Walk-In Patient</label>
                            </div>
                        </div>

                        <!-- Existing Patient Autocomplete Search -->
                        <div id="existingPatientSection">
                            <label class="form-label small fw-bold text-secondary">Search Existing Patient Record (Name or MRN) <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" class="form-control" id="patientSearchInput" placeholder="Type name (e.g. David Sample, Sarah, Leo) or MRN..." oninput="filterPatientDropdown(this.value)">
                            </div>
                            <!-- Autocomplete Dropdown List -->
                            <div id="patientAutocompleteDropdown" class="list-group shadow-sm border small" style="max-height: 180px; overflow-y: auto; display: none;">
                                <!-- Filled via JS from PATIENT_REGISTRY -->
                            </div>
                            <!-- Selected Patient Highlight Card -->
                            <div id="selectedPatientBadge" class="p-2.5 mt-2 bg-white rounded-2 border d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-dark" id="dispPatientName">David Sample</strong>
                                    <span class="badge bg-secondary-subtle text-secondary ms-1" id="dispPatientMrn">MRN-2026-0001</span>
                                    <div class="text-muted small" id="dispPatientDetails">38 yrs • Male • <span class="text-danger fw-semibold">Allergy: Penicillin</span></div>
                                </div>
                                <span class="badge bg-success-subtle text-success small"><i class="bi bi-check-circle me-1"></i>Active EMR</span>
                            </div>
                            <input type="hidden" id="selectedPatientId" name="patient_id" value="1045">
                        </div>

                        <!-- New Patient Inputs -->
                        <div id="newPatientSection" style="display: none;">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="newPatientFirstName" placeholder="e.g. John">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="newPatientLastName" placeholder="e.g. Smith">
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number (WhatsApp) <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="patientPhoneInput" value="+44 7700 900283" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" class="form-control" id="patientEmailInput" value="david.sample@example.com">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Doctor Specialist & Chair Selection (Item 7) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Attending Clinician <span class="text-danger">*</span></label>
                            <select class="form-select" id="bookingDoctorSelect" required onchange="checkRealtimeAvailability()">
                                <option value="1" selected>Dr. Ethan Caldwell, DDS, FACP (Prosthodontist)</option>
                                <option value="2">Dr. Maya Lin, DMD, MS (Orthodontist & Pediatric)</option>
                                <option value="3">Dr. Sarah Jenkins, DDS (Aesthetic Specialist)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Operatory Chair <span class="text-danger">*</span></label>
                            <select class="form-select" id="bookingChairSelect" required onchange="checkRealtimeAvailability()">
                                <option value="1">Chair 1: Surgical Unit (HQ)</option>
                                <option value="2">Chair 2: General / Restorative (HQ)</option>
                                <option value="3" selected>Chair 3: Orthodontics & Aesthetics (HQ)</option>
                                <option value="4">Chair 4: Endodontic Suite (HQ)</option>
                                <option value="5">Chair 5: Pediatric Gentle Suite (HQ)</option>
                                <option value="6">Chair 6: Studio Operatory A (Westside)</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Procedure & Duration Selection (Item 7) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold">Clinical Procedure <span class="text-danger">*</span></label>
                            <select class="form-select" id="bookingProcedureSelect" required onchange="handleProcedureFeeChange(this)">
                                <option value="Comprehensive Oral Examination" data-fee="65" data-duration="30">Comprehensive Oral Examination (£65.00)</option>
                                <option value="Routine Ultrasonic Scaling & Hygiene" data-fee="85" data-duration="45">Routine Ultrasonic Scaling & Hygiene (£85.00)</option>
                                <option value="Composite Resin Dental Restoration" data-fee="180" data-duration="45">Composite Resin Dental Restoration (£180.00)</option>
                                <option value="Root Canal Treatment (Molar)" data-fee="650" data-duration="60">Root Canal Treatment - Molar (£650.00)</option>
                                <option value="Zirconia Crown Restorative Fitting" data-fee="750" data-duration="60">Zirconia Crown Restorative Fitting (£750.00)</option>
                                <option value="Straumann Guided Implant Placement" data-fee="1750" data-duration="90">Straumann Guided Implant Placement (£1,750.00)</option>
                                <option value="Invisalign Digital Itero Scan Consult" data-fee="120" data-duration="45">Invisalign Digital Itero Scan Consult (£120.00)</option>
                                <option value="Pediatric Fluoride Varnish & Sealants" data-fee="95" data-duration="30">Pediatric Fluoride Varnish & Sealants (£95.00)</option>
                                <option value="Emergency Toothache & Trauma Relief" data-fee="120" data-duration="30">Emergency Toothache & Trauma Relief (£120.00)</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Appointment Duration <span class="text-danger">*</span></label>
                            <select class="form-select" id="bookingDurationSelect" required onchange="updateEndTimeDisplay(); checkRealtimeAvailability();">
                                <option value="15">15 Minutes (Brief Review)</option>
                                <option value="30">30 Minutes (Standard Checkup)</option>
                                <option value="45" selected>45 Minutes (Restorative / Hygiene)</option>
                                <option value="60">60 Minutes (Endo / Crown Prep)</option>
                                <option value="90">90 Minutes (Surgical / Implant)</option>
                                <option value="120">120 Minutes (Full-Mouth Rehab)</option>
                            </select>
                        </div>
                    </div>

                    <!-- 4. Date, Time Slot & Concurrency Check (Item 7) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="bookingDateInput" value="{{ date('Y-m-d') }}" required onchange="checkRealtimeAvailability()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="bookingTimeInput" value="11:30" required onchange="updateEndTimeDisplay(); checkRealtimeAvailability();">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Expected End Time</label>
                            <input type="text" class="form-control bg-light font-monospace fw-bold text-teal" id="bookingEndTimeDisplay" value="12:15" readonly style="color: #0D9488;">
                        </div>
                    </div>

                    <!-- Live Slot Availability Indicator -->
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-dark">
                                <i class="bi bi-clock-history text-primary me-1"></i>Slot Concurrency Check:
                            </span>
                            <span id="slotStatusBadge" class="badge bg-success-subtle text-success">
                                <i class="bi bi-shield-check me-1"></i>Doctor & Chair Available
                            </span>
                        </div>
                        <div class="d-flex flex-wrap gap-1" id="quickSlotPills">
                            <!-- Populated dynamically via checkRealtimeAvailability() -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="submitBookingBtn" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-shield-lock-fill me-1"></i>Verify Concurrency & Lock Slot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Appointment Details Viewer -->
<div class="modal fade" id="apptDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i>Appointment Clinical Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center me-3 fw-bold" id="detailAvatar" style="width: 44px; height: 44px; background-color: #0D9488;">
                        PT
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" id="detailPatientName">Patient Name</h6>
                        <span class="text-muted small" id="detailRef">Ref: APT-2026-0000</span>
                    </div>
                </div>

                <div class="bg-light p-3 rounded-3 small vstack gap-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Clinician:</span>
                        <strong class="text-dark" id="detailDoctor">Dr. Ethan Caldwell</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Operatory Chair:</span>
                        <strong class="text-teal" id="detailChair" style="color: #0D9488;">Chair 2 (Surgical)</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Procedure:</span>
                        <strong class="text-dark" id="detailProcedure">Dental Implants Consult</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Time Slot & Duration:</span>
                        <strong class="text-dark" id="detailTime">10:30 - 11:30 (60 mins)</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Procedure Fee:</span>
                        <strong class="text-success fs-6" id="detailFee">£450.00</strong>
                    </div>
                </div>

                <a href="#" target="_blank" class="btn btn-outline-success btn-sm w-100" id="detailWhatsappBtn">
                    <i class="bi bi-whatsapp me-1"></i> Send Patient WhatsApp Reminder
                </a>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Comprehensive Patient Registry for Autocomplete Search (Senior Dev Item 7)
    const PATIENT_SEARCH_DATA = [
        { id: 1045, mrn: 'MRN-2026-0001', name: 'David Sample', phone: '+44 7700 900283', email: 'david.sample@example.com', age: 38, gender: 'Male', alerts: 'Penicillin Allergy, Hypertension', doctorId: 1, chairId: 2 },
        { id: 1042, mrn: 'MRN-2026-0042', name: 'Sarah Jenkins', phone: '+44 7911 123456', email: 'sarah.jenkins@example.co.uk', age: 34, gender: 'Female', alerts: 'Latex Allergy', doctorId: 3, chairId: 1 },
        { id: 1046, mrn: 'MRN-2026-0046', name: 'Leo Carter (Pediatric)', phone: '+44 7900 445566', email: 'rachel.carter@example.com', age: 7, gender: 'Male', alerts: 'Mild Asthma (Inhaler)', doctorId: 2, chairId: 5 },
        { id: 1043, mrn: 'MRN-2026-0043', name: 'Marcus Sterling', phone: '+44 7700 900123', email: 'marcus.s@example.com', age: 32, gender: 'Male', alerts: 'None (NKDA)', doctorId: 2, chairId: 4 },
        { id: 1044, mrn: 'MRN-2026-0044', name: 'Sophia Patel', phone: '+44 7890 123456', email: 'sophia.patel@example.com', age: 43, gender: 'Female', alerts: 'Type 2 Diabetes', doctorId: 3, chairId: 3 }
    ];

    let calendarInstance = null;
    let cachedAppointments = [];

    document.addEventListener('DOMContentLoaded', function() {
        initFullCalendar();
        updateEndTimeDisplay();
        checkRealtimeAvailability();
    });

    function initFullCalendar() {
        const calendarEl = document.getElementById('clinicalCalendar');
        const today = new Date().toISOString().split('T')[0];

        calendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay,timeGridWeek,dayGridMonth'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            slotDuration: '00:15:00',
            allDaySlot: false,
            editable: false,
            selectable: true,
            nowIndicator: true,
            events: function(info, successCallback, failureCallback) {
                fetch('{{ url("/api/v1/appointments") }}')
                    .then(res => res.json())
                    .then(data => {
                        cachedAppointments = data.data || [];
                        const events = cachedAppointments.map(a => {
                            const date = a.appointment_date || today;
                            const time = a.appointment_time || '10:00';
                            const duration = parseInt(a.duration_minutes || 45, 10);

                            // Calculate end datetime
                            const parts = time.split(':');
                            const startMins = parseInt(parts[0], 10) * 60 + parseInt(parts[1] || '0', 10);
                            const endMins = startMins + duration;
                            const endH = String(Math.floor(endMins / 60)).padStart(2, '0');
                            const endM = String(endMins % 60).padStart(2, '0');

                            let bgColor = '#0D9488'; // Confirmed
                            if (a.status === 'in_chair') bgColor = '#3B82F6';
                            if (a.treatment_type && a.treatment_type.toLowerCase().includes('emergency')) bgColor = '#EF4444';

                            return {
                                id: String(a.id || a.booking_reference),
                                title: `${a.patient_name} - ${a.treatment_type} (${a.chair_name || 'Chair'})`,
                                start: `${date}T${time}:00`,
                                end: `${date}T${endH}:${endM}:00`,
                                backgroundColor: bgColor,
                                borderColor: bgColor,
                                extendedProps: a
                            };
                        });
                        successCallback(events);
                    })
                    .catch(err => {
                        failureCallback(err);
                    });
            },
            eventClick: function(info) {
                openApptDetailModal(info.event.extendedProps);
            },
            select: function(info) {
                const dateStr = info.startStr.split('T')[0];
                const timeStr = info.startStr.split('T')[1] ? info.startStr.split('T')[1].substring(0, 5) : '10:00';

                document.getElementById('bookingDateInput').value = dateStr;
                document.getElementById('bookingTimeInput').value = timeStr;
                updateEndTimeDisplay();
                checkRealtimeAvailability();

                const modal = new bootstrap.Modal(document.getElementById('newApptModal'));
                modal.show();
            }
        });

        calendarInstance.render();
        window.calendar = calendarInstance;
    }

    function refreshCalendarEvents() {
        if (calendarInstance) {
            calendarInstance.refetchEvents();
            showCalendarAlert('Schedule synchronized with real-time operatory roster.', 'info');
        }
    }

    function filterCalendar() {
        if (calendarInstance) calendarInstance.refetchEvents();
    }

    // Patient Mode Toggle (Existing vs New)
    function togglePatientMode(mode) {
        if (mode === 'existing') {
            document.getElementById('existingPatientSection').style.display = 'block';
            document.getElementById('newPatientSection').style.display = 'none';
        } else {
            document.getElementById('existingPatientSection').style.display = 'none';
            document.getElementById('newPatientSection').style.display = 'block';
            document.getElementById('selectedPatientId').value = '';
            document.getElementById('patientPhoneInput').value = '';
            document.getElementById('patientEmailInput').value = '';
        }
    }

    // Patient Autocomplete Filter
    function filterPatientDropdown(query) {
        const dropdown = document.getElementById('patientAutocompleteDropdown');
        const q = query.trim().toLowerCase();
        if (q.length === 0) {
            dropdown.style.display = 'none';
            return;
        }

        const matches = PATIENT_SEARCH_DATA.filter(p =>
            p.name.toLowerCase().includes(q) ||
            p.mrn.toLowerCase().includes(q) ||
            p.phone.includes(q)
        );

        if (matches.length === 0) {
            dropdown.innerHTML = `<div class="p-2 text-muted">No registered patient matching "${query}"</div>`;
            dropdown.style.display = 'block';
            return;
        }

        dropdown.innerHTML = matches.map(p => `
            <a href="javascript:void(0)" class="list-group-item list-group-item-action p-2" onclick="selectPatientRecord(${p.id})">
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="text-dark">${p.name}</strong>
                    <span class="badge bg-secondary-subtle text-secondary">${p.mrn}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">${p.phone} • Alerts: ${p.alerts}</div>
            </a>
        `).join('');
        dropdown.style.display = 'block';
    }

    function selectPatientRecord(patientId) {
        const p = PATIENT_SEARCH_DATA.find(x => x.id === patientId);
        if (!p) return;

        document.getElementById('selectedPatientId').value = p.id;
        document.getElementById('dispPatientName').innerText = p.name;
        document.getElementById('dispPatientMrn').innerText = p.mrn;
        document.getElementById('dispPatientDetails').innerHTML = `${p.age} yrs • ${p.gender} • <span class="text-danger fw-semibold">Allergy: ${p.alerts}</span>`;
        document.getElementById('patientPhoneInput').value = p.phone;
        document.getElementById('patientEmailInput').value = p.email;
        document.getElementById('patientSearchInput').value = p.name;
        document.getElementById('patientAutocompleteDropdown').style.display = 'none';

        // Set doctor / chair defaults if available
        if (p.doctorId) document.getElementById('bookingDoctorSelect').value = p.doctorId;
        if (p.chairId) document.getElementById('bookingChairSelect').value = p.chairId;

        checkRealtimeAvailability();
    }

    function updateEndTimeDisplay() {
        const timeVal = document.getElementById('bookingTimeInput').value || '10:00';
        const durationVal = parseInt(document.getElementById('bookingDurationSelect').value || '45', 10);

        const parts = timeVal.split(':');
        const startMins = parseInt(parts[0], 10) * 60 + parseInt(parts[1] || '0', 10);
        const endMins = startMins + durationVal;

        const endH = String(Math.floor(endMins / 60) % 24).padStart(2, '0');
        const endM = String(endMins % 60).padStart(2, '0');

        document.getElementById('bookingEndTimeDisplay').value = `${endH}:${endM}`;
    }

    function handleProcedureFeeChange(selectEl) {
        const selectedOpt = selectEl.options[selectEl.selectedIndex];
        const defaultDur = selectedOpt.getAttribute('data-duration');
        if (defaultDur) {
            document.getElementById('bookingDurationSelect').value = defaultDur;
            updateEndTimeDisplay();
            checkRealtimeAvailability();
        }
    }

    // Check Real-Time Availability & Double Booking
    function checkRealtimeAvailability() {
        const date = document.getElementById('bookingDateInput').value;
        const time = document.getElementById('bookingTimeInput').value;
        const duration = parseInt(document.getElementById('bookingDurationSelect').value || '45', 10);
        const doctorId = parseInt(document.getElementById('bookingDoctorSelect').value || '1', 10);
        const chairId = parseInt(document.getElementById('bookingChairSelect').value || '1', 10);

        const alertBox = document.getElementById('modalConflictAlert');
        const badge = document.getElementById('slotStatusBadge');

        // Check against cached appointments
        const parts = time.split(':');
        const candStartMins = parseInt(parts[0], 10) * 60 + parseInt(parts[1] || '0', 10);
        const candEndMins = candStartMins + duration;

        let doctorConflict = null;
        let chairConflict = null;

        cachedAppointments.forEach(ex => {
            if ((ex.appointment_date || '') !== date) return;
            if (ex.status === 'cancelled') return;

            const exParts = (ex.appointment_time || '10:00').split(':');
            const exStartMins = parseInt(exParts[0], 10) * 60 + parseInt(exParts[1] || '0', 10);
            const exDuration = parseInt(ex.duration_minutes || 45, 10);
            const exEndMins = exStartMins + exDuration;

            // Overlap check
            if (Math.max(candStartMins, exStartMins) < Math.min(candEndMins, exEndMins)) {
                if (parseInt(ex.doctor_id || 1, 10) === doctorId) {
                    doctorConflict = ex;
                }
                if (parseInt(ex.chair_id || 1, 10) === chairId) {
                    chairConflict = ex;
                }
            }
        });

        if (doctorConflict) {
            alertBox.classList.remove('d-none');
            document.getElementById('modalConflictMessage').innerText = `Doctor Double-Booking Conflict: Selected clinician is already scheduled with patient ${doctorConflict.patient_name} from ${doctorConflict.appointment_time} to ${doctorConflict.end_time || 'next slot'}.`;
            badge.className = 'badge bg-danger-subtle text-danger';
            badge.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i>Doctor Double-Booked';
            return;
        }

        if (chairConflict) {
            alertBox.classList.remove('d-none');
            document.getElementById('modalConflictMessage').innerText = `Chair Concurrency Conflict: Selected operatory is already occupied by patient ${chairConflict.patient_name} from ${chairConflict.appointment_time} to ${chairConflict.end_time || 'next slot'}.`;
            badge.className = 'badge bg-danger-subtle text-danger';
            badge.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i>Chair Already Occupied';
            return;
        }

        // All Clear!
        alertBox.classList.add('d-none');
        badge.className = 'badge bg-success-subtle text-success';
        badge.innerHTML = '<i class="bi bi-shield-check me-1"></i>Doctor & Chair Concurrency Verified';
    }

    // Submit Booking with Server Validation
    function handleBookingSubmit(event) {
        event.preventDefault();

        const isExisting = document.getElementById('modeExisting').checked;
        const patientId = isExisting ? document.getElementById('selectedPatientId').value : null;
        let patientName = '';

        if (isExisting) {
            patientName = document.getElementById('dispPatientName').innerText;
        } else {
            patientName = `${document.getElementById('newPatientFirstName').value.trim()} ${document.getElementById('newPatientLastName').value.trim()}`;
        }

        const phone = document.getElementById('patientPhoneInput').value.trim();
        const email = document.getElementById('patientEmailInput').value.trim();
        const doctorId = document.getElementById('bookingDoctorSelect').value;
        const chairId = document.getElementById('bookingChairSelect').value;
        const procSelect = document.getElementById('bookingProcedureSelect');
        const treatmentType = procSelect.value;
        const fee = procSelect.options[procSelect.selectedIndex].getAttribute('data-fee') || '120';
        const date = document.getElementById('bookingDateInput').value;
        const time = document.getElementById('bookingTimeInput').value;
        const duration = document.getElementById('bookingDurationSelect').value;

        const payload = {
            patient_id: patientId,
            patient_name: patientName,
            phone: phone,
            email: email,
            doctor_id: doctorId,
            chair_id: chairId,
            treatment_type: treatmentType,
            fee: parseFloat(fee),
            appointment_date: date,
            appointment_time: time,
            duration_minutes: parseInt(duration, 10)
        };

        const submitBtn = document.getElementById('submitBookingBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Verifying Concurrency...';

        fetch('{{ url("/api/v1/appointments/book") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Scheduling conflict detected.');
            }
            return data;
        })
        .then(data => {
            const modalEl = document.getElementById('newApptModal');
            const bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) bsModal.hide();

            showCalendarAlert(`Appointment locked! Ref: <strong>${data.data.booking_reference}</strong> for ${patientName} on ${date} at ${time} (£${parseFloat(fee).toFixed(2)} GBP).`, 'success');
            if (calendarInstance) calendarInstance.refetchEvents();
        })
        .catch(err => {
            const alertBox = document.getElementById('modalConflictAlert');
            alertBox.classList.remove('d-none');
            document.getElementById('modalConflictMessage').innerText = err.message;
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-shield-lock-fill me-1"></i>Verify Concurrency & Lock Slot';
        });
    }

    function openApptDetailModal(appt) {
        document.getElementById('detailPatientName').innerText = appt.patient_name || 'Patient';
        document.getElementById('detailRef').innerText = `Ref: ${appt.booking_reference || 'APT-2026-0000'}`;
        document.getElementById('detailDoctor').innerText = appt.doctor_name || 'Attending Clinician';
        document.getElementById('detailChair').innerText = appt.chair_name || 'Chair Operatory';
        document.getElementById('detailProcedure').innerText = appt.treatment_type || 'Consultation';
        document.getElementById('detailTime').innerText = `${appt.appointment_time || '10:00'} - ${appt.end_time || '11:00'} (${appt.duration_minutes || 45} mins)`;
        document.getElementById('detailFee').innerText = `£${parseFloat(appt.fee || 120).toFixed(2)}`;

        const waBtn = document.getElementById('detailWhatsappBtn');
        const cleanPhone = (appt.patient_phone || '+447700900283').replace(/\D/g, '');
        waBtn.href = `https://wa.me/${cleanPhone}?text=Hello%20${encodeURIComponent(appt.patient_name)}%2C%20your%20appointment%20ref%20${appt.booking_reference}%20at%20Advanced%20Dental%20Clinic%20is%20confirmed%20for%20${appt.appointment_date}%20at%20${appt.appointment_time}.`;

        const modal = new bootstrap.Modal(document.getElementById('apptDetailModal'));
        modal.show();
    }

    function showCalendarAlert(msg, type = 'success') {
        const placeholder = document.getElementById('calendarAlertPlaceholder');
        placeholder.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
</script>
@endpush
