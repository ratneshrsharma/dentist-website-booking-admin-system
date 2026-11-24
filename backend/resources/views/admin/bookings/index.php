<?php

declare(strict_types=1);

use App\Core\App;

$pageTitle = 'Patient Bookings & Clinical Appointments';

$rescheduledRef = $_GET['rescheduled'] ?? '';
$rescheduledBooking = null;
if ($rescheduledRef) {
    foreach ($bookings as $bk) {
        if ($bk['reference'] === $rescheduledRef) {
            $rescheduledBooking = $bk;
            break;
        }
    }
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-calendar2-check-fill text-success me-2"></i> Patient Bookings & Clinical Schedule
        </h3>
        <p class="text-muted small mb-0">
            Monitor and manage clinical appointment bookings, triage patient requests, reschedule slots, and dispatch instant reminders across WhatsApp and Email.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="<?= App::url('/admin/doctors/availability') ?>" class="btn btn-outline-success rounded-pill shadow-sm">
            <i class="bi bi-clock-history me-1"></i> Doctor Working Hours & Leave
        </a>
        <a href="<?= App::url('/') ?>#quick-book" target="_blank" class="btn btn-success rounded-pill shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> New Patient Booking
        </a>
    </div>
</div>

<!-- Rescheduled Confirmation Banner with 1-Click Update Actions -->
<?php if ($rescheduledBooking): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 mb-4" role="alert">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-1 text-success d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-4"></i> Booking Successfully Rescheduled!
                </h5>
                <p class="mb-0 text-dark small">
                    Reference: <strong class="font-monospace text-success"><?= htmlspecialchars($rescheduledBooking['reference']) ?></strong> • 
                    Patient: <strong><?= htmlspecialchars($rescheduledBooking['patient_name']) ?></strong> • 
                    New Date: <strong><?= htmlspecialchars(date('D, d M Y', strtotime($rescheduledBooking['appointment_date']))) ?> at <?= htmlspecialchars($rescheduledBooking['appointment_time']) ?></strong> with <strong><?= htmlspecialchars($rescheduledBooking['doctor_name']) ?></strong>
                </p>
                <small class="text-muted">Click below to send instant confirmation passes to the patient via their preferred channel:</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <?php 
                    $rWaMsg = urlencode("Hello {$rescheduledBooking['patient_name']},\nYour appointment at Acocks Green Dental Practice has been rescheduled to " . date('D, d M Y', strtotime($rescheduledBooking['appointment_date'])) . " at {$rescheduledBooking['appointment_time']} with {$rescheduledBooking['doctor_name']} (Ref: {$rescheduledBooking['reference']}).\nLocation: 1078 Warwick Road, B27 6BH.\nPlease reply YES to confirm this new slot suits you.");
                    $rSubj = rawurlencode("Rescheduled Appointment Confirmation: Acocks Green Dental [Ref: {$rescheduledBooking['reference']}]");
                    $rBody = rawurlencode("Dear {$rescheduledBooking['patient_name']},\n\nYour clinical appointment at Acocks Green Dental Practice has been rescheduled.\n\nNew Appointment Details:\n- Reference: {$rescheduledBooking['reference']}\n- Clinician: {$rescheduledBooking['doctor_name']}\n- Treatment: {$rescheduledBooking['treatment']}\n- Date: " . date('l, d F Y', strtotime($rescheduledBooking['appointment_date'])) . "\n- Time: {$rescheduledBooking['appointment_time']}\n- Clinic Address: 1078 Warwick Road, Acocks Green, Birmingham B27 6BH\n\nPlease confirm this time is convenient for you by replying to this email or calling us on 0121 765 2870.\n\nWarm regards,\nAcocks Green Dental Care Team");
                ?>
                <a href="https://wa.me/<?= preg_replace('/\D/', '', $rescheduledBooking['patient_phone']) ?>?text=<?= $rWaMsg ?>" target="_blank" class="btn btn-success rounded-pill px-3 shadow-sm btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-whatsapp"></i> Send WhatsApp Confirmation
                </a>
                <a href="mailto:<?= htmlspecialchars($rescheduledBooking['patient_email'] ?? '') ?>?subject=<?= $rSubj ?>&body=<?= $rBody ?>" class="btn btn-primary rounded-pill px-3 shadow-sm btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-envelope-at"></i> Send Email Confirmation
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- KPI Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-primary-subtle text-primary me-3">
                    <i class="bi bi-calendar-day fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-semibold text-uppercase mb-1">Today's Bookings</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= (int)($stats['today'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-success-subtle text-success me-3">
                    <i class="bi bi-calendar-week fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-semibold text-uppercase mb-1">Next 7 Days</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= (int)($stats['next_week'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-info-subtle text-info me-3">
                    <i class="bi bi-calendar3 fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-semibold text-uppercase mb-1">This Month</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= (int)($stats['this_month'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-warning-subtle text-warning me-3">
                    <i class="bi bi-hourglass-split fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-semibold text-uppercase mb-1">Pending Triage</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= (int)($stats['pending'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Card with Filters & Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <!-- Period Navigation Tabs -->
    <div class="card-header bg-white border-bottom pt-3 pb-0">
        <ul class="nav nav-tabs border-bottom-0" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?= $currentPeriod === 'all' ? 'active fw-bold text-success' : 'text-secondary' ?> px-4 py-2" 
                   href="<?= App::url('/admin/bookings?period=all' . ($currentDoctorId ? '&doctor_id=' . $currentDoctorId : '') . ($currentStatus ? '&status=' . $currentStatus : '')) ?>">
                    <i class="bi bi-list-ul me-1"></i> All Bookings (<?= $stats['total'] ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPeriod === 'today' ? 'active fw-bold text-success' : 'text-secondary' ?> px-4 py-2" 
                   href="<?= App::url('/admin/bookings?period=today' . ($currentDoctorId ? '&doctor_id=' . $currentDoctorId : '') . ($currentStatus ? '&status=' . $currentStatus : '')) ?>">
                    <i class="bi bi-clock-history me-1"></i> Today (<?= $stats['today'] ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPeriod === 'next_week' ? 'active fw-bold text-success' : 'text-secondary' ?> px-4 py-2" 
                   href="<?= App::url('/admin/bookings?period=next_week' . ($currentDoctorId ? '&doctor_id=' . $currentDoctorId : '') . ($currentStatus ? '&status=' . $currentStatus : '')) ?>">
                    <i class="bi bi-calendar-event me-1"></i> Next Week (<?= $stats['next_week'] ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPeriod === 'month' ? 'active fw-bold text-success' : 'text-secondary' ?> px-4 py-2" 
                   href="<?= App::url('/admin/bookings?period=month' . ($currentDoctorId ? '&doctor_id=' . $currentDoctorId : '') . ($currentStatus ? '&status=' . $currentStatus : '')) ?>">
                    <i class="bi bi-calendar-month me-1"></i> Monthly Roster (<?= $stats['this_month'] ?>)
                </a>
            </li>
        </ul>
    </div>

    <!-- Filter Bar -->
    <div class="card-body bg-light border-bottom p-3">
        <form action="<?= App::url('/admin/bookings') ?>" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="period" value="<?= htmlspecialchars($currentPeriod) ?>">

            <!-- Doctor Filter -->
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person-badge"></i></span>
                    <select name="doctor_id" class="form-select bg-white" onchange="this.form.submit()">
                        <option value="">All Clinicians & Doctors</option>
                        <?php foreach ($doctors as $doc): ?>
                            <option value="<?= $doc['id'] ?>" <?= ($currentDoctorId === (int)$doc['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($doc['name']) ?> (<?= htmlspecialchars($doc['badge'] ?? 'Dentist') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-md-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select bg-white" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="confirmed" <?= $currentStatus === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending Triage</option>
                        <option value="completed" <?= $currentStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $currentStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Search Query -->
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control bg-white" placeholder="Search patient name, phone, email, or ref..." value="<?= htmlspecialchars($currentSearch ?? '') ?>">
                    <button class="btn btn-outline-secondary" type="submit">Filter</button>
                </div>
            </div>

            <!-- Reset Filters -->
            <div class="col-md-2 text-md-end">
                <?php if ($currentDoctorId || $currentStatus || $currentSearch || $currentPeriod !== 'all'): ?>
                    <a href="<?= App::url('/admin/bookings') ?>" class="btn btn-sm btn-outline-danger rounded-pill w-100">
                        <i class="bi bi-x-circle me-1"></i> Reset Filters
                    </a>
                <?php else: ?>
                    <span class="badge text-bg-light text-muted small py-2 w-100">
                        Showing <?= count($bookings) ?> record(s)
                    </span>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Bookings Data Table -->
    <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary sticky-top" style="z-index: 5; font-size: 12px; text-transform: uppercase;">
                <tr>
                    <th class="ps-4" style="width: 140px;">Ref / Date</th>
                    <th>Patient Name & Contact</th>
                    <th>Notification Channel</th>
                    <th>Assigned Doctor</th>
                    <th>Treatment / Service</th>
                    <th>Slot Schedule</th>
                    <th>Status</th>
                    <th class="text-end pe-4" style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                            <h5 class="fw-semibold text-secondary">No appointments found matching this filter</h5>
                            <p class="text-muted small mb-0">Try adjusting your date period, clinician selection, or search query.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $b): ?>
                        <?php 
                            $safeRef = preg_replace('/[^A-Za-z0-9_-]/', '_', $b['reference']);
                            $waCleanPhone = preg_replace('/\D/', '', $b['patient_phone']);
                            $remindWaText = urlencode("Appointment Reminder from Acocks Green Dental Practice:\nDear {$b['patient_name']},\nYour appointment for {$b['treatment']} with {$b['doctor_name']} is scheduled on " . date('D, d M Y', strtotime($b['appointment_date'])) . " at {$b['appointment_time']} (Ref: {$b['reference']}).\nLocation: 1078 Warwick Road, B27 6BH.\nPlease reply YES to confirm your attendance.");
                            $remindMailSubj = rawurlencode("Appointment Reminder: {$b['treatment']} at Acocks Green Dental [Ref: {$b['reference']}]");
                            $remindMailBody = rawurlencode("Dear {$b['patient_name']},\n\nThis is a friendly reminder of your upcoming clinical appointment at Acocks Green Dental Practice.\n\nAppointment Details:\n- Reference: {$b['reference']}\n- Clinician: {$b['doctor_name']}\n- Treatment: {$b['treatment']}\n- Scheduled Date: " . date('l, d F Y', strtotime($b['appointment_date'])) . "\n- Scheduled Time: {$b['appointment_time']}\n- Clinic Address: 1078 Warwick Road, Acocks Green, Birmingham B27 6BH\n\nPlease arrive 5 minutes prior to your allocated slot. If you need to make any changes, contact reception on 0121 765 2870.\n\nWarm regards,\nAcocks Green Dental Care Team");
                        ?>
                        <tr>
                            <!-- Reference -->
                            <td class="ps-4">
                                <span class="fw-bold font-monospace text-dark d-block"><?= htmlspecialchars($b['reference']) ?></span>
                                <small class="text-muted" style="font-size: 11px;">
                                    <?= htmlspecialchars(date('d M Y', strtotime($b['created_at'] ?? 'now'))) ?>
                                </small>
                            </td>

                            <!-- Patient Info -->
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($b['patient_name']) ?></div>
                                <div class="small text-muted d-flex align-items-center gap-1">
                                    <i class="bi bi-telephone text-success"></i> <?= htmlspecialchars($b['patient_phone']) ?>
                                </div>
                                <?php if (!empty($b['patient_email'])): ?>
                                    <div class="small text-muted d-flex align-items-center gap-1">
                                        <i class="bi bi-envelope text-primary"></i> <?= htmlspecialchars($b['patient_email']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Notification Preference Badge (WhatsApp / Email / Both) -->
                            <td>
                                <?php 
                                    $channel = $b['notification_channel'] ?? 'whatsapp';
                                    if ($channel === 'whatsapp'): 
                                ?>
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                    </span>
                                <?php elseif ($channel === 'email'): ?>
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                        <i class="bi bi-envelope-at me-1"></i> Email
                                    </span>
                                <?php else: ?>
                                    <span class="badge rounded-pill bg-purple-subtle text-purple border border-purple-subtle px-2 py-1" style="background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff;">
                                        <i class="bi bi-bell-fill me-1"></i> WhatsApp & Email
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Assigned Doctor -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2 rounded-circle bg-light border p-1" style="width: 38px; height: 38px; overflow: hidden;">
                                        <img src="<?= App::url('/images/doctor-das.jpg') ?>" alt="Doc" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small"><?= htmlspecialchars($b['doctor_name']) ?></div>
                                        <small class="text-muted" style="font-size: 11px;">Dental Surgeon</small>
                                    </div>
                                </div>
                            </td>

                            <!-- Treatment -->
                            <td>
                                <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                    <?= htmlspecialchars($b['treatment']) ?>
                                </span>
                                <?php if (!empty($b['notes'])): ?>
                                    <div class="text-muted small text-truncate mt-1" style="max-width: 180px;" title="<?= htmlspecialchars($b['notes']) ?>">
                                        <i class="bi bi-chat-left-text me-1"></i> <?= htmlspecialchars($b['notes']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Slot Schedule -->
                            <td>
                                <div class="fw-bold text-dark small">
                                    <i class="bi bi-calendar3 me-1 text-success"></i> <?= htmlspecialchars(date('D, d M Y', strtotime($b['appointment_date']))) ?>
                                </div>
                                <div class="badge bg-success-subtle text-success fw-semibold mt-1">
                                    <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($b['appointment_time']) ?> (<?= (int)($b['duration_minutes'] ?? 30) ?>m)
                                </div>
                            </td>

                            <!-- Status -->
                            <td>
                                <?php
                                    $st = $b['status'] ?? 'pending';
                                    if ($st === 'confirmed') {
                                        echo '<span class="badge rounded-pill bg-success px-3 py-2"><i class="bi bi-check-circle me-1"></i> Confirmed</span>';
                                    } elseif ($st === 'pending') {
                                        echo '<span class="badge rounded-pill bg-warning text-dark px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Pending Triage</span>';
                                    } elseif ($st === 'completed') {
                                        echo '<span class="badge rounded-pill bg-info text-white px-3 py-2"><i class="bi bi-clipboard2-check me-1"></i> Completed</span>';
                                    } else {
                                        echo '<span class="badge rounded-pill bg-danger px-3 py-2"><i class="bi bi-x-circle me-1"></i> Cancelled</span>';
                                    }
                                ?>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                                        Manage
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li>
                                            <button type="button" class="dropdown-item text-primary small fw-semibold" data-bs-toggle="modal" data-bs-target="#rescheduleModal_<?= $safeRef ?>">
                                                <i class="bi bi-calendar2-range me-2 text-primary"></i> Reschedule Booking
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?= App::url('/admin/bookings/' . urlencode($b['reference']) . '/status') ?>" method="POST">
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item text-success small">
                                                    <i class="bi bi-check-circle me-2"></i> Confirm Appointment
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="<?= App::url('/admin/bookings/' . urlencode($b['reference']) . '/status') ?>" method="POST">
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item text-info small">
                                                    <i class="bi bi-clipboard-check me-2"></i> Mark Completed
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="<?= App::url('/admin/bookings/' . urlencode($b['reference']) . '/status') ?>" method="POST">
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item text-warning small">
                                                    <i class="bi bi-slash-circle me-2"></i> Cancel Slot
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <?php if (!empty($b['patient_phone'])): ?>
                                            <li>
                                                <a class="dropdown-item text-success small" target="_blank" 
                                                   href="https://wa.me/<?= $waCleanPhone ?>?text=<?= $remindWaText ?>">
                                                    <i class="bi bi-whatsapp me-2"></i> Send WhatsApp Reminder
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (!empty($b['patient_email'])): ?>
                                            <li>
                                                <a class="dropdown-item text-primary small" 
                                                   href="mailto:<?= htmlspecialchars($b['patient_email']) ?>?subject=<?= $remindMailSubj ?>&body=<?= $remindMailBody ?>">
                                                    <i class="bi bi-envelope-at me-2"></i> Send Email Reminder
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?= App::url('/admin/bookings/' . urlencode($b['reference']) . '/delete') ?>" method="POST" onsubmit="return confirm('Permanently delete this booking record?');">
                                                <button type="submit" class="dropdown-item text-danger small">
                                                    <i class="bi bi-trash me-2"></i> Delete Record
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer with Summary -->
    <div class="card-footer bg-white border-top py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <small class="text-muted">
            Showing <strong><?= count($bookings) ?></strong> appointment(s) in current clinical queue.
        </small>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= App::url('/admin/doctors/availability') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-sliders me-1"></i> Manage Doctors Schedule & Timing
            </a>
        </div>
    </div>
</div>

<!-- Reschedule Modals for Bookings -->
<?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $b): ?>
        <?php $safeRef = preg_replace('/[^A-Za-z0-9_-]/', '_', $b['reference']); ?>
        <div class="modal fade" id="rescheduleModal_<?= $safeRef ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <form action="<?= App::url('/admin/bookings/' . urlencode($b['reference']) . '/reschedule') ?>" method="POST">
                        <div class="modal-header bg-light py-3 border-bottom">
                            <h6 class="modal-title fw-bold text-dark mb-0">
                                <i class="bi bi-calendar2-range text-primary me-2"></i> Reschedule Appointment [<?= htmlspecialchars($b['reference']) ?>]
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Current Info Box -->
                            <div class="bg-light p-3 rounded-3 mb-3 small">
                                <div class="mb-1">Patient: <strong class="text-dark"><?= htmlspecialchars($b['patient_name']) ?></strong> (<?= htmlspecialchars($b['patient_phone']) ?>)</div>
                                <div class="mb-1">Current Slot: <span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($b['appointment_date']) ?> at <?= htmlspecialchars($b['appointment_time']) ?></span></div>
                                <div>Treatment: <strong class="text-dark"><?= htmlspecialchars($b['treatment']) ?></strong></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">New Appointment Date <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" class="form-control" required min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($b['appointment_date']) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">New Time Slot <span class="text-danger">*</span></label>
                                <select name="appointment_time" class="form-select" required>
                                    <?php 
                                        $commonSlots = ['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:15 AM', '11:45 AM', '02:00 PM', '02:45 PM', '03:30 PM', '04:15 PM', '05:00 PM'];
                                        foreach ($commonSlots as $cs):
                                    ?>
                                        <option value="<?= $cs ?>" <?= $b['appointment_time'] === $cs ? 'selected' : '' ?>><?= $cs ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Assigned Clinician</label>
                                <select name="doctor_id" class="form-select">
                                    <?php foreach ($doctors as $d): ?>
                                        <option value="<?= $d['id'] ?>" <?= ((int)$b['doctor_id'] === (int)$d['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($d['name']) ?> (<?= htmlspecialchars($d['badge'] ?? 'Dentist') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-bold text-secondary">Reschedule Reason / Clinical Note</label>
                                <input type="text" name="notes" class="form-control" placeholder="e.g. Patient requested morning slot change">
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top py-2 px-4">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">
                                <i class="bi bi-check2-circle me-1"></i> Save & Prepare Confirmation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
