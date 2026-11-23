@extends('layouts.admin')

@section('title', 'Billing, Invoices & POS - Advanced Dental PRO')
@section('page_title', 'Billing, Invoices & POS')
@section('page_subtitle', 'Patient ledger, insurance claims processing, advance deposits, partial payments, and refund/void audit trail')

@section('page_actions')
<div class="d-flex align-items-center gap-2">
    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" onclick="filterBillingTab('outstanding')">
        <i class="bi bi-clock-history me-1"></i> Outstanding Balances
    </button>
    <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#newInvoiceModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
        <i class="bi bi-plus-circle me-1"></i> New POS Invoice
    </button>
</div>
@endsection

@section('content')
<!-- Feedback Toast Alert Placeholder -->
<div id="billingAlertPlaceholder" class="mb-3"></div>

<!-- Top Statistics Cards (shadcn-ui tokens) -->
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Today's Collections</span>
                <div class="stat-value text-success" id="statTodayCollections">£4,850.00</div>
                <span class="badge bg-success-subtle text-success stat-meta" id="statSettledCount">
                    <i class="bi bi-receipt me-1"></i> 6 settled invoices
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-success">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Advance Deposits Held</span>
                <div class="stat-value text-warning" id="statAdvanceDeposits">£1,520.00</div>
                <span class="badge bg-warning-subtle text-warning stat-meta">
                    <i class="bi bi-shield-check me-1"></i> Escrowed surgical prep
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-warning">
                <i class="bi bi-piggy-bank-fill"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Accounts Receivable (Due)</span>
                <div class="stat-value text-danger" id="statAccountsReceivable">£1,590.00</div>
                <span class="badge bg-danger-subtle text-danger stat-meta">
                    <i class="bi bi-exclamation-circle me-1"></i> 3 active patient balances
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Refunds & Voids Audited</span>
                <div class="stat-value text-secondary" id="statRefundsAudited">£420.00</div>
                <span class="badge bg-secondary-subtle text-secondary stat-meta">
                    <i class="bi bi-shield-lock me-1"></i> 2 clinical audit records
                </span>
            </div>
            <div class="stat-icon-wrapper stat-icon-info">
                <i class="bi bi-arrow-counterclockwise"></i>
            </div>
        </div>
    </div>
</div>

<!-- Invoices Ledger Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Clinical Invoices & Point-of-Sale (POS) Ledger</h5>
            <span class="text-muted small">Multi-tender checkout, advance deposits, partial installments, and refund/void audit trails</span>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-group btn-group-sm" role="group" aria-label="Ledger Tabs">
                <button type="button" class="btn btn-outline-secondary active" id="tabBtnAll" onclick="filterBillingTab('all')">All Invoices (7)</button>
                <button type="button" class="btn btn-outline-secondary" id="tabBtnOutstanding" onclick="filterBillingTab('outstanding')">Outstanding (3)</button>
                <button type="button" class="btn btn-outline-secondary" id="tabBtnDeposits" onclick="filterBillingTab('deposits')">Deposits (3)</button>
                <button type="button" class="btn btn-outline-secondary" id="tabBtnRefunds" onclick="filterBillingTab('refunds')">Refunds/Voids (2)</button>
            </div>
            <div class="input-group input-group-sm" style="max-width: 240px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="billingSearchInput" onkeyup="filterBillingTable()" placeholder="Search invoice #, patient...">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="billingTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3 text-nowrap" style="width: 11%; min-width: 120px;">Invoice #</th>
                        <th class="text-nowrap" style="width: 15%; min-width: 150px;">Patient & MRN</th>
                        <th style="width: 20%; min-width: 190px;">Clinical Procedure</th>
                        <th class="text-nowrap" style="width: 12%; min-width: 130px;">Treating Doctor</th>
                        <th class="text-nowrap" style="width: 8%; min-width: 95px;">Total Fee</th>
                        <th class="text-nowrap" style="width: 10%; min-width: 105px;">Paid / Deposit</th>
                        <th class="text-nowrap" style="width: 9%; min-width: 95px;">Balance Due</th>
                        <th class="text-nowrap" style="width: 8%; min-width: 95px;">Status</th>
                        <th class="text-nowrap" style="width: 8%; min-width: 90px;">Date</th>
                        <th class="text-end pe-3 text-nowrap" style="width: 12%; min-width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="billingTableBody">
                    <!-- Row 1 -->
                    <tr id="inv-row-891" data-id="INV-2026-0891" data-patient="David Sample" data-mrn="MRN-2026-0001" data-procedure="Guided Implant Surgical Placement (#19)" data-doctor="Dr. Ethan Caldwell, DDS, FACP" data-total="1650.00" data-deposit="500.00" data-paid="1150.00" data-balance="500.00" data-method="Visa Card POS" data-status="partial" data-type="outstanding" data-date="21 Mar 2026, 11:30 AM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0891')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0891
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">David Sample</span>
                            <small class="text-muted">MRN-2026-0001</small>
                        </td>
                        <td>Guided Implant Surgical Placement (#19)</td>
                        <td><span class="fw-semibold text-dark">Dr. Ethan Caldwell</span></td>
                        <td><span class="fw-bold text-dark">£1,650.00</span></td>
                        <td>
                            <span class="fw-semibold text-success">£1,150.00</span>
                            <small class="text-muted d-block" style="font-size: 0.72rem;">Dep: £500.00</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning fw-bold">£500.00 Due</span></td>
                        <td><span class="badge bg-warning-subtle text-warning">Partial Paid</span></td>
                        <td><span class="small text-muted">21 Mar, 11:30</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0891')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('INV-2026-0891')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-891')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-891')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('INV-2026-0891')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr id="inv-row-890" data-id="INV-2026-0890" data-patient="Emma Jenkins" data-mrn="MRN-2026-0042" data-procedure="Clear Aligner Monthly Refinement (Tray 8)" data-doctor="Dr. Maya Lin, DDS" data-total="280.00" data-deposit="280.00" data-paid="280.00" data-balance="0.00" data-method="Direct Debit" data-status="paid" data-type="deposit" data-date="21 Mar 2026, 09:45 AM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0890')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0890
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">Emma Jenkins</span>
                            <small class="text-muted">MRN-2026-0042</small>
                        </td>
                        <td>Clear Aligner Monthly Refinement (Tray 8)</td>
                        <td><span class="fw-semibold text-dark">Dr. Maya Lin</span></td>
                        <td><span class="fw-bold text-dark">£280.00</span></td>
                        <td>
                            <span class="fw-semibold text-success">£280.00</span>
                            <small class="text-muted d-block" style="font-size: 0.72rem;">Dep: £280.00</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">£0.00</span></td>
                        <td><span class="badge bg-success-subtle text-success">Paid in Full</span></td>
                        <td><span class="small text-muted">21 Mar, 09:45</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0890')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('INV-2026-0890')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-890')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-890')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('INV-2026-0890')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr id="inv-row-889" data-id="INV-2026-0889" data-patient="Michael Brown" data-mrn="MRN-2026-0098" data-procedure="Molar Endodontic Therapy & Core Build-Up" data-doctor="Dr. Marcus Vance, DMD" data-total="950.00" data-deposit="200.00" data-paid="200.00" data-balance="750.00" data-method="Dental Net Ins. Copay" data-status="insurance_pending" data-type="outstanding" data-date="20 Mar 2026, 16:15 PM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0889')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0889
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">Michael Brown</span>
                            <small class="text-muted">MRN-2026-0098</small>
                        </td>
                        <td>Molar Endodontic Therapy & Core Build-Up</td>
                        <td><span class="fw-semibold text-dark">Dr. Marcus Vance</span></td>
                        <td><span class="fw-bold text-dark">£950.00</span></td>
                        <td>
                            <span class="fw-semibold text-success">£200.00</span>
                            <small class="text-muted d-block" style="font-size: 0.72rem;">Copay: £200.00</small>
                        </td>
                        <td><span class="badge bg-danger-subtle text-danger fw-bold">£750.00 Due</span></td>
                        <td><span class="badge bg-info-subtle text-info">Insurance Pending</span></td>
                        <td><span class="small text-muted">20 Mar, 16:15</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0889')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('INV-2026-0889')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-889')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-889')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('INV-2026-0889')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr id="inv-row-888" data-id="INV-2026-0888" data-patient="Sophia Rodriguez" data-mrn="MRN-2026-0112" data-procedure="Full Mouth Ultrasonic Debridement & Polish" data-doctor="Dr. Ethan Caldwell, DDS" data-total="120.00" data-deposit="0.00" data-paid="120.00" data-balance="0.00" data-method="Apple Pay Contactless" data-status="paid" data-type="all" data-date="20 Mar 2026, 14:00 PM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0888')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0888
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">Sophia Rodriguez</span>
                            <small class="text-muted">MRN-2026-0112</small>
                        </td>
                        <td>Full Mouth Ultrasonic Debridement & Polish</td>
                        <td><span class="fw-semibold text-dark">Dr. Ethan Caldwell</span></td>
                        <td><span class="fw-bold text-dark">£120.00</span></td>
                        <td>
                            <span class="fw-semibold text-success">£120.00</span>
                            <small class="text-muted d-block" style="font-size: 0.72rem;">POS: £120.00</small>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">£0.00</span></td>
                        <td><span class="badge bg-success-subtle text-success">Paid in Full</span></td>
                        <td><span class="small text-muted">20 Mar, 14:00</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0888')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('INV-2026-0888')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-888')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-888')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('INV-2026-0888')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr id="inv-row-887" data-id="INV-2026-0887" data-patient="James Wilson" data-mrn="MRN-2026-0145" data-procedure="Ceramic Crown Preparation & CAD/CAM Scan (#14)" data-doctor="Dr. Maya Lin, DDS" data-total="680.00" data-deposit="340.00" data-paid="340.00" data-balance="340.00" data-method="Mastercard POS" data-status="partial" data-type="deposit" data-date="19 Mar 2026, 11:15 AM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0887')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0887
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">James Wilson</span>
                            <small class="text-muted">MRN-2026-0145</small>
                        </td>
                        <td>Ceramic Crown Preparation & CAD/CAM Scan (#14)</td>
                        <td><span class="fw-semibold text-dark">Dr. Maya Lin</span></td>
                        <td><span class="fw-bold text-dark">£680.00</span></td>
                        <td>
                            <span class="fw-semibold text-success">£340.00</span>
                            <small class="text-muted d-block" style="font-size: 0.72rem;">Dep: £340.00</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning fw-bold">£340.00 Due</span></td>
                        <td><span class="badge bg-warning-subtle text-warning">Partial Paid</span></td>
                        <td><span class="small text-muted">19 Mar, 11:15</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0887')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('INV-2026-0887')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-887')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-887')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('INV-2026-0887')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 6 -->
                    <tr id="inv-row-886" data-id="INV-2026-0886" data-patient="Robert Taylor" data-mrn="MRN-2026-0204" data-procedure="Surgical Wisdom Tooth Extraction (#32)" data-doctor="Dr. Ethan Caldwell, DDS, FACP" data-total="420.00" data-deposit="420.00" data-paid="0.00" data-balance="0.00" data-method="Visa POS (Reversed)" data-status="refunded" data-type="refunds" data-date="18 Mar 2026, 15:45 PM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0886')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0886
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">Robert Taylor</span>
                            <small class="text-muted">MRN-2026-0204</small>
                        </td>
                        <td>Surgical Wisdom Tooth Extraction (#32)</td>
                        <td><span class="fw-semibold text-dark">Dr. Ethan Caldwell</span></td>
                        <td><span class="fw-bold text-dark">£420.00</span></td>
                        <td>
                            <span class="fw-semibold text-muted">£0.00</span>
                            <small class="text-danger d-block" style="font-size: 0.72rem;">Refunded</small>
                        </td>
                        <td><span class="badge bg-light text-dark">£0.00</span></td>
                        <td><span class="badge bg-danger-subtle text-danger">Refunded (£420)</span></td>
                        <td><span class="small text-muted">18 Mar, 15:45</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0886')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-886')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-886')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 7 -->
                    <tr id="inv-row-885" data-id="INV-2026-0885" data-patient="Clara Evans" data-mrn="MRN-2026-0189" data-procedure="In-Office Power Dental Bleaching" data-doctor="Dr. Marcus Vance, DMD" data-total="350.00" data-deposit="0.00" data-paid="0.00" data-balance="0.00" data-method="None / Voided" data-status="voided" data-type="refunds" data-date="17 Mar 2026, 16:30 PM">
                        <td class="ps-3">
                            <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('INV-2026-0885')" title="View Digital Invoice Preview">
                                <i class="bi bi-file-earmark-text me-1"></i>INV-2026-0885
                            </button>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">Clara Evans</span>
                            <small class="text-muted">MRN-2026-0189</small>
                        </td>
                        <td>In-Office Power Dental Bleaching</td>
                        <td><span class="fw-semibold text-dark">Dr. Marcus Vance</span></td>
                        <td><span class="fw-bold text-dark">£350.00</span></td>
                        <td>
                            <span class="fw-semibold text-muted">£0.00</span>
                            <small class="text-secondary d-block" style="font-size: 0.72rem;">Voided</small>
                        </td>
                        <td><span class="badge bg-light text-dark">£0.00</span></td>
                        <td><span class="badge bg-secondary-subtle text-secondary">Voided</span></td>
                        <td><span class="small text-muted">17 Mar, 16:30</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('INV-2026-0885')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-885')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-885')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 1: Digital Invoice Preview Modal (Senior Dev Feedback Item 6)     -->
<!-- ======================================================================= -->
<div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-labelledby="invoicePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #0F172A 0%, #0D9488 100%);">
                <h5 class="modal-title fw-bold" id="invoicePreviewModalLabel">
                    <i class="bi bi-file-earmark-medical me-2"></i>Official Digital Invoice Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light" id="invoicePreviewModalBody">
                <!-- Dynamically populated invoice document -->
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            <h4 class="fw-bold text-dark mb-0">ADVANCED DENTAL CLINIC</h4>
                            <small class="text-muted">540 Madison Ave, New York, NY 10022 | VAT: US-DENT-884920</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success fs-6 px-3 py-1.5" id="prevModalStatusBadge">Paid in Full</span>
                            <div class="small font-monospace text-muted mt-1" id="prevModalId">INV-2026-0891</div>
                        </div>
                    </div>
                    <div class="row g-3 small mb-4">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Patient Name & MRN:</span>
                            <strong class="text-dark fs-6" id="prevModalPatient">David Sample</strong>
                            <span class="text-muted d-block" id="prevModalMrn">MRN-2026-0001</span>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <span class="text-muted d-block">Issue Date & Time:</span>
                            <strong class="text-dark" id="prevModalDate">21 Mar 2026, 11:30 AM</strong>
                            <span class="text-muted d-block">Clinician: <strong class="text-dark" id="prevModalDoctor">Dr. Ethan Caldwell</strong></span>
                        </div>
                    </div>

                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Clinical Procedure Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="prevModalItemsTable">
                                <!-- Populated dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-3 align-items-center border-top pt-3">
                        <div class="col-md-7">
                            <div class="p-2 bg-light rounded small">
                                <div class="fw-bold text-dark mb-1"><i class="bi bi-shield-check text-success me-1"></i>Advance Deposits & Installments Ledger:</div>
                                <div id="prevModalPaymentsLedger">
                                    <!-- Populated dynamically -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between small py-1 border-bottom">
                                <span class="text-muted">Total Procedure Fee:</span>
                                <strong class="text-dark" id="prevModalTotalFee">£1,650.00</strong>
                            </div>
                            <div class="d-flex justify-content-between small py-1 border-bottom">
                                <span class="text-muted">Advance Deposit / Paid:</span>
                                <strong class="text-success" id="prevModalPaid">£1,150.00</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 align-items-center">
                                <span class="fw-bold text-dark">Net Balance Due:</span>
                                <strong class="text-danger fs-5" id="prevModalBalance">£500.00</strong>
                            </div>
                        </div>
                    </div>

                    <div id="prevModalRefundNoticeContainer" class="mt-3">
                        <!-- Populated if refunded or voided -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <a href="#" id="prevModalFullPageLink" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Open Full Page View
                </a>
                <button type="button" class="btn btn-primary btn-sm" onclick="window.print()" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-printer me-1"></i>Print Invoice / PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 2: Record Advance Deposit / Partial Payment                      -->
<!-- ======================================================================= -->
<div class="modal fade" id="partialPaymentModal" tabindex="-1" aria-labelledby="partialPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="partialPaymentModalLabel">
                    <i class="bi bi-credit-card-2-front text-success me-2"></i>Record Advance Deposit / Partial Installment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="partialPaymentForm" onsubmit="handleRecordPartialPayment(event)">
                <input type="hidden" id="payInvId">
                <div class="modal-body p-4">
                    <div class="p-3 bg-light rounded-3 mb-3 small">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Invoice Reference:</span>
                            <strong class="text-primary font-monospace" id="payInvRefDisplay">INV-2026-0891</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Patient Name:</span>
                            <strong class="text-dark" id="payPatientDisplay">David Sample</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Procedure Fee:</span>
                            <strong class="text-dark" id="payTotalFeeDisplay">£1,650.00</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Current Balance Due:</span>
                            <strong class="text-danger" id="payBalanceDueDisplay">£500.00</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Payment / Deposit Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="payTypeSelect">
                            <option value="Advance Surgery Booking Deposit">Advance Surgery Booking Deposit</option>
                            <option value="Stage Partial Payment / Installment">Stage Partial Payment / Installment</option>
                            <option value="Final Balance Settlement">Final Balance Settlement</option>
                            <option value="Dental Insurance Copay Settlement">Dental Insurance Copay Settlement</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Payment Amount (£) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">£</span>
                            <input type="number" step="0.01" class="form-control fw-bold" id="payAmountInput" required>
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Cannot exceed current outstanding balance due.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Tender Method <span class="text-danger">*</span></label>
                        <select class="form-select" id="payMethodSelect">
                            <option value="Visa / Mastercard POS">Visa / Mastercard POS</option>
                            <option value="Bank Transfer (BACS)">Bank Transfer (BACS)</option>
                            <option value="Cash Tender">Cash Tender</option>
                            <option value="Direct Debit">Direct Debit</option>
                            <option value="Apple / Google Pay">Apple / Google Pay</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Clinical / Financial Reference Note</label>
                        <input type="text" class="form-control" id="payRefNoteInput" placeholder="e.g. Cleared via Barclays Merchant Terminal #04">
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Process & Apply Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 3: Process Clinical Refund / Void with Mandatory Reason           -->
<!-- ======================================================================= -->
<div class="modal fade" id="refundVoidModal" tabindex="-1" aria-labelledby="refundVoidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title fw-bold" id="refundVoidModalLabel">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Process Clinical Refund / Void with Audit Reason
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="refundVoidForm" onsubmit="handleProcessRefundVoid(event)">
                <input type="hidden" id="rfInvId">
                <div class="modal-body p-4">
                    <div class="p-3 bg-light rounded-3 mb-3 small">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Invoice Reference:</span>
                            <strong class="text-danger font-monospace" id="rfInvRefDisplay">INV-2026-0891</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Patient Name:</span>
                            <strong class="text-dark" id="rfPatientDisplay">David Sample</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total Settled to Date:</span>
                            <strong class="text-success" id="rfTotalPaidDisplay">£1,150.00</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Reversal Action Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="rfActionType">
                            <option value="Full Clinical Refund & Reversal">Full Clinical Refund & Reversal</option>
                            <option value="Partial Clinical Procedure Refund">Partial Clinical Procedure Refund</option>
                            <option value="Administrative Invoice Void">Administrative Invoice Void (Zero Payment)</option>
                        </select>
                    </div>

                    <div class="mb-3" id="rfAmountGroup">
                        <label class="form-label fw-semibold small">Refund Amount (£) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">£</span>
                            <input type="number" step="0.01" class="form-control fw-bold" id="rfAmountInput" value="0.00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i>Mandatory Clinical Reason Category <span class="text-danger">*</span></label>
                        <select class="form-select border-danger" id="rfCategorySelect" required>
                            <option value="">-- Select Mandatory Clinical Rationale --</option>
                            <option value="Clinical procedure modified / downgraded during surgery">Clinical procedure modified / downgraded during surgery</option>
                            <option value="Patient medically unfit / deferred treatment">Patient medically unfit / deferred treatment</option>
                            <option value="Pre-paid implant / crown component cancelled">Pre-paid implant / crown component cancelled</option>
                            <option value="Insurance adjudication clawback / adjustment">Insurance adjudication clawback / adjustment</option>
                            <option value="Billing administrative calculation error">Billing administrative calculation error</option>
                            <option value="Patient relocation / hospital max-fac referral">Patient relocation / hospital max-fac referral</option>
                            <option value="Other clinical rationale (specified below)">Other clinical rationale (specified below)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Detailed Clinical Explanation & Notes <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rfReasonNotes" rows="3" placeholder="Provide precise clinical context required for GMC/GDC audit compliance (min 10 characters)..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Authorizing Clinician / Senior Staff</label>
                        <input type="text" class="form-control" id="rfAuthorizer" value="Dr. Ethan Caldwell, DDS, FACP (Lead Surgeon)">
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-shield-lock-fill me-1"></i>Confirm & Generate Audit Signature
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 4: Print Tax Receipt                                             -->
<!-- ======================================================================= -->
<div class="modal fade" id="printReceiptModal" tabindex="-1" aria-labelledby="printReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="printReceiptModalLabel">
                    <i class="bi bi-receipt-cutoff text-primary me-2"></i>Official Dental Tax Receipt
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="taxReceiptPrintArea">
                <div class="text-center pb-3 border-bottom mb-3">
                    <h5 class="fw-bold mb-0 text-dark">ADVANCED DENTAL CLINIC</h5>
                    <small class="text-muted d-block">Center for Comprehensive Restorative & Aesthetic Dentistry</small>
                    <small class="text-muted d-block">540 Madison Ave, New York, NY 10022 | (212) 555-0198</small>
                    <span class="badge bg-light text-dark border mt-2">VAT / TAX ID: US-DENT-884920</span>
                </div>
                <div class="row g-2 small mb-3">
                    <div class="col-6">
                        <span class="text-muted d-block">Invoice Reference:</span>
                        <strong class="text-dark" id="receiptInvId">INV-2026-0891</strong>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-muted d-block">Issue Date & Time:</span>
                        <strong class="text-dark" id="receiptDate">21 Mar 2026, 11:30 AM</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block">Patient Name:</span>
                        <strong class="text-dark" id="receiptPatient">David Sample</strong>
                    </div>
                    <div class="col-6 text-end">
                        <span class="text-muted d-block">Medical Record (MRN):</span>
                        <strong class="text-dark" id="receiptMrn">MRN-2026-0001</strong>
                    </div>
                    <div class="col-12">
                        <span class="text-muted d-block">Attending Clinician:</span>
                        <strong class="text-dark" id="receiptDoctor">Dr. Ethan Caldwell</strong>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Clinical Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="receiptProcedure">Guided Implant Surgical Placement (#19)</td>
                                <td class="text-end fw-bold" id="receiptAmount">£1,650.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-end">Total Settled:</th>
                                <th class="text-end text-success" id="receiptTotal">£1,650.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="bg-light p-2 rounded-2 text-center small text-muted">
                    Payment Method: <strong id="receiptMethod" class="text-dark">Visa Card POS</strong> | Status: <strong id="receiptStatus" class="text-success">Paid in Full</strong>
                </div>
            </div>
            <div class="modal-footer bg-light border-top py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="window.print()" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                    <i class="bi bi-printer me-1"></i>Print Tax Receipt / PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 5: Send WhatsApp Receipt                                         -->
<!-- ======================================================================= -->
<div class="modal fade" id="whatsAppReceiptModal" tabindex="-1" aria-labelledby="whatsAppReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="whatsAppReceiptModalLabel">
                    <i class="bi bi-whatsapp text-success me-2"></i>Send Electronic Invoice via WhatsApp
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="whatsAppReceiptForm" onsubmit="handleSendWhatsAppReceipt(event)">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Patient Name</label>
                        <input type="text" class="form-control" id="waPatientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Patient Verified WhatsApp Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-telephone-fill text-success"></i></span>
                            <input type="text" class="form-control" id="waPhone" value="+1 (555) 234-8901" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Invoice Message Preview</label>
                        <textarea class="form-control small bg-light" id="waMessagePreview" rows="4" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-whatsapp me-1"></i>Dispatch WhatsApp Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- MODAL 6: New POS Invoice                                               -->
<!-- ======================================================================= -->
<div class="modal fade" id="newInvoiceModal" tabindex="-1" aria-labelledby="newInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="newInvoiceModalLabel">
                    <i class="bi bi-receipt text-primary me-2"></i>Create Point-of-Sale (POS) Dental Invoice
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newInvoiceForm" onsubmit="handleNewInvoice(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Patient Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="invPatientName" placeholder="e.g. Eleanor Vance" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Medical Record # (MRN)</label>
                            <input type="text" class="form-control" id="invPatientMrn" value="MRN-2026-0158">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Clinical Procedure / Service Rendered <span class="text-danger">*</span></label>
                            <select class="form-select" id="invProcedure" onchange="autoFillProcedureFee()">
                                <option value="Comprehensive Clinical Exam & Digital Bite-Wings" data-fee="120.00">Comprehensive Clinical Exam & Digital Bite-Wings (£120)</option>
                                <option value="Porcelain Ceramic Crown (#14)" data-fee="850.00">Porcelain Ceramic Crown (#14) (£850)</option>
                                <option value="Direct Composite Resin Restoration (2-Surface)" data-fee="210.00">Direct Composite Resin Restoration (2-Surface) (£210)</option>
                                <option value="Single Guided Titanium Dental Implant (#19)" data-fee="1650.00">Single Guided Titanium Dental Implant (#19) (£1,650)</option>
                                <option value="Full Arch In-Office Power Whitening" data-fee="450.00">Full Arch In-Office Power Whitening (£450)</option>
                                <option value="Clear Aligner Express Therapy Package" data-fee="2400.00">Clear Aligner Express Therapy Package (£2,400)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Treating Clinician</label>
                            <select class="form-select" id="invDoctor">
                                <option value="Dr. Ethan Caldwell, DDS, FACP">Dr. Ethan Caldwell, DDS</option>
                                <option value="Dr. Marcus Vance, DMD">Dr. Marcus Vance, DMD</option>
                                <option value="Dr. Maya Lin, DDS">Dr. Maya Lin (Orthodontics)</option>
                                <option value="Dr. Olivia Harper, DDS">Dr. Olivia Harper (Pediatric)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Total Procedure Fee (£) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">£</span>
                                <input type="number" step="0.01" class="form-control fw-bold" id="invTotalAmount" value="120.00" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Advance Deposit / Paid Now (£)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">£</span>
                                <input type="number" step="0.01" class="form-control" id="invDepositAmount" value="120.00">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Primary Tender Method</label>
                            <select class="form-select" id="invPaymentMethod">
                                <option value="Visa / Mastercard POS">Visa / Mastercard POS</option>
                                <option value="Cash Tender">Cash Tender</option>
                                <option value="Direct Debit">Direct Debit</option>
                                <option value="Dental Insurance Copay">Dental Insurance Copay</option>
                                <option value="Apple / Google Pay">Apple / Google Pay</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-receipt me-1"></i>Generate Invoice & Settle POS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // In-memory JavaScript store for active invoices supporting real-time preview, payments, and refunds
    const invoiceStore = {
        'INV-2026-0891': {
            id: 'INV-2026-0891',
            date: '21 Mar 2026, 11:30 AM',
            patient: 'David Sample',
            mrn: 'MRN-2026-0001',
            procedure: 'Guided Implant Surgical Placement (#19)',
            doctor: 'Dr. Ethan Caldwell, DDS, FACP',
            total_amount: 1650.00,
            advance_deposit: 500.00,
            amount_paid: 1150.00,
            balance_due: 500.00,
            method: 'Visa Card POS',
            status: 'Partial Paid (Bal: £500.00)',
            statusKey: 'partial',
            items: [
                { code: 'D6010', title: 'Guided Dental Implant Placement (#19)', description: 'Precision 3D CBCT-guided surgical osteotomy and Straumann BLX Titanium fixture', qty: 1, unit_price: 1250.00, total: 1250.00 },
                { code: 'D7953', title: 'Bone Replacement Graft for Ridge Preservation', description: 'Bio-Oss collagen osteoinductive graft material and Bio-Gide resorbable barrier membrane', qty: 1, unit_price: 400.00, total: 400.00 }
            ],
            payments: [
                { date: '15 Nov 2026', title: 'Advance Surgery Booking Deposit', method: 'Bank Transfer', amount: 500.00, ref: 'DEP-84920' },
                { date: '18 Nov 2026', title: 'Stage 1 Implant Fixture Placement', method: 'Visa Card POS', amount: 650.00, ref: 'POS-89241' }
            ],
            refund_history: []
        },
        'INV-2026-0890': {
            id: 'INV-2026-0890',
            date: '21 Mar 2026, 09:45 AM',
            patient: 'Emma Jenkins',
            mrn: 'MRN-2026-0042',
            procedure: 'Clear Aligner Monthly Refinement (Tray 8)',
            doctor: 'Dr. Maya Lin, DDS',
            total_amount: 280.00,
            advance_deposit: 280.00,
            amount_paid: 280.00,
            balance_due: 0.00,
            method: 'Direct Debit',
            status: 'Paid in Full',
            statusKey: 'paid',
            items: [
                { code: 'D8080', title: 'Clear Aligner Orthodontic Refinement & Tracking', description: '3D iTero intraoral digital scan, tracking audit and aligner tray sets #8 & #9', qty: 1, unit_price: 280.00, total: 280.00 }
            ],
            payments: [
                { date: '21 Mar 2026', title: 'Monthly Aligner Subscription Settlement', method: 'Direct Debit', amount: 280.00, ref: 'DD-77291' }
            ],
            refund_history: []
        },
        'INV-2026-0889': {
            id: 'INV-2026-0889',
            date: '20 Mar 2026, 16:15 PM',
            patient: 'Michael Brown',
            mrn: 'MRN-2026-0098',
            procedure: 'Molar Endodontic Therapy & Core Build-Up',
            doctor: 'Dr. Marcus Vance, DMD',
            total_amount: 950.00,
            advance_deposit: 200.00,
            amount_paid: 200.00,
            balance_due: 750.00,
            method: 'Dental Net Ins. Copay',
            status: 'Insurance Pending (Bal: £750)',
            statusKey: 'insurance_pending',
            items: [
                { code: 'D3330', title: 'Molar Root Canal Endodontic Therapy (#30)', description: 'WaveOne rotary instrumentation, warm vertical obturation and digital apical radiography', qty: 1, unit_price: 750.00, total: 750.00 },
                { code: 'D2950', title: 'Core Build-Up Including Pins', description: 'Dual-cure radiopaque composite resin core foundation preparation', qty: 1, unit_price: 200.00, total: 200.00 }
            ],
            payments: [
                { date: '20 Mar 2026', title: 'Emergency Root Canal Triage Copay', method: 'Cash POS', amount: 200.00, ref: 'COP-1029' }
            ],
            refund_history: []
        },
        'INV-2026-0888': {
            id: 'INV-2026-0888',
            date: '20 Mar 2026, 14:00 PM',
            patient: 'Sophia Rodriguez',
            mrn: 'MRN-2026-0112',
            procedure: 'Full Mouth Ultrasonic Debridement & Polish',
            doctor: 'Dr. Ethan Caldwell, DDS',
            total_amount: 120.00,
            advance_deposit: 0.00,
            amount_paid: 120.00,
            balance_due: 0.00,
            method: 'Apple Pay Contactless',
            status: 'Paid in Full',
            statusKey: 'paid',
            items: [
                { code: 'D4346', title: 'Full Mouth Scaling & Ultrasonic Debridement', description: 'Supragingival and subgingival calculus removal and air-polishing prophylaxis', qty: 1, unit_price: 120.00, total: 120.00 }
            ],
            payments: [
                { date: '20 Mar 2026', title: 'Chairside POS Contactless Settlement', method: 'Apple Pay Contactless', amount: 120.00, ref: 'AP-55210' }
            ],
            refund_history: []
        },
        'INV-2026-0887': {
            id: 'INV-2026-0887',
            date: '19 Mar 2026, 11:15 AM',
            patient: 'James Wilson',
            mrn: 'MRN-2026-0145',
            procedure: 'Ceramic Crown Preparation & CAD/CAM Scan (#14)',
            doctor: 'Dr. Maya Lin, DDS',
            total_amount: 680.00,
            advance_deposit: 340.00,
            amount_paid: 340.00,
            balance_due: 340.00,
            method: 'Mastercard POS',
            status: 'Partial Paid (Bal: £340)',
            statusKey: 'partial',
            items: [
                { code: 'D2740', title: 'Monolithic Zirconia Crown Restoration (#14)', description: 'Precision CAD/CAM digital impression, prep and temporary protective restoration', qty: 1, unit_price: 680.00, total: 680.00 }
            ],
            payments: [
                { date: '19 Mar 2026', title: '50% Laboratory Milling Advance Deposit', method: 'Mastercard POS', amount: 340.00, ref: 'DEP-84915' }
            ],
            refund_history: []
        },
        'INV-2026-0886': {
            id: 'INV-2026-0886',
            date: '18 Mar 2026, 15:45 PM',
            patient: 'Robert Taylor',
            mrn: 'MRN-2026-0204',
            procedure: 'Surgical Wisdom Tooth Extraction (#32)',
            doctor: 'Dr. Ethan Caldwell, DDS, FACP',
            total_amount: 420.00,
            advance_deposit: 420.00,
            amount_paid: 0.00,
            balance_due: 0.00,
            method: 'Visa POS (Reversed)',
            status: 'Refunded (£420)',
            statusKey: 'refunded',
            items: [
                { code: 'D7240', title: 'Removal of Impacted Tooth - Completely Bony (#32)', description: 'Surgical flap elevation, ostectomy, sectioning and primary closure', qty: 1, unit_price: 420.00, total: 420.00 }
            ],
            payments: [
                { date: '16 Mar 2026', title: 'Initial Consultation & Surgical Deposit', method: 'Visa POS', amount: 420.00, ref: 'DEP-84910' }
            ],
            refund_history: [
                {
                    type: 'Full Clinical Refund',
                    amount: 420.00,
                    date: '18 Mar 2026, 14:15 PM',
                    reason: 'Deep impaction adjacent to inferior alveolar nerve. Attending oral surgeon referred patient to Queen Elizabeth Hospital Maxillofacial Unit for CBCT 3D nerve canal decompression.',
                    authorized_by: 'Dr. Ethan Caldwell, DDS, FACP',
                    hash: 'sha256:d8a9f24b0178c93051ab880e66d41077'
                }
            ]
        },
        'INV-2026-0885': {
            id: 'INV-2026-0885',
            date: '17 Mar 2026, 16:30 PM',
            patient: 'Clara Evans',
            mrn: 'MRN-2026-0189',
            procedure: 'In-Office Power Dental Bleaching',
            doctor: 'Dr. Marcus Vance, DMD',
            total_amount: 350.00,
            advance_deposit: 0.00,
            amount_paid: 0.00,
            balance_due: 0.00,
            method: 'None / Voided',
            status: 'Voided',
            statusKey: 'voided',
            items: [
                { code: 'D9972', title: 'External Bleaching - Per Arch - In-Office', description: 'Philips Zoom 25% hydrogen peroxide LED light-activated whitening', qty: 1, unit_price: 350.00, total: 350.00 }
            ],
            payments: [],
            refund_history: [
                {
                    type: 'Administrative Clinical Void',
                    amount: 0.00,
                    date: '17 Mar 2026, 16:35 PM',
                    reason: 'Patient acute dentin hypersensitivity demonstrated on cervical margin air blast test prior to peroxide gel activation. Procedure cancelled and desensitizing fluoride varnish applied.',
                    authorized_by: 'Dr. Marcus Vance, DMD',
                    hash: 'sha256:a1b2c3d4e5f60718293a4b5c6d7e8f90'
                }
            ]
        }
    };

    function showBillingAlert(message, type = 'success') {
        const placeholder = document.getElementById('billingAlertPlaceholder');
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
        }, 5000);
    }

    // Filter Ledger Tabs
    function filterBillingTab(tabKey) {
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        if (tabKey === 'all') document.getElementById('tabBtnAll').classList.add('active');
        if (tabKey === 'outstanding') document.getElementById('tabBtnOutstanding').classList.add('active');
        if (tabKey === 'deposits') document.getElementById('tabBtnDeposits').classList.add('active');
        if (tabKey === 'refunds') document.getElementById('tabBtnRefunds').classList.add('active');

        const rows = document.querySelectorAll('#billingTableBody tr');
        rows.forEach(row => {
            const type = row.getAttribute('data-type');
            const balance = parseFloat(row.getAttribute('data-balance') || '0');
            const status = row.getAttribute('data-status');

            let show = true;
            if (tabKey === 'outstanding') {
                show = balance > 0 || status === 'insurance_pending' || status === 'partial';
            } else if (tabKey === 'deposits') {
                show = parseFloat(row.getAttribute('data-deposit') || '0') > 0;
            } else if (tabKey === 'refunds') {
                show = status === 'refunded' || status === 'voided';
            }
            row.style.display = show ? '' : 'none';
        });
    }

    // Search filter
    function filterBillingTable() {
        const query = document.getElementById('billingSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#billingTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // =======================================================================
    // 1. Digital Invoice Preview Modal (Senior Dev Item 6 Fix)
    // =======================================================================
    function openInvoicePreviewModal(invId) {
        const inv = invoiceStore[invId];
        if (!inv) {
            alert('Invoice record not found in memory store.');
            return;
        }

        document.getElementById('prevModalId').innerText = inv.id;
        document.getElementById('prevModalStatusBadge').innerText = inv.status;
        document.getElementById('prevModalPatient').innerText = inv.patient;
        document.getElementById('prevModalMrn').innerText = inv.mrn;
        document.getElementById('prevModalDate').innerText = inv.date;
        document.getElementById('prevModalDoctor').innerText = inv.doctor;
        document.getElementById('prevModalTotalFee').innerText = '£' + inv.total_amount.toFixed(2);
        document.getElementById('prevModalPaid').innerText = '£' + inv.amount_paid.toFixed(2);

        const balanceElem = document.getElementById('prevModalBalance');
        if (inv.balance_due <= 0) {
            balanceElem.innerText = '£0.00 (Settled)';
            balanceElem.className = 'text-success fs-5';
        } else {
            balanceElem.innerText = '£' + inv.balance_due.toFixed(2) + ' Due';
            balanceElem.className = 'text-danger fs-5 fw-bold';
        }

        document.getElementById('prevModalFullPageLink').setAttribute('href', '{{ url('/billing') }}/' + inv.id);

        // Populate items table
        let itemsHtml = '';
        if (inv.items && inv.items.length > 0) {
            inv.items.forEach(it => {
                itemsHtml += `
                    <tr>
                        <td class="font-monospace small text-muted">${it.code}</td>
                        <td>
                            <div class="fw-bold text-dark">${it.title}</div>
                            <small class="text-muted">${it.description || ''}</small>
                        </td>
                        <td class="text-center">${it.qty}</td>
                        <td class="text-end">£${it.unit_price.toFixed(2)}</td>
                        <td class="text-end fw-bold">£${it.total.toFixed(2)}</td>
                    </tr>
                `;
            });
        }
        document.getElementById('prevModalItemsTable').innerHTML = itemsHtml;

        // Populate payments ledger
        let payHtml = '';
        if (inv.payments && inv.payments.length > 0) {
            inv.payments.forEach(p => {
                payHtml += `<div class="d-flex justify-content-between text-secondary py-0.5"><span>• ${p.date} - ${p.title} (${p.method})</span><strong>£${p.amount.toFixed(2)}</strong></div>`;
            });
        } else {
            payHtml = '<span class="text-muted">No advance deposits recorded.</span>';
        }
        document.getElementById('prevModalPaymentsLedger').innerHTML = payHtml;

        // Populate refund / void notice if any
        let refundNotice = '';
        if (inv.refund_history && inv.refund_history.length > 0) {
            inv.refund_history.forEach(rf => {
                refundNotice += `
                    <div class="alert alert-danger border-danger-subtle rounded-3 p-3 mb-0 small">
                        <strong class="text-danger d-block"><i class="bi bi-exclamation-octagon-fill me-1"></i>${rf.type} (£${rf.amount.toFixed(2)})</strong>
                        <span>Authorized By: <strong>${rf.authorized_by}</strong> (${rf.date})</span>
                        <p class="mb-1 mt-1 text-secondary"><strong>Clinical Reason:</strong> ${rf.reason}</p>
                        <span class="font-monospace text-muted" style="font-size: 0.7rem;">Audit Hash: ${rf.hash}</span>
                    </div>
                `;
            });
        }
        document.getElementById('prevModalRefundNoticeContainer').innerHTML = refundNotice;

        const modal = new bootstrap.Modal(document.getElementById('invoicePreviewModal'));
        modal.show();
    }

    // =======================================================================
    // 2. Record Advance Deposit / Partial Payment Modal
    // =======================================================================
    function openPartialPaymentModal(invId) {
        const inv = invoiceStore[invId];
        if (!inv) return;

        document.getElementById('payInvId').value = inv.id;
        document.getElementById('payInvRefDisplay').innerText = inv.id;
        document.getElementById('payPatientDisplay').innerText = inv.patient;
        document.getElementById('payTotalFeeDisplay').innerText = '£' + inv.total_amount.toFixed(2);
        document.getElementById('payBalanceDueDisplay').innerText = '£' + inv.balance_due.toFixed(2);
        document.getElementById('payAmountInput').value = inv.balance_due > 0 ? inv.balance_due.toFixed(2) : '50.00';
        document.getElementById('payAmountInput').max = inv.balance_due;

        const modal = new bootstrap.Modal(document.getElementById('partialPaymentModal'));
        modal.show();
    }

    function handleRecordPartialPayment(event) {
        event.preventDefault();
        const invId = document.getElementById('payInvId').value;
        const inv = invoiceStore[invId];
        if (!inv) return;

        const amount = parseFloat(document.getElementById('payAmountInput').value) || 0;
        const payType = document.getElementById('payTypeSelect').value;
        const method = document.getElementById('payMethodSelect').value;
        const refNote = document.getElementById('payRefNoteInput').value || 'Counter Settlement';

        if (amount <= 0) {
            alert('Please enter a valid payment amount greater than zero.');
            return;
        }

        inv.amount_paid += amount;
        inv.balance_due = Math.max(0, inv.total_amount - inv.amount_paid);
        if (inv.balance_due <= 0) {
            inv.status = 'Paid in Full';
            inv.statusKey = 'paid';
        } else {
            inv.status = 'Partial Paid (Bal: £' + inv.balance_due.toFixed(2) + ')';
            inv.statusKey = 'partial';
        }

        if (!inv.payments) inv.payments = [];
        inv.payments.push({
            date: new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }),
            title: payType,
            method: method,
            amount: amount,
            ref: 'PAY-' + Math.floor(Math.random() * 89000 + 10000)
        });

        // Update DOM row
        const row = document.getElementById('inv-row-' + invId.replace('INV-2026-', ''));
        if (row) {
            row.setAttribute('data-paid', inv.amount_paid.toFixed(2));
            row.setAttribute('data-balance', inv.balance_due.toFixed(2));
            row.setAttribute('data-status', inv.statusKey);

            const cols = row.querySelectorAll('td');
            if (cols.length >= 8) {
                cols[5].innerHTML = `<span class="fw-semibold text-success">£${inv.amount_paid.toFixed(2)}</span><small class="text-muted d-block" style="font-size: 0.72rem;">Paid: £${amount.toFixed(2)}</small>`;
                cols[6].innerHTML = inv.balance_due <= 0 ? '<span class="badge bg-success-subtle text-success">£0.00</span>' : `<span class="badge bg-warning-subtle text-warning fw-bold">£${inv.balance_due.toFixed(2)} Due</span>`;
                cols[7].innerHTML = inv.balance_due <= 0 ? '<span class="badge bg-success-subtle text-success">Paid in Full</span>' : '<span class="badge bg-warning-subtle text-warning">Partial Paid</span>';
            }
        }

        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('partialPaymentModal'));
        if (modalInstance) modalInstance.hide();

        showBillingAlert(`Successfully recorded <strong>£${amount.toFixed(2)}</strong> (${payType}) for <strong>${inv.patient}</strong> (${inv.id}). Balance remaining: £${inv.balance_due.toFixed(2)}.`);
    }

    // =======================================================================
    // 3. Process Clinical Refund / Void with Mandatory Reason (Senior Dev Item 10)
    // =======================================================================
    function openRefundVoidModal(invId) {
        const inv = invoiceStore[invId];
        if (!inv) return;

        document.getElementById('rfInvId').value = inv.id;
        document.getElementById('rfInvRefDisplay').innerText = inv.id;
        document.getElementById('rfPatientDisplay').innerText = inv.patient;
        document.getElementById('rfTotalPaidDisplay').innerText = '£' + inv.amount_paid.toFixed(2);
        document.getElementById('rfAmountInput').value = inv.amount_paid.toFixed(2);

        const modal = new bootstrap.Modal(document.getElementById('refundVoidModal'));
        modal.show();
    }

    function handleProcessRefundVoid(event) {
        event.preventDefault();
        const invId = document.getElementById('rfInvId').value;
        const inv = invoiceStore[invId];
        if (!inv) return;

        const actionType = document.getElementById('rfActionType').value;
        const amount = parseFloat(document.getElementById('rfAmountInput').value) || 0;
        const category = document.getElementById('rfCategorySelect').value;
        const notes = document.getElementById('rfReasonNotes').value.trim();
        const authorizer = document.getElementById('rfAuthorizer').value;

        if (!category) {
            alert('Please select a mandatory clinical reason category for audit compliance.');
            return;
        }
        if (notes.length < 10) {
            alert('Please provide a detailed clinical explanation (at least 10 characters).');
            return;
        }

        const auditHash = 'sha256:' + Array.from({length: 32}, () => Math.floor(Math.random() * 16).toString(16)).join('');
        const fullReason = `[${category}] ${notes}`;

        inv.status = actionType.includes('Void') ? 'Voided' : `Refunded (£${amount.toFixed(2)})`;
        inv.statusKey = actionType.includes('Void') ? 'voided' : 'refunded';

        if (!inv.refund_history) inv.refund_history = [];
        inv.refund_history.push({
            type: actionType,
            amount: amount,
            date: new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) + ', ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            reason: fullReason,
            authorized_by: authorizer,
            hash: auditHash
        });

        // Update DOM row
        const rowIdNum = invId.replace('INV-2026-', '');
        const row = document.getElementById('inv-row-' + rowIdNum);
        if (row) {
            row.setAttribute('data-status', inv.statusKey);
            const cols = row.querySelectorAll('td');
            if (cols.length >= 8) {
                cols[5].innerHTML = `<span class="fw-semibold text-muted">£0.00</span><small class="text-danger d-block" style="font-size: 0.72rem;">Reversed</small>`;
                cols[6].innerHTML = '<span class="badge bg-light text-dark">£0.00</span>';
                cols[7].innerHTML = `<span class="badge bg-danger-subtle text-danger">${inv.status}</span>`;
            }
        }

        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('refundVoidModal'));
        if (modalInstance) modalInstance.hide();

        showBillingAlert(`Clinical audit reversal processed for <strong>${inv.id}</strong> (${inv.patient}). Audit Signature: <span class="font-monospace">${auditHash.substring(0, 16)}...</span>`, 'warning');
    }

    // Auto-fill fee on new invoice modal
    function autoFillProcedureFee() {
        const select = document.getElementById('invProcedure');
        const fee = select.options[select.selectedIndex].getAttribute('data-fee');
        if (fee) {
            document.getElementById('invTotalAmount').value = parseFloat(fee).toFixed(2);
            document.getElementById('invDepositAmount').value = parseFloat(fee).toFixed(2);
        }
    }

    // New POS Invoice Handler
    function handleNewInvoice(event) {
        event.preventDefault();
        const patient = document.getElementById('invPatientName').value.trim();
        const mrn = document.getElementById('invPatientMrn').value.trim() || 'MRN-2026-0158';
        const procedure = document.getElementById('invProcedure').value;
        const doctor = document.getElementById('invDoctor').value;
        const totalAmount = parseFloat(document.getElementById('invTotalAmount').value) || 0;
        const depositAmount = parseFloat(document.getElementById('invDepositAmount').value) || 0;
        const method = document.getElementById('invPaymentMethod').value;

        const balanceDue = Math.max(0, totalAmount - depositAmount);
        const status = balanceDue <= 0 ? 'Paid in Full' : `Partial Paid (Bal: £${balanceDue.toFixed(2)})`;
        const statusKey = balanceDue <= 0 ? 'paid' : 'partial';

        const invNum = 'INV-2026-0' + Math.floor(Math.random() * 800 + 100);
        const shortId = invNum.replace('INV-2026-', '');

        // Add to in-memory store
        invoiceStore[invNum] = {
            id: invNum,
            date: 'Just Now',
            patient: patient,
            mrn: mrn,
            procedure: procedure,
            doctor: doctor,
            total_amount: totalAmount,
            advance_deposit: depositAmount,
            amount_paid: depositAmount,
            balance_due: balanceDue,
            method: method,
            status: status,
            statusKey: statusKey,
            items: [
                { code: 'D0120', title: procedure, description: 'Point-of-Sale clinical encounter and professional dental service', qty: 1, unit_price: totalAmount, total: totalAmount }
            ],
            payments: depositAmount > 0 ? [{ date: 'Today', title: 'POS Encounter Deposit', method: method, amount: depositAmount, ref: 'POS-' + Math.floor(Math.random()*89000+10000) }] : [],
            refund_history: []
        };

        const statusBadgeClass = balanceDue <= 0 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';

        const rowHtml = `
            <tr id="inv-row-${shortId}" data-id="${invNum}" data-patient="${patient}" data-mrn="${mrn}" data-procedure="${procedure}" data-doctor="${doctor}" data-total="${totalAmount.toFixed(2)}" data-deposit="${depositAmount.toFixed(2)}" data-paid="${depositAmount.toFixed(2)}" data-balance="${balanceDue.toFixed(2)}" data-method="${method}" data-status="${statusKey}" data-type="outstanding" data-date="Today">
                <td class="ps-3">
                    <button type="button" class="btn btn-sm btn-link p-0 fw-mono text-primary text-decoration-none" onclick="openInvoicePreviewModal('${invNum}')" title="View Digital Invoice Preview">
                        <i class="bi bi-file-earmark-text me-1"></i>${invNum}
                    </button>
                </td>
                <td>
                    <span class="fw-bold text-dark d-block">${patient}</span>
                    <small class="text-muted">${mrn}</small>
                </td>
                <td>${procedure}</td>
                <td><span class="fw-semibold text-dark">${doctor}</span></td>
                <td><span class="fw-bold text-dark">£${totalAmount.toLocaleString('en-GB', {minimumFractionDigits: 2})}</span></td>
                <td>
                    <span class="fw-semibold text-success">£${depositAmount.toLocaleString('en-GB', {minimumFractionDigits: 2})}</span>
                    <small class="text-muted d-block" style="font-size: 0.72rem;">Dep: £${depositAmount.toFixed(2)}</small>
                </td>
                <td>${balanceDue <= 0 ? '<span class="badge bg-success-subtle text-success">£0.00</span>' : `<span class="badge bg-warning-subtle text-warning fw-bold">£${balanceDue.toFixed(2)} Due</span>`}</td>
                <td><span class="badge ${statusBadgeClass}">${status}</span></td>
                <td><span class="small text-muted">Just Now</span></td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary" onclick="openInvoicePreviewModal('${invNum}')" title="View Digital Invoice Preview"><i class="bi bi-eye"></i></button>
                        <button type="button" class="btn btn-outline-success" onclick="openPartialPaymentModal('${invNum}')" title="Record Payment / Deposit"><i class="bi bi-credit-card-2-front"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-${shortId}')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-${shortId}')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                        <button type="button" class="btn btn-outline-danger" onclick="openRefundVoidModal('${invNum}')" title="Clinical Refund / Void"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('billingTableBody').insertAdjacentHTML('afterbegin', rowHtml);

        const modal = bootstrap.Modal.getInstance(document.getElementById('newInvoiceModal'));
        if (modal) modal.hide();
        document.getElementById('newInvoiceForm').reset();

        showBillingAlert(`POS Invoice <strong>${invNum}</strong> successfully generated for <strong>${patient}</strong> (£${totalAmount.toFixed(2)}).`);
    }

    // Print Receipt Modal helper
    function openPrintReceiptModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('receiptInvId').innerText = row.getAttribute('data-id');
        document.getElementById('receiptPatient').innerText = row.getAttribute('data-patient');
        document.getElementById('receiptMrn').innerText = row.getAttribute('data-mrn');
        document.getElementById('receiptProcedure').innerText = row.getAttribute('data-procedure');
        document.getElementById('receiptDoctor').innerText = row.getAttribute('data-doctor');
        document.getElementById('receiptAmount').innerText = '£' + parseFloat(row.getAttribute('data-total')).toFixed(2);
        document.getElementById('receiptTotal').innerText = '£' + parseFloat(row.getAttribute('data-total')).toFixed(2);
        document.getElementById('receiptMethod').innerText = row.getAttribute('data-method');
        document.getElementById('receiptStatus').innerText = 'Settled';

        const modal = new bootstrap.Modal(document.getElementById('printReceiptModal'));
        modal.show();
    }

    // WhatsApp Modal helper
    function openWhatsAppModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        const patient = row.getAttribute('data-patient');
        const invId = row.getAttribute('data-id');
        const amount = row.getAttribute('data-total');
        const procedure = row.getAttribute('data-procedure');

        document.getElementById('waPatientName').value = patient;
        document.getElementById('waMessagePreview').value = `Hello ${patient},\n\nThank you for choosing Advanced Dental Clinic. Your official tax invoice ${invId} for "${procedure}" (£${amount}) is available.\n\nView digital invoice: https://demo.ratneshsharma.com/advanced-dental-clinic/billing/${invId}\n\nWarm regards,\nClinical Care Team`;

        const modal = new bootstrap.Modal(document.getElementById('whatsAppReceiptModal'));
        modal.show();
    }

    function handleSendWhatsAppReceipt(event) {
        event.preventDefault();
        const patient = document.getElementById('waPatientName').value;
        const phone = document.getElementById('waPhone').value;

        const modal = bootstrap.Modal.getInstance(document.getElementById('whatsAppReceiptModal'));
        if (modal) modal.hide();

        showBillingAlert(`Digital tax invoice successfully dispatched via WhatsApp to <strong>${patient}</strong> (${phone})!`);
    }
</script>
@endpush
