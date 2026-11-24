<?php

declare(strict_types=1);

use App\Core\App;

$clinic = $theme['branding'] ?? [];
$colors = $theme['colors'] ?? [];
$kpi = $kpi ?? ['today' => 0, 'this_week' => 0, 'next_week' => 0, 'this_month' => 0, 'pending_triage' => 0];
$patientStats = $patientStats ?? [
    'total_unique' => 0,
    'new_patients' => 0,
    'returning_patients' => 0,
    'this_week_unique' => 0,
    'this_month_unique' => 0,
    'new_percent' => 50,
    'returning_percent' => 50,
];
$leaves = $leavesSummary['list'] ?? [];
$upcoming = $upcomingAppointments ?? [];
?>

<!-- Dashboard Top Header Bar -->
<div class="row mb-4 align-items-center">
    <div class="col-md-7">
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-speedometer2 text-success"></i>
            <span>Clinical Practice Dashboard</span>
        </h2>
        <p class="text-muted mb-0">
            Real-time appointment schedule, patient triage queue, clinician roster, and staff leave alerts.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-md-end gap-2">
        <a href="<?= App::url('/admin/bookings') ?>" class="btn btn-brand rounded-pill shadow-sm">
            <i class="bi bi-calendar2-check-fill me-1"></i> Patient Bookings
        </a>
        <a href="<?= App::url('/admin/doctors/availability') ?>" class="btn btn-outline-primary rounded-pill shadow-sm">
            <i class="bi bi-clock-history me-1"></i> Doctor Roster
        </a>
        <a href="<?= App::url('/') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Live Site
        </a>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 1. TOP KPI ROW: BOOKINGS TODAY, THIS WEEK, NEXT WEEK, THIS MONTH, TRIAGE -->
<!-- ========================================================================= -->
<div class="row g-3 mb-4">
    <!-- Today's Bookings -->
    <div class="col-xl col-md-4 col-sm-6">
        <a href="<?= App::url('/admin/bookings?period=today') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover border-start border-4 border-success">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.05em;">Today</span>
                        <span class="p-2 rounded-circle bg-success-subtle text-success">
                            <i class="bi bi-calendar2-day-fill fs-5"></i>
                        </span>
                    </div>
                    <h2 class="fw-bolder text-dark mb-1"><?= (int)$kpi['today'] ?></h2>
                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-between">
                        <span>Scheduled Today</span>
                        <i class="bi bi-arrow-right text-success"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- This Week Bookings -->
    <div class="col-xl col-md-4 col-sm-6">
        <a href="<?= App::url('/admin/bookings') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover border-start border-4 border-primary">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.05em;">This Week</span>
                        <span class="p-2 rounded-circle bg-primary-subtle text-primary">
                            <i class="bi bi-calendar2-week-fill fs-5"></i>
                        </span>
                    </div>
                    <h2 class="fw-bolder text-dark mb-1"><?= (int)$kpi['this_week'] ?></h2>
                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-between">
                        <span>Mon – Sun Active Load</span>
                        <i class="bi bi-arrow-right text-primary"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Next Week Bookings -->
    <div class="col-xl col-md-4 col-sm-6">
        <a href="<?= App::url('/admin/bookings?period=next_week') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover border-start border-4 border-info">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.05em;">Next Week</span>
                        <span class="p-2 rounded-circle bg-info-subtle text-info">
                            <i class="bi bi-calendar3 fs-5"></i>
                        </span>
                    </div>
                    <h2 class="fw-bolder text-dark mb-1"><?= (int)$kpi['next_week'] ?></h2>
                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-between">
                        <span>Upcoming Week Roster</span>
                        <i class="bi bi-arrow-right text-info"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- This Month Bookings -->
    <div class="col-xl col-md-6 col-sm-6">
        <a href="<?= App::url('/admin/bookings?period=month') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover border-start border-4" style="border-left-color: #8b5cf6 !important;">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.05em;">This Month</span>
                        <span class="p-2 rounded-circle text-purple" style="background-color: #f3e8ff; color: #7c3aed;">
                            <i class="bi bi-calendar2-month fs-5"></i>
                        </span>
                    </div>
                    <h2 class="fw-bolder text-dark mb-1"><?= (int)$kpi['this_month'] ?></h2>
                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-between">
                        <span><?= date('F Y') ?> Volume</span>
                        <i class="bi bi-arrow-right" style="color: #7c3aed;"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending Clinical Triage -->
    <div class="col-xl col-md-6 col-sm-12">
        <a href="<?= App::url('/admin/bookings?status=pending') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover border-start border-4 border-warning bg-warning-subtle bg-opacity-25">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-uppercase fw-bold text-warning-emphasis" style="font-size: 11px; letter-spacing: 0.05em;">Pending Triage</span>
                        <span class="p-2 rounded-circle bg-warning text-dark">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="fw-bolder text-dark mb-1"><?= (int)$kpi['pending_triage'] ?></h2>
                        <span class="badge text-bg-warning text-dark rounded-pill px-2 py-1 small">Action Needed</span>
                    </div>
                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-between">
                        <span>Unconfirmed Patient Slots</span>
                        <i class="bi bi-arrow-right text-warning"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 2. CLINICAL INSIGHTS: DOCTOR LEAVE ALERTS & UNIQUE PATIENTS ANALYTICS   -->
<!-- ========================================================================= -->
<div class="row g-4 mb-4">
    <!-- Left Column: Doctor & Staff Leave Alert Widget -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-person-fill-exclamation text-danger fs-5"></i>
                        <span>Doctor & Staff Leave Schedule</span>
                    </h5>
                    <small class="text-muted">Clinician blackouts & shift coverage for this week and next week</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <?php if (($leavesSummary['count_this_week'] ?? 0) > 0): ?>
                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1">
                            <?= (int)$leavesSummary['count_this_week'] ?> Leave This Week
                        </span>
                    <?php endif; ?>
                    <a href="<?= App::url('/admin/doctors/availability') ?>" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold">
                        <i class="bi bi-calendar-plus me-1"></i> Manage Leaves
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <?php if (empty($leaves)): ?>
                    <div class="text-center py-4 bg-light rounded-4">
                        <div class="p-3 rounded-circle bg-success-subtle text-success d-inline-block mb-2">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Full Clinical Staff Active</h6>
                        <p class="text-muted small mb-0">No surgeon or hygienist leaves scheduled for this or next week.</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach (array_slice($leaves, 0, 4) as $l): ?>
                            <div class="p-3 rounded-3 border bg-light d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?= htmlspecialchars($l['doctor_avatar'] ? App::url($l['doctor_avatar']) : App::url('/images/doctor-das.jpg')) ?>" 
                                         alt="<?= htmlspecialchars($l['doctor_name']) ?>" 
                                         class="rounded-circle border" 
                                         style="width: 44px; height: 44px; object-fit: cover;">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <h6 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($l['doctor_name']) ?></h6>
                                            <span class="badge bg-secondary-subtle text-secondary small py-0 px-2 rounded-pill"><?= htmlspecialchars($l['doctor_badge']) ?></span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i><?= htmlspecialchars($l['date_formatted']) ?>
                                            &bull; <span class="fw-medium text-dark"><?= htmlspecialchars($l['session_label']) ?></span>
                                        </small>
                                        <div class="small text-danger mt-1">
                                            <i class="bi bi-info-circle me-1"></i><?= htmlspecialchars($l['reason']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge <?= htmlspecialchars($l['badge_class']) ?> rounded-pill px-3 py-1 fw-bold">
                                        <?= htmlspecialchars($l['period_label']) ?>
                                    </span>
                                    <div class="mt-2">
                                        <a href="<?= App::url('/admin/doctors/availability?doctor_id=' . (int)$l['doctor_id']) ?>" class="btn btn-xs btn-outline-secondary rounded-pill py-0 px-2 small">
                                            View Clinician <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="row g-2 mt-3 pt-3 border-top text-center text-secondary small">
                    <div class="col-4 border-end">
                        <span class="fw-bold text-dark">4 Clinicians</span>
                        <div class="text-muted" style="font-size: 11px;">Active Surgery Roster</div>
                    </div>
                    <div class="col-4 border-end">
                        <span class="fw-bold <?= ($leavesSummary['count_this_week'] ?? 0) > 0 ? 'text-warning' : 'text-success' ?>">
                            <?= (int)($leavesSummary['count_this_week'] ?? 0) ?> on Leave
                        </span>
                        <div class="text-muted" style="font-size: 11px;">Current Week</div>
                    </div>
                    <div class="col-4">
                        <span class="fw-bold <?= ($leavesSummary['count_next_week'] ?? 0) > 0 ? 'text-info' : 'text-success' ?>">
                            <?= (int)($leavesSummary['count_next_week'] ?? 0) ?> on Leave
                        </span>
                        <div class="text-muted" style="font-size: 11px;">Upcoming Week</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Unique Patient Demographics (New vs Returning) -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-people-fill text-success fs-5"></i>
                        <span>Unique Patient Demographics</span>
                    </h5>
                    <small class="text-muted">Total unique patients & recall retention rates</small>
                </div>
                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">
                    <?= (int)$patientStats['total_unique'] ?> Registered
                </span>
            </div>

            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <!-- Two Key Metric Badges -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-success-subtle bg-opacity-25 border border-success-subtle text-center">
                            <span class="text-uppercase fw-bold text-success" style="font-size: 11px; letter-spacing: 0.05em;">New Patients</span>
                            <h3 class="fw-bolder text-success mb-0 mt-1"><?= (int)$patientStats['new_patients'] ?></h3>
                            <small class="text-muted">First or &gt;3 mo visit</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-primary-subtle bg-opacity-25 border border-primary-subtle text-center">
                            <span class="text-uppercase fw-bold text-primary" style="font-size: 11px; letter-spacing: 0.05em;">Returning Patients</span>
                            <h3 class="fw-bolder text-primary mb-0 mt-1"><?= (int)$patientStats['returning_patients'] ?></h3>
                            <small class="text-muted">Active within 3 mo</small>
                        </div>
                    </div>
                </div>

                <!-- Ratio Bar -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between small fw-semibold mb-1">
                        <span class="text-success"><i class="bi bi-circle-fill me-1 small"></i>New (<?= (int)$patientStats['new_percent'] ?>%)</span>
                        <span class="text-primary"><i class="bi bi-circle-fill me-1 small"></i>Returning (<?= (int)$patientStats['returning_percent'] ?>%)</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 6px; overflow: hidden;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= (int)$patientStats['new_percent'] ?>%"></div>
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= (int)$patientStats['returning_percent'] ?>%"></div>
                    </div>
                </div>

                <!-- Active Patient Counts -->
                <div class="bg-light p-3 rounded-3 mb-3 small d-flex justify-content-around text-center">
                    <div>
                        <div class="text-muted" style="font-size: 11px;">Unique Patients This Week</div>
                        <div class="fw-bold text-dark fs-6"><?= (int)$patientStats['this_week_unique'] ?> Patients</div>
                    </div>
                    <div class="border-start"></div>
                    <div>
                        <div class="text-muted" style="font-size: 11px;">Unique Patients This Month</div>
                        <div class="fw-bold text-dark fs-6"><?= (int)$patientStats['this_month_unique'] ?> Patients</div>
                    </div>
                </div>

                <!-- 3-Month Clinical Practice Rule Alert -->
                <div class="p-3 rounded-3 bg-light border border-success-subtle text-dark" style="font-size: 11.5px; line-height: 1.45;">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    <strong>Clinical Triage Protocol:</strong> In compliance with UK dental healthcare governance, patients who have not attended an examination in over <strong>3 months</strong> are classified as <strong>New Patients</strong> to mandate fresh clinical triage, periodontal charting, and medical history verification.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 3. LIVE CLINICAL APPOINTMENTS QUEUE (TODAY & UPCOMING)                    -->
<!-- ========================================================================= -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-success fs-5"></i>
                <span>Clinical Appointments Queue</span>
            </h5>
            <small class="text-muted">Today's upcoming visits and near-term schedule with quick triage actions</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= App::url('/admin/bookings') ?>" class="btn btn-sm btn-outline-success rounded-pill fw-semibold">
                <span>View Full Roster (<?= (int)$kpi['total'] ?>)</span>
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="table-light text-uppercase text-secondary" style="font-size: 11px; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-4">Reference &amp; Date</th>
                        <th>Patient Details</th>
                        <th>Patient Status</th>
                        <th>Clinician</th>
                        <th>Treatment</th>
                        <th>Notification</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Fast Reminder Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($upcoming)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No appointments in queue.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($upcoming as $b): ?>
                            <?php
                            $isToday = (($b['appointment_date'] ?? '') === date('Y-m-d'));
                            $status = $b['status'] ?? 'pending';
                            $pType = $b['patient_type'] ?? 'new';
                            $phoneRaw = preg_replace('/\D/', '', $b['patient_phone'] ?? '');
                            $waText = urlencode("Hello " . ($b['patient_name'] ?? 'Patient') . ", this is a quick reminder from Acocks Green Dental Surgery for your appointment on " . ($b['appointment_date'] ?? '') . " at " . ($b['appointment_time'] ?? '') . " with " . ($b['doctor_name'] ?? 'your clinician') . ".");
                            $waLink = "https://wa.me/{$phoneRaw}?text={$waText}";
                            $emailSubject = urlencode("Appointment Reminder: " . ($b['appointment_date'] ?? '') . " at " . ($b['appointment_time'] ?? ''));
                            $emailBody = urlencode("Dear " . ($b['patient_name'] ?? 'Patient') . ",\n\nThis is a clinical reminder for your upcoming appointment at Acocks Green Dental Clinic.\n\nDate: " . ($b['appointment_date'] ?? '') . "\nTime: " . ($b['appointment_time'] ?? '') . "\nDoctor: " . ($b['doctor_name'] ?? '') . "\nTreatment: " . ($b['treatment'] ?? '') . "\n\nIf you have any symptoms or need to reschedule, please contact us immediately.");
                            $mailLink = "mailto:" . urlencode($b['patient_email'] ?? '') . "?subject={$emailSubject}&body={$emailBody}";
                            ?>
                            <tr class="<?= $isToday ? 'table-success bg-opacity-10' : '' ?>">
                                <td class="ps-4">
                                    <div class="fw-bold font-monospace text-dark"><?= htmlspecialchars($b['reference'] ?? '') ?></div>
                                    <div class="text-muted small">
                                        <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($b['appointment_date'] ?? '') ?>
                                        <span class="text-success fw-bold ms-1"><?= htmlspecialchars($b['appointment_time'] ?? '') ?></span>
                                    </div>
                                    <?php if ($isToday): ?>
                                        <span class="badge bg-success text-white py-0 px-2 rounded-pill small" style="font-size: 10px;">TODAY</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($b['patient_name'] ?? '') ?></div>
                                    <div class="text-muted small">
                                        <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($b['patient_phone'] ?? '') ?>
                                    </div>
                                    <?php if (!empty($b['patient_email'])): ?>
                                        <div class="text-secondary small" style="font-size: 11px;">
                                            <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($b['patient_email']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($pType === 'new'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-person-plus-fill me-1"></i>New Patient
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-arrow-repeat me-1"></i>Returning
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= htmlspecialchars($b['doctor_name'] ?? '') ?></div>
                                    <small class="text-muted">Dental Clinician</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                        <?= htmlspecialchars($b['treatment'] ?? 'Checkup') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (($b['notification_channel'] ?? '') === 'whatsapp'): ?>
                                        <span class="badge bg-success text-white rounded-pill px-2 py-1">
                                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                        </span>
                                    <?php elseif (($b['notification_channel'] ?? '') === 'email'): ?>
                                        <span class="badge bg-info text-dark rounded-pill px-2 py-1">
                                            <i class="bi bi-envelope-fill me-1"></i>Email
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary text-white rounded-pill px-2 py-1">
                                            <i class="bi bi-bell-fill me-1"></i>Both
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($status === 'confirmed'): ?>
                                        <span class="badge bg-success text-white px-2 py-1 rounded-pill">Confirmed</span>
                                    <?php elseif ($status === 'pending'): ?>
                                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">Pending Triage</span>
                                    <?php elseif ($status === 'completed'): ?>
                                        <span class="badge bg-secondary text-white px-2 py-1 rounded-pill">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger text-white px-2 py-1 rounded-pill">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $waLink ?>" target="_blank" class="btn btn-outline-success" title="Send WhatsApp Reminder">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <?php if (!empty($b['patient_email'])): ?>
                                            <a href="<?= $mailLink ?>" class="btn btn-outline-primary" title="Send Email Reminder">
                                                <i class="bi bi-envelope"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= App::url('/admin/bookings?search=' . urlencode($b['reference'] ?? '')) ?>" class="btn btn-outline-secondary" title="Manage Record">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
