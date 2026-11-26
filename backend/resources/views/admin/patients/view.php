<?php

use App\Core\App;

$p = $patient ?? [];
$st = $p['stats'] ?? [];
$pKey = $p['patient_key'] ?? '';
$bookings = $p['bookings'] ?? [];
$invoices = $p['invoices'] ?? [];
$treatments = $p['treatment_records'] ?? [];
$services = $services ?? [];
$doctors = $doctors ?? [];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= App::url('/admin/patients') ?>" class="text-decoration-none">Patients</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($p['name'] ?? '') ?></li>
            </ol>
        </nav>
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-person-vcard-fill text-success me-2"></i> <?= htmlspecialchars($p['name'] ?? '') ?>
            <code class="fs-6 ms-2"><?= htmlspecialchars($pKey) ?></code>
        </h3>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= App::url('/admin/patients/' . urlencode($pKey) . '/edit') ?>" class="btn btn-outline-primary btn-sm px-3">
            <i class="bi bi-pencil-square me-1"></i> Edit Patient
        </a>
        <a href="<?= App::url('/admin/patients') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<!-- KPI Summary Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Visits Completed</div><div class="fs-4 fw-bold text-success"><?= (int) ($st['visits_completed'] ?? 0) ?></div></div></div>
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Fixed / Confirmed</div><div class="fs-4 fw-bold text-primary"><?= (int) ($st['confirmed'] ?? 0) ?></div></div></div>
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Rescheduled</div><div class="fs-4 fw-bold text-warning"><?= (int) ($st['rescheduled'] ?? 0) ?></div></div></div>
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Cancelled</div><div class="fs-4 fw-bold text-danger"><?= (int) ($st['cancelled'] ?? 0) ?></div></div></div>
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Total Paid</div><div class="fs-4 fw-bold text-success">£<?= number_format((float) ($st['total_paid'] ?? 0), 2) ?></div></div></div>
    <div class="col-6 col-md-2"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Balance Due</div><div class="fs-4 fw-bold text-danger">£<?= number_format((float) ($st['balance_due'] ?? 0), 2) ?></div></div></div>
</div>

<div class="row g-4">
    <!-- Left: Patient Profile + Add Treatment -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0">Contact &amp; Clinical Details</h6></div>
            <div class="card-body small d-flex flex-column gap-2">
                <div><strong>Mobile:</strong> <?= htmlspecialchars($p['phone'] ?? '—') ?></div>
                <div><strong>Email:</strong> <?= htmlspecialchars($p['email'] ?: '—') ?></div>
                <div><strong>DOB:</strong> <?= htmlspecialchars($p['dob'] ?: '—') ?></div>
                <div><strong>Address:</strong> <?= htmlspecialchars($p['address'] ?: '—') ?></div>
                <div><strong>Notes:</strong><br><span class="text-muted"><?= nl2br(htmlspecialchars($p['clinical_notes'] ?: 'None')) ?></span></div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-plus-circle text-success me-1"></i> Log Treatment / Service Note</h6></div>
            <div class="card-body">
                <form method="POST" action="<?= App::url('/admin/patients/' . urlencode($pKey) . '/treatment') ?>" class="d-flex flex-column gap-2">
                    <input type="date" name="date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" required>
                    <select name="service" class="form-select form-select-sm">
                        <?php foreach ($services as $s): ?>
                            <option value="<?= htmlspecialchars($s['title']) ?>"><?= htmlspecialchars($s['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="doctor" class="form-select form-select-sm">
                        <?php foreach ($doctors as $d): ?>
                            <option value="<?= htmlspecialchars($d['name']) ?>"><?= htmlspecialchars($d['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" step="0.01" name="fee" class="form-control form-control-sm" placeholder="Fee (£)">
                    <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Clinical treatment notes..."></textarea>
                    <button type="submit" class="btn btn-brand btn-sm mt-1">Add Treatment Record</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Treatments History, Appointments & Invoices -->
    <div class="col-lg-8">
        <!-- Treatments Taken -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0">Treatments &amp; Services Taken</h6></div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light"><tr><th>Date</th><th>Service</th><th>Clinician</th><th>Fee</th><th>Notes</th></tr></thead>
                    <tbody>
                        <?php if (empty($treatments)): ?>
                            <tr><td colspan="5" class="text-center py-3 text-muted small">No logged treatment notes yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($treatments as $tr): ?>
                                <tr class="small">
                                    <td><?= htmlspecialchars($tr['date'] ?? '') ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($tr['service'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($tr['doctor'] ?? '') ?></td>
                                    <td>£<?= number_format((float) ($tr['fee'] ?? 0), 2) ?></td>
                                    <td class="text-muted"><?= htmlspecialchars($tr['notes'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patient Invoices -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Patient Invoices (Web View, On-the-Fly PDF &amp; Send)</h6>
                <?php if (!empty($canAccessAccounts)): ?>
                    <a href="<?= App::url('/admin/accounts') ?>" class="btn btn-outline-success btn-sm">Manage in Accounts</a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light"><tr><th>Invoice No</th><th>Date</th><th>Treatment</th><th>Total / Paid</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        <?php if (empty($invoices)): ?>
                            <tr><td colspan="6" class="text-center py-3 text-muted small">No invoices for this patient yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($invoices as $inv):
                                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                                $webUrl = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . App::url('/billing/invoice/' . $inv['invoice_no']);
                                $waDigits = preg_replace('/[^0-9]/', '', (string) ($inv['patient_phone'] ?? ''));
                                $waLink = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Hello {$inv['patient_name']}, view your invoice {$inv['invoice_no']} (£" . number_format((float)$inv['total_amount'], 2) . ") here: {$webUrl} (Password: your mobile number)");
                            ?>
                                <tr class="small">
                                    <td><code><?= htmlspecialchars($inv['invoice_no']) ?></code></td>
                                    <td><?= htmlspecialchars($inv['invoice_date']) ?></td>
                                    <td><?= htmlspecialchars($inv['treatment']) ?></td>
                                    <td>£<?= number_format((float) $inv['total_amount'], 2) ?> / <strong class="text-success">£<?= number_format((float) $inv['paid_amount'], 2) ?></strong></td>
                                    <td><span class="badge <?= $inv['payment_status'] === 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= htmlspecialchars($inv['payment_status']) ?></span></td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= App::url('/billing/invoice/' . $inv['invoice_no']) ?>" target="_blank" class="btn btn-outline-secondary" title="Web View (Password: Mobile)"><i class="bi bi-globe"></i></a>
                                            <a href="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/pdf') ?>" target="_blank" class="btn btn-outline-danger" title="Generate On-the-Fly PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                            <?php if (!empty($inv['patient_email'])): ?>
                                                <form method="POST" action="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/send-email') ?>" class="d-inline">
                                                    <input type="hidden" name="return_to" value="/admin/patients/<?= htmlspecialchars($pKey) ?>">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm" title="Send Invoice to Email"><i class="bi bi-envelope"></i></button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="<?= htmlspecialchars($waLink) ?>" target="_blank" class="btn btn-outline-success" title="Send on WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Linked Appointments -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0">Appointment History (<?= count($bookings) ?>)</h6></div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light"><tr><th>Ref</th><th>Date &amp; Time</th><th>Treatment</th><th>Clinician</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr><td colspan="5" class="text-center py-3 text-muted small">No linked appointments found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $b): ?>
                                <tr class="small">
                                    <td><code><?= htmlspecialchars($b['reference'] ?? '') ?></code></td>
                                    <td><?= htmlspecialchars(($b['appointment_date'] ?? '') . ' ' . ($b['appointment_time'] ?? '')) ?></td>
                                    <td><?= htmlspecialchars($b['treatment'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($b['doctor_name'] ?? '') ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($b['status'] ?? '') ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
