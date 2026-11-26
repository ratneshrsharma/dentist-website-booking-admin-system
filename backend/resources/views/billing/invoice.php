<?php

use App\Core\App;

$inv = $invoice ?? [];
$branding = $theme['branding'] ?? [];
$clinicName = $branding['clinic_name'] ?? 'Acocks Green Dental Practice';
$isVerified = !empty($isVerified);
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice <?= htmlspecialchars($inv['invoice_no'] ?? '') ?> — <?= htmlspecialchars($clinicName) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f2fcf5; font-family: system-ui, -apple-system, sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff; }
            .card { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        }
    </style>
</head>
<body class="py-5 px-3">
    <div class="container" style="max-width: 820px;">
        <?php if (!$isVerified): ?>
            <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 460px;">
                <div class="card-body p-4 text-center">
                    <div class="mb-3"><i class="bi bi-shield-lock-fill text-success fs-1"></i></div>
                    <h4 class="fw-bold mb-1">Protected Patient Invoice</h4>
                    <p class="text-muted small mb-4">
                        Invoice <code><?= htmlspecialchars($inv['invoice_no'] ?? '') ?></code><br>
                        Please enter your registered <strong>mobile number</strong> as the password to view and print.
                    </p>
                    <?php if ($error): ?>
                        <div class="alert alert-danger small py-2"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="POST" action="<?= App::url('/billing/invoice/' . urlencode((string) ($inv['invoice_no'] ?? ''))) ?>">
                        <input type="text" name="mobile_password" class="form-control mb-3 text-center" placeholder="Enter your mobile number" required autofocus>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Unlock &amp; View Invoice</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-3 no-print">
                <span class="badge bg-success-subtle text-success px-3 py-2"><i class="bi bi-check-circle me-1"></i> Verified Patient View</span>
                <div class="d-flex gap-2">
                    <button type="button" onclick="window.print()" class="btn btn-outline-dark btn-sm px-3">
                        <i class="bi bi-printer me-1"></i> Print Invoice
                    </button>
                    <a href="<?= App::url('/billing/invoice/' . urlencode((string) ($inv['invoice_no'] ?? '')) . '/pdf') ?>" target="_blank" class="btn btn-success btn-sm px-3">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="p-4 text-white" style="background: #0d631b;">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h3 class="fw-bold mb-1"><?= htmlspecialchars($clinicName) ?></h3>
                            <div class="small opacity-75"><?= htmlspecialchars($branding['address'] ?? '1078 Warwick Road, Birmingham B27 6BH') ?></div>
                            <div class="small opacity-75">Tel: <?= htmlspecialchars($branding['phone'] ?? '+44 121 765 2870') ?> | <?= htmlspecialchars($branding['email'] ?? 'reception@acocksgreendental.co.uk') ?></div>
                        </div>
                        <div class="text-md-end">
                            <div class="small text-uppercase opacity-75">Clinical Invoice</div>
                            <h4 class="fw-bold mb-0"><?= htmlspecialchars($inv['invoice_no'] ?? '') ?></h4>
                            <div class="small">Date: <?= htmlspecialchars($inv['invoice_date'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="small text-muted text-uppercase fw-bold">Billed To</div>
                            <div class="fw-bold fs-5"><?= htmlspecialchars($inv['patient_name'] ?? '') ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($inv['patient_phone'] ?? '') ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($inv['patient_email'] ?? '') ?></div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="small text-muted text-uppercase fw-bold">Payment Status</div>
                            <span class="badge fs-6 <?= ($inv['payment_status'] ?? '') === 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                <?= htmlspecialchars($inv['payment_status'] ?? 'Paid') ?>
                            </span>
                            <div class="small text-muted mt-1">Method: <?= htmlspecialchars($inv['payment_method'] ?? 'Card') ?></div>
                        </div>
                    </div>

                    <table class="table table-bordered align-middle mb-4">
                        <thead class="table-light">
                            <tr><th>Treatment / Clinical Service</th><th class="text-end" style="width: 150px;">Amount</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach (($inv['items'] ?? [['description' => $inv['treatment'] ?? 'Treatment', 'amount' => $inv['total_amount'] ?? 0]]) as $it): ?>
                                <tr>
                                    <td><?= htmlspecialchars($it['description'] ?? '') ?></td>
                                    <td class="text-end fw-semibold">£<?= number_format((float) ($it['amount'] ?? 0), 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr><th class="text-end">Total Amount</th><th class="text-end">£<?= number_format((float) ($inv['total_amount'] ?? 0), 2) ?></th></tr>
                            <tr><th class="text-end text-success">Amount Paid</th><th class="text-end text-success">£<?= number_format((float) ($inv['paid_amount'] ?? 0), 2) ?></th></tr>
                            <tr><th class="text-end text-danger">Balance Due</th><th class="text-end text-danger">£<?= number_format(max(0, (float) ($inv['total_amount'] ?? 0) - (float) ($inv['paid_amount'] ?? 0)), 2) ?></th></tr>
                        </tfoot>
                    </table>

                    <?php if (!empty($inv['notes'])): ?>
                        <div class="p-3 bg-light rounded-3 small text-muted">
                            <strong>Notes:</strong> <?= htmlspecialchars($inv['notes']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
