@extends('layouts.admin')

@section('title', 'Billing, Invoices & POS - Advanced Dental PRO')
@section('page_title', 'Billing, Invoices & POS')
@section('page_subtitle', 'Patient ledger, insurance claims processing, electronic POS receipts, and accounts receivable')

@section('page_actions')
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#newInvoiceModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
    <i class="bi bi-plus-circle me-1"></i> New POS Invoice
</button>
@endsection

@section('content')
<!-- Feedback Toast -->
<div id="billingAlertPlaceholder" class="mb-3"></div>

<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #DCFCE7; color: #15803D;">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Today's Collections</span>
                    <h3 class="fw-bold mb-0 text-dark" id="statTodayCollections">£4,850.00</h3>
                    <span class="badge bg-success-subtle text-success small mt-1" id="statSettledCount">14 settled invoices</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-file-earmark-medical fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Pending Insurance Claims</span>
                    <h3 class="fw-bold mb-0 text-dark">£12,400.00</h3>
                    <span class="text-muted small mt-1">8 claims awaiting adjudication</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEE2E2; color: #DC2626;">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Accounts Receivable</span>
                    <h3 class="fw-bold mb-0 text-dark">£3,250.00</h3>
                    <span class="text-muted small mt-1">30+ days overdue</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-graph-up-arrow fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Month-to-Date Revenue</span>
                    <h3 class="fw-bold mb-0 text-dark">£58,920.00</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">+14% vs Last Month</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoices Ledger Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Clinical Invoices & Point-of-Sale (POS) Ledger</h5>
            <span class="text-muted small">Multi-tender checkout, copay receipts, and claims tracking</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 280px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="billingSearchInput" onkeyup="filterBillingTable()" placeholder="Search invoice #, patient...">
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newInvoiceModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-plus-circle me-1"></i>New POS Invoice
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="billingTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Invoice #</th>
                        <th>Patient Name</th>
                        <th>Clinical Procedure</th>
                        <th>Treating Doctor</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Claim Status</th>
                        <th>Date & Time</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="billingTableBody">
                    <!-- Row 1 -->
                    <tr id="inv-row-891" data-id="INV-2026-0891" data-patient="David Sample" data-mrn="MRN-2026-0001" data-procedure="Guided Implant Surgical Placement (#19)" data-doctor="Dr. Ethan Caldwell" data-amount="1650.00" data-method="Visa Card" data-status="Paid in Full">
                        <td class="ps-3">
                            <a href="{{ url('/billing/INV-2026-0891') }}" target="_blank" class="badge bg-light text-primary border fw-mono row-inv-id text-decoration-none" title="Open Digital Invoice View">
                                <i class="bi bi-box-arrow-up-right me-1"></i>INV-2026-0891
                            </a>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block row-patient">David Sample</span>
                            <small class="text-muted row-mrn">MRN-2026-0001</small>
                        </td>
                        <td class="row-procedure">Guided Implant Surgical Placement (#19)</td>
                        <td><span class="fw-semibold text-dark row-doctor">Dr. Ethan Caldwell</span></td>
                        <td><span class="fw-bold text-dark row-amount">£1,650.00</span></td>
                        <td><span class="badge bg-light text-dark border row-method"><i class="bi bi-credit-card me-1"></i>Visa Card</span></td>
                        <td><span class="badge bg-success-subtle text-success row-status">Paid in Full</span></td>
                        <td><span class="small text-muted row-date">Today, 11:30 AM</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/billing/INV-2026-0891') }}" target="_blank" class="btn btn-outline-primary" title="View Digital Invoice"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-891')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-891')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="voidInvoiceRow('inv-row-891')" title="Void Invoice"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr id="inv-row-890" data-id="INV-2026-0890" data-patient="Emma Jenkins" data-mrn="MRN-2026-0042" data-procedure="Clear Aligner Monthly Refinement (Tray 8)" data-doctor="Dr. Maya Lin" data-amount="280.00" data-method="Direct Debit" data-status="Paid in Full">
                        <td class="ps-3">
                            <a href="{{ url('/billing/INV-2026-0890') }}" target="_blank" class="badge bg-light text-primary border fw-mono row-inv-id text-decoration-none" title="Open Digital Invoice View">
                                <i class="bi bi-box-arrow-up-right me-1"></i>INV-2026-0890
                            </a>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block row-patient">Emma Jenkins</span>
                            <small class="text-muted row-mrn">MRN-2026-0042</small>
                        </td>
                        <td class="row-procedure">Clear Aligner Monthly Refinement (Tray 8)</td>
                        <td><span class="fw-semibold text-dark row-doctor">Dr. Maya Lin</span></td>
                        <td><span class="fw-bold text-dark row-amount">£280.00</span></td>
                        <td><span class="badge bg-light text-dark border row-method"><i class="bi bi-bank me-1"></i>Direct Debit</span></td>
                        <td><span class="badge bg-success-subtle text-success row-status">Paid in Full</span></td>
                        <td><span class="small text-muted row-date">Today, 09:45 AM</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/billing/INV-2026-0890') }}" target="_blank" class="btn btn-outline-primary" title="View Digital Invoice"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-890')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-890')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="voidInvoiceRow('inv-row-890')" title="Void Invoice"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr id="inv-row-889" data-id="INV-2026-0889" data-patient="Michael Brown" data-mrn="MRN-2026-0098" data-procedure="Molar Endodontic Therapy & Core Build-Up" data-doctor="Dr. Marcus Vance" data-amount="950.00" data-method="Dental Net Ins." data-status="Insurance Pending">
                        <td class="ps-3">
                            <a href="{{ url('/billing/INV-2026-0889') }}" target="_blank" class="badge bg-light text-primary border fw-mono row-inv-id text-decoration-none" title="Open Digital Invoice View">
                                <i class="bi bi-box-arrow-up-right me-1"></i>INV-2026-0889
                            </a>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block row-patient">Michael Brown</span>
                            <small class="text-muted row-mrn">MRN-2026-0098</small>
                        </td>
                        <td class="row-procedure">Molar Endodontic Therapy & Core Build-Up</td>
                        <td><span class="fw-semibold text-dark row-doctor">Dr. Marcus Vance</span></td>
                        <td><span class="fw-bold text-dark row-amount">£950.00</span></td>
                        <td><span class="badge bg-light text-dark border row-method"><i class="bi bi-shield-check me-1"></i>Dental Net Ins.</span></td>
                        <td><span class="badge bg-warning-subtle text-warning row-status">Insurance Claim Pending</span></td>
                        <td><span class="small text-muted row-date">Yesterday</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/billing/INV-2026-0889') }}" target="_blank" class="btn btn-outline-primary" title="View Digital Invoice"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-889')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-889')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="voidInvoiceRow('inv-row-889')" title="Void Invoice"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr id="inv-row-888" data-id="INV-2026-0888" data-patient="Sophia Turner" data-mrn="MRN-2026-0112" data-procedure="Pediatric Exam, Prophylaxis & Sealants" data-doctor="Dr. Olivia Harper" data-amount="145.00" data-method="Cash POS" data-status="Paid in Full">
                        <td class="ps-3">
                            <a href="{{ url('/billing/INV-2026-0888') }}" target="_blank" class="badge bg-light text-primary border fw-mono row-inv-id text-decoration-none" title="Open Digital Invoice View">
                                <i class="bi bi-box-arrow-up-right me-1"></i>INV-2026-0888
                            </a>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block row-patient">Sophia Turner</span>
                            <small class="text-muted row-mrn">MRN-2026-0112</small>
                        </td>
                        <td class="row-procedure">Pediatric Exam, Prophylaxis & Sealants</td>
                        <td><span class="fw-semibold text-dark row-doctor">Dr. Olivia Harper</span></td>
                        <td><span class="fw-bold text-dark row-amount">£145.00</span></td>
                        <td><span class="badge bg-light text-dark border row-method"><i class="bi bi-cash me-1"></i>Cash POS</span></td>
                        <td><span class="badge bg-success-subtle text-success row-status">Paid in Full</span></td>
                        <td><span class="small text-muted row-date">19 Mar 2026</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('/billing/INV-2026-0888') }}" target="_blank" class="btn btn-outline-primary" title="View Digital Invoice"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('inv-row-888')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('inv-row-888')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="voidInvoiceRow('inv-row-888')" title="Void Invoice"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal 1: New POS Invoice -->
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
                                <option value="Dr. Ethan Caldwell">Dr. Ethan Caldwell, DDS</option>
                                <option value="Dr. Marcus Vance">Dr. Marcus Vance, DMD</option>
                                <option value="Dr. Maya Lin">Dr. Maya Lin (Orthodontics)</option>
                                <option value="Dr. Olivia Harper">Dr. Olivia Harper (Pediatric)</option>
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
                            <label class="form-label fw-semibold small">Payment Method / Tender</label>
                            <select class="form-select" id="invPaymentMethod">
                                <option value="Visa / Mastercard POS">Visa / Mastercard POS</option>
                                <option value="Cash Tender">Cash Tender</option>
                                <option value="Direct Debit">Direct Debit</option>
                                <option value="Dental Insurance Copay">Dental Insurance Copay</option>
                                <option value="Apple / Google Pay">Apple / Google Pay</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Claim Settlement Status</label>
                            <select class="form-select" id="invClaimStatus">
                                <option value="Paid in Full">Paid in Full</option>
                                <option value="Insurance Claim Pending">Insurance Claim Pending</option>
                                <option value="Partial / Deposit">Partial / Deposit</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-printer me-1"></i>Generate Invoice & Settle POS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Print Tax Receipt -->
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
                    <i class="bi bi-printer me-1"></i>Print Receipt / Export PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Send WhatsApp Receipt -->
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
@endsection

@push('scripts')
<script>
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
        }, 4000);
    }

    // 1. Live Filter
    function filterBillingTable() {
        const query = document.getElementById('billingSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#billingTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // 2. Auto-fill fee on select
    function autoFillProcedureFee() {
        const select = document.getElementById('invProcedure');
        const fee = select.options[select.selectedIndex].getAttribute('data-fee');
        if (fee) {
            document.getElementById('invTotalAmount').value = parseFloat(fee).toFixed(2);
        }
    }

    // 3. New POS Invoice Handler
    function handleNewInvoice(event) {
        event.preventDefault();
        const patient = document.getElementById('invPatientName').value.trim();
        const mrn = document.getElementById('invPatientMrn').value.trim() || 'MRN-2026-0158';
        const procedure = document.getElementById('invProcedure').value;
        const doctor = document.getElementById('invDoctor').value;
        const amount = parseFloat(document.getElementById('invTotalAmount').value) || 0;
        const method = document.getElementById('invPaymentMethod').value;
        const status = document.getElementById('invClaimStatus').value;

        const invNum = 'INV-2026-0' + Math.floor(Math.random() * 800 + 100);
        const rowId = 'inv-row-' + Date.now();

        const statusClass = (status === 'Paid in Full') ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';

        const rowHtml = `
            <tr id="${rowId}" data-id="${invNum}" data-patient="${patient}" data-mrn="${mrn}" data-procedure="${procedure}" data-doctor="${doctor}" data-amount="${amount.toFixed(2)}" data-method="${method}" data-status="${status}">
                <td class="ps-3"><span class="badge bg-light text-dark border fw-mono row-inv-id">${invNum}</span></td>
                <td>
                    <span class="fw-bold text-dark d-block row-patient">${patient}</span>
                    <small class="text-muted row-mrn">${mrn}</small>
                </td>
                <td class="row-procedure">${procedure}</td>
                <td><span class="fw-semibold text-dark row-doctor">${doctor}</span></td>
                <td><span class="fw-bold text-dark row-amount">£${amount.toLocaleString('en-GB', {minimumFractionDigits: 2})}</span></td>
                <td><span class="badge bg-light text-dark border row-method"><i class="bi bi-credit-card me-1"></i>${method}</span></td>
                <td><span class="badge ${statusClass} row-status">${status}</span></td>
                <td><span class="small text-muted row-date">Just Now</span></td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary" onclick="openPrintReceiptModal('${rowId}')" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="openWhatsAppModal('${rowId}')" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                        <button type="button" class="btn btn-outline-danger" onclick="voidInvoiceRow('${rowId}')" title="Void Invoice"><i class="bi bi-x-circle"></i></button>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('billingTableBody').insertAdjacentHTML('afterbegin', rowHtml);

        const totalInvoices = document.querySelectorAll('#billingTableBody tr').length;
        document.getElementById('statSettledCount').innerText = `${totalInvoices} settled invoices`;

        const modal = bootstrap.Modal.getInstance(document.getElementById('newInvoiceModal'));
        if (modal) modal.hide();
        document.getElementById('newInvoiceForm').reset();

        showBillingAlert(`Invoice <strong>${invNum}</strong> for <strong>£${amount.toFixed(2)}</strong> generated and settled for ${patient}!`);
    }

    // 4. Print Tax Receipt Modal
    function openPrintReceiptModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('receiptInvId').innerText = row.getAttribute('data-id');
        document.getElementById('receiptPatient').innerText = row.getAttribute('data-patient');
        document.getElementById('receiptMrn').innerText = row.getAttribute('data-mrn');
        document.getElementById('receiptProcedure').innerText = row.getAttribute('data-procedure');
        document.getElementById('receiptDoctor').innerText = row.getAttribute('data-doctor');
        document.getElementById('receiptAmount').innerText = '£' + parseFloat(row.getAttribute('data-amount')).toFixed(2);
        document.getElementById('receiptTotal').innerText = '£' + parseFloat(row.getAttribute('data-amount')).toFixed(2);
        document.getElementById('receiptMethod').innerText = row.getAttribute('data-method');
        document.getElementById('receiptStatus').innerText = row.getAttribute('data-status');
        document.getElementById('receiptDate').innerText = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) + ', ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const modal = new bootstrap.Modal(document.getElementById('printReceiptModal'));
        modal.show();
    }

    // 5. WhatsApp Modal
    function openWhatsAppModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        const patient = row.getAttribute('data-patient');
        const invId = row.getAttribute('data-id');
        const amount = row.getAttribute('data-amount');
        const procedure = row.getAttribute('data-procedure');

        document.getElementById('waPatientName').value = patient;
        document.getElementById('waMessagePreview').value = `Hello ${patient},\n\nThank you for choosing Advanced Dental Clinic. Your official tax invoice ${invId} for "${procedure}" (£${amount}) has been settled in full.\n\nView and download your digital receipt anytime: https://demo.ratneshsharma.com/advanced-dental-clinic/billing/${invId}\n\nWarm regards,\nClinical Care Team`;

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

    // 6. Void Invoice
    function voidInvoiceRow(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;
        const invId = row.getAttribute('data-id');
        if (confirm(`Void and reverse clinical invoice ${invId}?`)) {
            row.remove();
            showBillingAlert(`Invoice <strong>${invId}</strong> was voided and reversed in the clinical ledger.`, 'warning');
        }
    }
</script>
@endpush
