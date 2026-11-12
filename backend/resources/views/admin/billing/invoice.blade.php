<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Invoice <?= htmlspecialchars($invoice['id'] ?? 'INV-2026-0891') ?> - Advanced Dental Clinic</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap 5.3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        :root {
            --app-primary: #0D9488;
            --app-primary-dark: #0F766E;
            --app-dark: #0F172A;
            --app-surface: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #F1F5F9;
            color: #1E293B;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .invoice-card {
            max-width: 860px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            border: 1px solid #E2E8F0;
            overflow: hidden;
        }

        .invoice-header-strip {
            background: linear-gradient(135deg, #0F172A 0%, #0D9488 100%);
            padding: 2rem 2.5rem;
            color: #FFFFFF;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .badge-paid-pill {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #86EFAC;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.45rem 1rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .invoice-body {
            padding: 2.5rem;
        }

        .meta-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748B;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .meta-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0F172A;
        }

        .table-invoice th {
            background-color: #F8FAFC;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            font-weight: 700;
            padding: 0.85rem 1rem;
            border-top: 1px solid #E2E8F0;
            border-bottom: 1px solid #CBD5E1;
        }

        .table-invoice td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.925rem;
        }

        .amount-highlight {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0D9488;
        }

        .verification-box {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 0.75rem;
            padding: 1.25rem;
        }

        .action-bar {
            max-width: 860px;
            margin: 0 auto 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-teal {
            background-color: var(--app-primary);
            border-color: var(--app-primary);
            color: #FFFFFF;
            font-weight: 600;
        }
        .btn-teal:hover {
            background-color: var(--app-primary-dark);
            border-color: var(--app-primary-dark);
            color: #FFFFFF;
        }

        /* Print Layout Rules */
        @media print {
            body {
                background: #FFFFFF !important;
                padding: 0 !important;
                color: #000000 !important;
            }
            .action-bar, .no-print {
                display: none !important;
            }
            .invoice-card {
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
            }
            .invoice-header-strip {
                background: #0F172A !important;
                color: #FFFFFF !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 1.5rem !important;
            }
            .badge-paid-pill {
                border: 2px solid #15803D !important;
                color: #15803D !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .invoice-body {
                padding: 1.5rem 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Action Toolbar (Hidden during Print) -->
    <div class="action-bar no-print">
        <a href="<?= htmlspecialchars($home_url ?? '/advanced-dental-clinic/') ?>" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Patient Website
        </a>
        <div class="d-flex align-items-center gap-2">
            <a href="https://wa.me/919904379260?text=<?= urlencode('Hello Advanced Dental Support, I am inquiring about my invoice ' . ($invoice['id'] ?? 'INV-2026-0891')) ?>" target="_blank" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="bi bi-whatsapp me-1"></i>WhatsApp Clinical Care (+919904379260)
            </a>
            <button onclick="window.print()" class="btn btn-teal btn-sm shadow-sm">
                <i class="bi bi-printer me-1"></i>Print Official Tax Receipt / PDF
            </button>
        </div>
    </div>

    <!-- Main Printable Invoice Document -->
    <div class="invoice-card">
        <!-- Header Strip -->
        <div class="invoice-header-strip">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="brand-icon">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white tracking-tight">ADVANCED DENTAL CLINIC</h4>
                        <p class="text-white-50 small mb-0">Center for Restorative & Aesthetic Dental Surgery</p>
                        <small class="text-white-50" style="font-size: 0.75rem;">540 Madison Ave, New York, NY 10022 | (212) 555-0198</small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge-paid-pill">
                        <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($invoice['status'] ?? 'Paid in Full') ?>
                    </span>
                    <div class="mt-2 text-white-50 small" style="font-size: 0.75rem;">
                        VAT / TAX ID: <strong>US-DENT-884920</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            <!-- Metadata Grid -->
            <div class="row g-4 pb-4 border-bottom mb-4">
                <div class="col-6 col-md-3">
                    <div class="meta-label">Invoice Reference</div>
                    <div class="meta-value font-monospace text-primary"><?= htmlspecialchars($invoice['id'] ?? 'INV-2026-0891') ?></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="meta-label">Settlement Date</div>
                    <div class="meta-value"><?= htmlspecialchars($invoice['date'] ?? date('d M Y, H:i A')) ?></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="meta-label">Patient Name</div>
                    <div class="meta-value text-dark"><?= htmlspecialchars($invoice['patient'] ?? 'David Sample') ?></div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">MRN: <?= htmlspecialchars($invoice['mrn'] ?? 'MRN-2026-0001') ?></small>
                </div>
                <div class="col-6 col-md-3">
                    <div class="meta-label">Attending Clinician</div>
                    <div class="meta-value text-dark"><?= htmlspecialchars($invoice['doctor'] ?? 'Dr. Ethan Caldwell, DDS, FACP') ?></div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">Prosthodontics & Surgery</small>
                </div>
            </div>

            <!-- Treatment Items Table -->
            <div class="table-responsive mb-4">
                <table class="table table-invoice mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%;">Code</th>
                            <th style="width: 52%;">Clinical Procedure & Treatment Details</th>
                            <th style="width: 10%;" class="text-center">Qty</th>
                            <th style="width: 15%;" class="text-end">Unit Price</th>
                            <th style="width: 15%;" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($invoice['items'])): ?>
                            <?php foreach ($invoice['items'] as $item): ?>
                                <tr>
                                    <td class="font-monospace small text-muted"><?= htmlspecialchars($item['code']) ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($item['title']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($item['description'] ?? '') ?></small>
                                    </td>
                                    <td class="text-center fw-semibold"><?= htmlspecialchars($item['qty']) ?></td>
                                    <td class="text-end text-secondary">£<?= number_format((float)$item['unit_price'], 2) ?></td>
                                    <td class="text-end fw-bold text-dark">£<?= number_format((float)$item['total'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="font-monospace small text-muted">D6010</td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($invoice['procedure'] ?? 'Guided Implant Surgical Placement (#19)') ?></div>
                                    <small class="text-muted">Precision 3D CBCT-guided surgical osteotomy and Straumann BLX Titanium implant fixture</small>
                                </td>
                                <td class="text-center fw-semibold">1</td>
                                <td class="text-end text-secondary">£1,250.00</td>
                                <td class="text-end fw-bold text-dark">£1,250.00</td>
                            </tr>
                            <tr>
                                <td class="font-monospace small text-muted">D7953</td>
                                <td>
                                    <div class="fw-bold text-dark">Bone Replacement Graft for Ridge Preservation</div>
                                    <small class="text-muted">Bio-Oss collagen osteoinductive graft material and Bio-Gide resorbable barrier membrane</small>
                                </td>
                                <td class="text-center fw-semibold">1</td>
                                <td class="text-end text-secondary">£400.00</td>
                                <td class="text-end fw-bold text-dark">£400.00</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary Box -->
            <div class="row g-4 align-items-center pb-4 border-bottom mb-4">
                <div class="col-md-7">
                    <div class="p-3 bg-light rounded-3">
                        <div class="small fw-bold text-dark mb-1"><i class="bi bi-shield-check text-success me-1"></i>Settlement & Tender Information</div>
                        <div class="small text-secondary mb-1">Payment Method: <strong><?= htmlspecialchars($invoice['method'] ?? 'Visa Card POS') ?></strong></div>
                        <div class="small text-secondary mb-1">Transaction Ref: <strong class="font-monospace">TXN-84920-<?= htmlspecialchars($invoice['id'] ?? '891') ?></strong></div>
                        <div class="small text-secondary">Authorized By: <strong>Clinical Finance Desk (Terminal #04)</strong></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-flex justify-content-between py-1 border-bottom small">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-semibold text-dark">£<?= number_format((float)($invoice['amount'] ?? 1650.00), 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom small">
                        <span class="text-muted">Medical VAT (Exempt):</span>
                        <span class="fw-semibold text-success">£0.00</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 align-items-center">
                        <span class="fw-bold text-dark fs-6">Amount Settled:</span>
                        <span class="amount-highlight">£<?= number_format((float)($invoice['amount'] ?? 1650.00), 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-1 small text-muted">
                        <span>Balance Remaining:</span>
                        <span class="fw-bold text-success">£0.00 (Settled in Full)</span>
                    </div>
                </div>
            </div>

            <!-- Clinical Care & Post-Procedure Care Notes -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="border rounded-3 p-3 bg-white">
                        <h6 class="fw-bold text-dark mb-1 small text-uppercase tracking-wider">
                            <i class="bi bi-info-circle-fill text-primary me-1"></i>Post-Procedure Instructions & Aftercare
                        </h6>
                        <p class="small text-secondary mb-0">
                            Maintain a soft-food diet for 48 hours post-surgical intervention. Refrain from vigorous rinsing or strenuous physical exercise today. For postoperative discomfort or prescription guidance, contact our 24/7 clinical team on WhatsApp at <strong>+919904379260</strong>.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="verification-box text-center">
                        <i class="bi bi-patch-check-fill text-success fs-3 d-block mb-1"></i>
                        <span class="fw-bold text-dark small d-block">Clinically Verified & Audited</span>
                        <small class="text-muted font-monospace" style="font-size: 0.65rem;">HASH: SHA256-DENT-<?= md5($invoice['id'] ?? 'INV-2026-0891') ?></small>
                    </div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div class="text-center pt-3 border-top text-muted small" style="font-size: 0.75rem;">
                <p class="mb-1">Thank you for placing your trust in Advanced Dental Clinic. Keep this electronic document for tax deduction and dental insurance claims.</p>
                <p class="mb-0">Advanced Dental Practice Management System &copy; <?= date('Y') ?> | Official Clinical Receipt</p>
            </div>
        </div>
    </div>

</body>
</html>
