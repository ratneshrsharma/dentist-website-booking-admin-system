<?php

declare(strict_types=1);

use App\Core\App;

$pageTitle = 'Doctor Working Hours & Roster Availability';
$docId = (int)$selectedDoctor['id'];
$weekly = $schedule['weekly'] ?? [];
$slotDuration = (int)($schedule['slot_duration'] ?? 30);
$maxChairs = (int)($schedule['max_chairs'] ?? 1);
?>

<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-clock-history text-success me-2"></i> Doctor Availability & Booking Schedule
        </h3>
        <p class="text-muted small mb-0">
            Set and update recurring clinical working hours, lunch break intervals, and appointment slot durations for each dental surgeon and hygienist.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="<?= App::url('/admin/bookings') ?>" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to All Bookings
        </a>
    </div>
</div>

<!-- Doctor Selector Pills / Tabs -->
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
    <label class="form-label fw-bold text-muted small text-uppercase mb-2">Select Clinician to Manage Schedule:</label>
    <div class="d-flex flex-wrap gap-2">
        <?php foreach ($doctors as $d): ?>
            <?php $isActiveDoc = ((int)$d['id'] === $docId); ?>
            <a href="<?= App::url('/admin/doctors/availability?doctor_id=' . $d['id']) ?>" 
               class="btn <?= $isActiveDoc ? 'btn-success text-white' : 'btn-outline-light text-dark border' ?> rounded-pill px-3 py-2 d-flex align-items-center gap-2 shadow-sm">
                <div class="rounded-circle bg-light border p-1" style="width: 28px; height: 28px; overflow: hidden;">
                    <img src="<?= htmlspecialchars($d['avatar'] ?? App::url('/images/doctor-das.jpg')) ?>" alt="<?= htmlspecialchars($d['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="fw-semibold small"><?= htmlspecialchars($d['name']) ?></span>
                <span class="badge <?= $isActiveDoc ? 'bg-white text-success' : 'bg-secondary-subtle text-secondary' ?> small">
                    <?= htmlspecialchars($d['badge'] ?? 'Dentist') ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Doctor Profile Summary Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-person-badge text-success me-2"></i>Clinician Profile</h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="mx-auto rounded-circle p-1 border border-success border-2 mb-3" style="width: 100px; height: 100px; overflow: hidden;">
                    <img src="<?= htmlspecialchars($selectedDoctor['avatar'] ?? App::url('/images/doctor-das.jpg')) ?>" 
                         alt="<?= htmlspecialchars($selectedDoctor['name']) ?>" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($selectedDoctor['name']) ?></h5>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill mb-3">
                    <?= htmlspecialchars($selectedDoctor['title']) ?>
                </span>

                <div class="text-start bg-light rounded-3 p-3 mt-2">
                    <div class="small mb-2">
                        <strong class="text-secondary d-block">Speciality Focus:</strong>
                        <span class="text-dark"><?= htmlspecialchars($selectedDoctor['speciality'] ?? 'General & Cosmetic Dentistry') ?></span>
                    </div>
                    <div class="small mb-2">
                        <strong class="text-secondary d-block">Direct Email:</strong>
                        <span class="text-dark"><?= htmlspecialchars($selectedDoctor['email'] ?? 'clinic@example.co.uk') ?></span>
                    </div>
                    <div class="small">
                        <strong class="text-secondary d-block">Scheduled Appointments:</strong>
                        <span class="badge bg-primary text-white rounded-pill px-2 py-1"><?= count($doctorBookings) ?> in Queue</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Working Hours & Weekly Availability Form -->
    <div class="col-lg-8">
        <form action="<?= App::url('/admin/doctors/availability') ?>" method="POST">
            <input type="hidden" name="doctor_id" value="<?= $docId ?>">

            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar3-week text-success me-2"></i> Weekly Recurring Roster for <?= htmlspecialchars($selectedDoctor['name']) ?>
                    </h6>
                    <span class="badge bg-light text-muted border">Automatic Calendly-Style Slot Computation</span>
                </div>

                <div class="card-body p-4">
                    <!-- Global Doctor Slot Settings -->
                    <div class="row g-3 mb-4 pb-3 border-bottom">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Default Appointment Slot Duration</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-stopwatch"></i></span>
                                <select name="slot_duration" class="form-select">
                                    <option value="15" <?= $slotDuration === 15 ? 'selected' : '' ?>>15 Minutes (Brief Follow-up)</option>
                                    <option value="30" <?= $slotDuration === 30 ? 'selected' : '' ?>>30 Minutes (Standard Examination & Checkup)</option>
                                    <option value="45" <?= $slotDuration === 45 ? 'selected' : '' ?>>45 Minutes (Hygiene & Restorations)</option>
                                    <option value="60" <?= $slotDuration === 60 ? 'selected' : '' ?>>60 Minutes (Endodontics & Surgery)</option>
                                </select>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Controls interval spacing for patient bookable time pills.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Max Concurrent Patient Chairs</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-hospital"></i></span>
                                <input type="number" name="max_chairs" class="form-control" value="<?= $maxChairs ?>" min="1" max="3">
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Standard is 1 chair per clinician.</small>
                        </div>
                    </div>

                    <!-- Weekly Days Working Table -->
                    <h6 class="fw-bold text-dark mb-3">Daily Shifts & Lunch Break Timings</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light small text-secondary">
                                <tr>
                                    <th style="width: 140px;">Day of Week</th>
                                    <th style="width: 100px;">Working?</th>
                                    <th>Shift Start</th>
                                    <th>Shift End</th>
                                    <th>Lunch / Break Start</th>
                                    <th>Lunch / Break End</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $dayRows = [
                                        1 => 'Monday',
                                        2 => 'Tuesday',
                                        3 => 'Wednesday',
                                        4 => 'Thursday',
                                        5 => 'Friday',
                                        6 => 'Saturday',
                                        0 => 'Sunday',
                                    ];
                                    foreach ($dayRows as $dNum => $dName):
                                        $dData = $weekly[$dNum] ?? ['working' => false, 'start' => '09:00', 'end' => '17:30', 'break_start' => '13:00', 'break_end' => '14:00'];
                                        $isWork = !empty($dData['working']);
                                ?>
                                    <tr class="<?= $isWork ? 'bg-white' : 'table-light text-muted' ?>">
                                        <td class="fw-semibold">
                                            <?= $dName ?>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" name="day_<?= $dNum ?>_working" value="1" <?= $isWork ? 'checked' : '' ?> id="work_<?= $dNum ?>">
                                                <label class="form-check-label small" for="work_<?= $dNum ?>">
                                                    <?= $isWork ? '<span class="text-success fw-bold">Active</span>' : '<span class="text-secondary">Off</span>' ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="day_<?= $dNum ?>_start" class="form-control form-control-sm" value="<?= htmlspecialchars($dData['start'] ?? '09:00') ?>">
                                        </td>
                                        <td>
                                            <input type="time" name="day_<?= $dNum ?>_end" class="form-control form-control-sm" value="<?= htmlspecialchars($dData['end'] ?? '17:30') ?>">
                                        </td>
                                        <td>
                                            <input type="time" name="day_<?= $dNum ?>_break_start" class="form-control form-control-sm" value="<?= htmlspecialchars($dData['break_start'] ?? '13:00') ?>">
                                        </td>
                                        <td>
                                            <input type="time" name="day_<?= $dNum ?>_break_end" class="form-control form-control-sm" value="<?= htmlspecialchars($dData['break_end'] ?? '14:00') ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light border-top py-3 text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Save Working Hours & Timing for <?= htmlspecialchars($selectedDoctor['name']) ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- DOCTOR LEAVE & DATE EXCEPTIONS (Full Day / 1st / 2nd Session)   -->
<!-- ============================================================== -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar-x text-danger me-2"></i> Date Exceptions & Doctor Leave for <?= htmlspecialchars($selectedDoctor['name']) ?>
            </h6>
            <small class="text-muted">
                Configure specific dates when this clinician is on leave: Full Day, 1st Session (Morning), or 2nd Session (Afternoon). Live patient booking slots are automatically adjusted.
            </small>
        </div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
            <i class="bi bi-shield-slash me-1"></i> <?= count($leaves ?? []) ?> Active Leave Date(s)
        </span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4">
            <!-- Add Leave Date Form -->
            <div class="col-lg-5 border-end-lg">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-plus-circle-fill text-danger me-1"></i> Record New Leave / Absence
                </h6>
                <form action="<?= App::url('/admin/doctors/leave/add') ?>" method="POST" class="d-flex flex-column gap-3">
                    <input type="hidden" name="doctor_id" value="<?= $docId ?>">

                    <div>
                        <label class="form-label small fw-bold text-secondary">Select Leave Date <span class="text-danger">*</span></label>
                        <input type="date" name="leave_date" class="form-control" required min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+3 days')) ?>">
                    </div>

                    <div>
                        <label class="form-label small fw-bold text-secondary">Leave Session Coverage <span class="text-danger">*</span></label>
                        <select name="leave_session" class="form-select" required>
                            <option value="full_day">🚫 Full Day (All Day Unavailable)</option>
                            <option value="1st_session">🌅 1st Session Only (Morning: 09:00 – 13:00 Unavailable)</option>
                            <option value="2nd_session">🌇 2nd Session Only (Afternoon: 14:00 – 17:30 Unavailable)</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">
                            For partial sessions, patient booking will offer only the remaining session's slots.
                        </small>
                    </div>

                    <div>
                        <label class="form-label small fw-bold text-secondary">Leave Reason / Description</label>
                        <input type="text" name="leave_reason" class="form-control" placeholder="e.g. Approved Annual Leave, NHS Seminar, Sickness">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm w-100">
                            <i class="bi bi-calendar-plus me-1"></i> Add Leave & Update Availability
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Leaves Table -->
            <div class="col-lg-7">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-calendar2-range text-secondary me-1"></i> Scheduled Leaves & Blackout Dates
                </h6>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-secondary">
                            <tr>
                                <th>Date</th>
                                <th>Session Coverage</th>
                                <th>Reason / Note</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($leaves)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        <i class="bi bi-calendar-check text-success fs-3 d-block mb-1"></i>
                                        No upcoming leaves or blackout dates recorded for <?= htmlspecialchars($selectedDoctor['name']) ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($leaves as $l): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark small">
                                                <i class="bi bi-calendar-event text-danger me-1"></i>
                                                <?= htmlspecialchars(date('D, d M Y', strtotime($l['date']))) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                                $sess = $l['session'] ?? 'full_day';
                                                if ($sess === '1st_session') {
                                                    echo '<span class="badge bg-warning text-dark rounded-pill px-2 py-1"><i class="bi bi-sun me-1"></i> 1st Session (Morning)</span>';
                                                } elseif ($sess === '2nd_session') {
                                                    echo '<span class="badge bg-info text-white rounded-pill px-2 py-1"><i class="bi bi-sunset me-1"></i> 2nd Session (Afternoon)</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger text-white rounded-pill px-2 py-1"><i class="bi bi-slash-circle me-1"></i> Full Day Off</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="small text-secondary"><?= htmlspecialchars($l['reason'] ?? 'Doctor Leave') ?></span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form action="<?= App::url('/admin/doctors/leave/' . urlencode($l['id']) . '/delete') ?>" method="POST" onsubmit="return confirm('Remove this leave exception?');" class="d-inline">
                                                <input type="hidden" name="doctor_id" value="<?= $docId ?>">
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Leave Actions">
                                                    <button type="submit" class="btn btn-outline-danger" title="Remove Leave">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clinician's Own Bookings Schedule Card -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar2-range text-success me-2"></i> Upcoming Patient Queue for <?= htmlspecialchars($selectedDoctor['name']) ?>
            </h6>
            <small class="text-muted">Total of <?= count($doctorBookings) ?> appointment(s) booked with this doctor.</small>
        </div>
        <a href="<?= App::url('/admin/bookings?doctor_id=' . $docId) ?>" class="btn btn-sm btn-outline-success rounded-pill">
            <i class="bi bi-box-arrow-up-right me-1"></i> Open in Master Roster
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-secondary">
                <tr>
                    <th class="ps-4">Reference</th>
                    <th>Patient Name & Contact</th>
                    <th>Notification</th>
                    <th>Treatment</th>
                    <th>Scheduled Slot</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($doctorBookings)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-check fs-2 d-block mb-1 text-secondary"></i>
                            No active bookings scheduled for <?= htmlspecialchars($selectedDoctor['name']) ?>.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($doctorBookings as $b): ?>
                        <tr>
                            <td class="ps-4 fw-bold font-monospace"><?= htmlspecialchars($b['reference']) ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($b['patient_name']) ?></div>
                                <div class="small text-muted"><i class="bi bi-telephone text-success"></i> <?= htmlspecialchars($b['patient_phone']) ?></div>
                            </td>
                            <td>
                                <?php if (($b['notification_channel'] ?? 'whatsapp') === 'whatsapp'): ?>
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                    </span>
                                <?php elseif (($b['notification_channel'] ?? '') === 'email'): ?>
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-envelope me-1"></i> Email
                                    </span>
                                <?php else: ?>
                                    <span class="badge rounded-pill bg-purple-subtle text-purple border" style="background-color: #f3e8ff; color: #7e22ce;">
                                        <i class="bi bi-bell-fill me-1"></i> Both
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($b['treatment']) ?></td>
                            <td>
                                <div class="fw-bold text-dark small"><?= htmlspecialchars(date('D, d M Y', strtotime($b['appointment_date']))) ?></div>
                                <span class="badge bg-success-subtle text-success"><?= htmlspecialchars($b['appointment_time']) ?></span>
                            </td>
                            <td>
                                <?php
                                    $st = $b['status'] ?? 'pending';
                                    if ($st === 'confirmed') echo '<span class="badge bg-success">Confirmed</span>';
                                    elseif ($st === 'pending') echo '<span class="badge bg-warning text-dark">Pending</span>';
                                    elseif ($st === 'completed') echo '<span class="badge bg-info">Completed</span>';
                                    else echo '<span class="badge bg-danger">Cancelled</span>';
                                ?>
                            </td>
                            <td class="text-end pe-4">
                                <?php if (!empty($b['patient_phone'])): ?>
                                    <a class="btn btn-sm btn-outline-success rounded-pill" target="_blank" 
                                       href="https://wa.me/<?= preg_replace('/\D/', '', $b['patient_phone']) ?>?text=<?= urlencode("Hello {$b['patient_name']}, regarding your appointment at Acocks Green Dental Practice...") ?>">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
