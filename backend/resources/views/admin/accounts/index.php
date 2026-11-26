<?php

use App\Core\App;

$invoices = $invoices ?? [];
$stats = $stats ?? ['count' => 0, 'total_billed' => 0, 'total_paid' => 0, 'balance_due' => 0];
$statusFilter = $statusFilter ?? 'all';
$search = $search ?? '';
$patients = $patients ?? [];
$services = $services ?? [];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-receipt-cutoff text-success me-2"></i> Accounts &amp; Invoices
        </h3>
        <p class="text-muted small mb-0">
            Admin &amp; Accountant only. Generate on-the-fly PDFs (never stored on disk), share password-protected Web Invoices (password = patient mobile), or send via Email/WhatsApp.
        </p>
    </div>
    <button type="button" class="btn btn-brand btn-sm px-3" data-bs-toggle="collapse" data-bs-target="#createInvoiceBox">
        <i class="bi bi-plus-lg me-1"></i> Create New Invoice
    </button>
</div>

<!-- KPI Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Total Invoices</div><div class="fs-4 fw-bold text-dark"><?= (int) $stats['count'] ?></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Total Billed</div><div class="fs-4 fw-bold text-primary">£<?= number_format((float) $stats['total_billed'], 2) ?></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Total Collected</div><div class="fs-4 fw-bold text-success">£<?= number_format((float) $stats['total_paid'], 2) ?></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm p-3"><div class="small text-muted">Outstanding Balance</div><div class="fs-4 fw-bold text-danger">£<?= number_format((float) $stats['balance_due'], 2) ?></div></div></div>
</div>

<!-- Create Invoice Collapse Form -->
<div class="collapse mb-4" id="createInvoiceBox">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0">Generate Clinical Invoice</h6></div>
        <div class="card-body p-4">
            <form method="POST" action="<?= App::url('/admin/accounts/create') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Select Registered Patient (Optional)</label>
                        <select name="patient_key" class="form-select form-select-sm">
                            <option value="">-- Or Enter Walk-in Details --</option>
                            <?php foreach ($patients as $pt): ?>
                                <option value="<?= htmlspecialchars($pt['patient_key']) ?>"><?= htmlspecialchars($pt['name'] . ' (' . $pt['phone'] . ')') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Patient Name</label>
                        <input type="text" name="patient_name" class="form-control form-control-sm" placeholder="If walk-in">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Patient Mobile (Invoice Password)</label>
                        <input type="text" name="patient_phone" class="form-control form-control-sm" placeholder="+44 7700 900123">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="patient_email" class="form-control form-control-sm" placeholder="Optional">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Treatment / Service *</label>
                        <select name="treatment" class="form-select form-select-sm" required>
                            <?php foreach ($services as $sv): ?>
                                <option value="<?= htmlspecialchars($sv['title']) ?>"><?= htmlspecialchars($sv['title'] . ' (' . $sv['starting_price'] . ')') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Total (£) *</label>
                        <input type="number" step="0.01" name="total_amount" class="form-control form-control-sm" required value="65.00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Paid (£) *</label>
                        <input type="number" step="0.01" name="paid_amount" class="form-control form-control-sm" required value="65.00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Method</label>
                        <select name="payment_method" class="form-select form-select-sm">
                            <option value="Card">Card</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="NHS">NHS</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="invoice_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-12">
                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="Invoice notes...">
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-brand btn-sm px-4">Create Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Filter & Table -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex gap-2">
            <?php foreach (['all' => 'All', 'Paid' => 'Paid', 'Partial' => 'Partial', 'Unpaid' => 'Unpaid'] as $k => $lbl): ?>
                <a href="<?= App::url('/admin/accounts?status=' . urlencode($k)) ?>" class="btn btn-sm <?= $statusFilter === $k ? 'btn-dark' : 'btn-outline-secondary' ?>"><?= $lbl ?></a>
            <?php endforeach; ?>
        </div>
        <form method="GET" action="<?= App::url('/admin/accounts') ?>" class="d-flex gap-2">
            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control form-control-sm" placeholder="Search invoice no, patient...">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Invoice No &amp; Date</th>
                    <th>Patient</th>
                    <th>Treatment</th>
                    <th>Total / Paid</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 210px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $inv):
                    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                    $webUrl = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . App::url('/billing/invoice/' . $inv['invoice_no']);
                    $waDigits = preg_replace('/[^0-9]/', '', (string) ($inv['patient_phone'] ?? ''));
                    $waLink = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Hello {$inv['patient_name']}, view & print your invoice {$inv['invoice_no']} (£" . number_format((float)$inv['total_amount'], 2) . ") here: {$webUrl} (Password: your mobile number)");
                ?>
                    <tr>
                        <td>
                            <code class="fw-bold"><?= htmlspecialchars($inv['invoice_no']) ?></code>
                            <div class="small text-muted"><?= htmlspecialchars($inv['invoice_date']) ?></div>
                        </td>
                        <td class="small">
                            <div class="fw-bold"><?= htmlspecialchars($inv['patient_name']) ?></div>
                            <div class="text-muted"><?= htmlspecialchars($inv['patient_phone']) ?></div>
                        </td>
                        <td class="small"><?= htmlspecialchars($inv['treatment']) ?></td>
                        <td class="small">
                            <strong>£<?= number_format((float) $inv['total_amount'], 2) ?></strong>
                            <div class="text-success">Paid: £<?= number_format((float) $inv['paid_amount'], 2) ?> (<?= htmlspecialchars($inv['payment_method']) ?>)</div>
                        </td>
                        <td>
                            <span class="badge <?= $inv['payment_status'] === 'Paid' ? 'bg-success' : ($inv['payment_status'] === 'Partial' ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                <?= htmlspecialchars($inv['payment_status']) ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="<?= App::url('/billing/invoice/' . $inv['invoice_no']) ?>" target="_blank" class="btn btn-outline-secondary" title="Web View (Password: Mobile)"><i class="bi bi-globe"></i></a>
                                <a href="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/pdf') ?>" target="_blank" class="btn btn-outline-danger" title="On-the-Fly PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                <?php if (!empty($inv['patient_email'])): ?>
                                    <form method="POST" action="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/send-email') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-outline-primary btn-sm" title="Send via Email"><i class="bi bi-envelope"></i></button>
                                    </form>
                                <?php endif; ?>
                                <a href="<?= htmlspecialchars($waLink) ?>" target="_blank" class="btn btn-outline-success" title="Send via WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                <?php if ($inv['payment_status'] !== 'Paid'): ?>
                                    <form method="POST" action="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/mark-paid') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-outline-success btn-sm" title="Mark Paid"><i class="bi bi-check2"></i></button>
                                    </form>
                                <?php endif; ?>
                                <form method="POST" action="<?= App::url('/admin/accounts/invoice/' . $inv['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this invoice?');">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
