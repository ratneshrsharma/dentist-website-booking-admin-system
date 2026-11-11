@extends('layouts.admin')

@section('title', 'Billing, Invoices & POS - Advanced Dental PRO')
@section('page_title', 'Billing, Invoices & POS')
@section('page_subtitle', 'Patient ledger, insurance claims processing, electronic POS receipts, and accounts receivable')

@section('content')
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
                    <h3 class="fw-bold mb-0 text-dark">£4,850.00</h3>
                    <span class="badge bg-success-subtle text-success small mt-1">14 settled invoices</span>
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
                <input type="text" class="form-control border-start-0" placeholder="Search by invoice #, patient...">
            </div>
            <button class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-plus-circle me-1"></i>New POS Invoice
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
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
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">INV-2026-0891</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">David Sample</span>
                            <small class="text-muted">MRN-2026-0001</small>
                        </td>
                        <td>Guided Implant Surgical Placement (#19)</td>
                        <td><span class="fw-semibold text-dark">Dr. Ethan Caldwell</span></td>
                        <td><span class="fw-bold text-dark">£1,650.00</span></td>
                        <td><span class="badge bg-light text-dark border"><i class="bi bi-credit-card me-1"></i>Visa Card</span></td>
                        <td><span class="badge bg-success-subtle text-success">Paid in Full</span></td>
                        <td><span class="small text-muted">Today, 11:30 AM</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-outline-secondary" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">INV-2026-0890</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Emma Jenkins</span>
                            <small class="text-muted">MRN-2026-0042</small>
                        </td>
                        <td>Clear Aligner Monthly Refinement (Tray 8)</td>
                        <td><span class="fw-semibold text-dark">Dr. Maya Lin</span></td>
                        <td><span class="fw-bold text-dark">£280.00</span></td>
                        <td><span class="badge bg-light text-dark border"><i class="bi bi-bank me-1"></i>Direct Debit</span></td>
                        <td><span class="badge bg-success-subtle text-success">Paid in Full</span></td>
                        <td><span class="small text-muted">Today, 09:45 AM</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-outline-secondary" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">INV-2026-0889</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Michael Brown</span>
                            <small class="text-muted">MRN-2026-0098</small>
                        </td>
                        <td>Molar Endodontic Therapy & Core Build-Up</td>
                        <td><span class="fw-semibold text-dark">Dr. Marcus Vance</span></td>
                        <td><span class="fw-bold text-dark">£950.00</span></td>
                        <td><span class="badge bg-light text-dark border"><i class="bi bi-shield-check me-1"></i>Dental Net Ins.</span></td>
                        <td><span class="badge bg-warning-subtle text-warning">Insurance Claim Pending</span></td>
                        <td><span class="small text-muted">Yesterday</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-outline-secondary" title="Adjudicate Claim"><i class="bi bi-file-earmark-check text-primary"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">INV-2026-0888</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Sophia Turner</span>
                            <small class="text-muted">MRN-2026-0112</small>
                        </td>
                        <td>Pediatric Exam, Prophylaxis & Sealants</td>
                        <td><span class="fw-semibold text-dark">Dr. Olivia Harper</span></td>
                        <td><span class="fw-bold text-dark">£145.00</span></td>
                        <td><span class="badge bg-light text-dark border"><i class="bi bi-cash me-1"></i>Cash POS</span></td>
                        <td><span class="badge bg-success-subtle text-success">Paid in Full</span></td>
                        <td><span class="small text-muted">19 Mar 2026</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" title="Print Tax Receipt"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-outline-secondary" title="Send WhatsApp Receipt"><i class="bi bi-whatsapp text-success"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
