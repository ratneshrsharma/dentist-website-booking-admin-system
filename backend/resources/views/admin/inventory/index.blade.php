@extends('layouts.admin')

@section('title', 'Dental Supplies & Stock Inventory - Advanced Dental PRO')
@section('page_title', 'Dental Supplies & Stock Inventory')
@section('page_subtitle', 'Surgical implants, composites, anesthetics, and clinical supply chain monitor')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #CCFBF1; color: #0F766E;">
                    <i class="bi bi-box-seam-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Tracked SKUs</span>
                    <h3 class="fw-bold mb-0 text-dark">438 SKUs</h3>
                    <span class="text-muted small mt-1">Across 3 branches</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEE2E2; color: #DC2626;">
                    <i class="bi bi-exclamation-octagon-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Low Stock Warnings</span>
                    <h3 class="fw-bold mb-0 text-dark">6 Items</h3>
                    <span class="badge bg-danger-subtle text-danger small mt-1">Reorder Required</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-hourglass-split fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Expiring in 60 Days</span>
                    <h3 class="fw-bold mb-0 text-dark">14 Batches</h3>
                    <span class="text-muted small mt-1">FIFO dispatch alert</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 me-3" style="background-color: #E0E7FF; color: #4338CA;">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-medium d-block">Total Inventory Valuation</span>
                    <h3 class="fw-bold mb-0 text-dark">£68,450</h3>
                    <span class="text-muted small mt-1">Audited Mar 2026</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Clinical Supplies & Restorative Stock</h5>
            <span class="text-muted small">Batch tracking, minimum thresholds, and automated reorder points</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 280px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search by SKU, brand, item...">
            </div>
            <button class="btn btn-sm btn-primary" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-plus-circle me-1"></i>Receive Delivery (PO)
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Item SKU</th>
                        <th>Material Description</th>
                        <th>Category</th>
                        <th>Assigned Branch</th>
                        <th>In Stock</th>
                        <th>Reorder Level</th>
                        <th>Lot / Batch #</th>
                        <th>Expiry Date</th>
                        <th>Stock Health</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Item 1 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">SKU-IMP-849</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Straumann® BLX Titanium Implant 4.5mm × 10mm</span>
                            <small class="text-muted">Supplier: Straumann AG Switzerland</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">Surgical Implants</span></td>
                        <td>Metro Dental Central</td>
                        <td><span class="fw-bold text-danger">3 units</span></td>
                        <td>5 units</td>
                        <td><span class="small text-muted fw-mono">LOT-2025-BLX</span></td>
                        <td><span class="small text-dark">Nov 2028</span></td>
                        <td><span class="badge bg-danger-subtle text-danger">Low Stock Warning</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                        </td>
                    </tr>

                    <!-- Item 2 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">SKU-RES-104</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">3M™ Filtek™ Supreme Universal Composite (Shade A2)</span>
                            <small class="text-muted">Supplier: 3M Healthcare Oral Care</small>
                        </td>
                        <td><span class="badge bg-teal-subtle text-teal" style="background: #CCFBF1; color: #0F766E;">Restorative</span></td>
                        <td>Metro Dental Central</td>
                        <td><span class="fw-bold text-success">28 syringes</span></td>
                        <td>10 syringes</td>
                        <td><span class="small text-muted fw-mono">LOT-88194-A2</span></td>
                        <td><span class="small text-dark">Aug 2027</span></td>
                        <td><span class="badge bg-success-subtle text-success">Optimal Stock</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>

                    <!-- Item 3 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">SKU-ANE-019</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Septodont Septocaine® 4% (Articaine HCl + Epinephrine 1:100k)</span>
                            <small class="text-muted">Supplier: Septodont Inc.</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning">Anesthetics</span></td>
                        <td>All Branches</td>
                        <td><span class="fw-bold text-success">140 carpules</span></td>
                        <td>50 carpules</td>
                        <td><span class="small text-muted fw-mono">LOT-SEP-402</span></td>
                        <td><span class="small text-warning fw-bold">May 2026 (Expiring Soon)</span></td>
                        <td><span class="badge bg-warning-subtle text-warning">FIFO Rotation Alert</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>

                    <!-- Item 4 -->
                    <tr>
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono">SKU-ORT-332</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block">Ormco Damon™ Archwires (.014 Copper NiTi Upper/Lower)</span>
                            <small class="text-muted">Supplier: Ormco Orthodontics</small>
                        </td>
                        <td><span class="badge bg-info-subtle text-info">Orthodontics</span></td>
                        <td>Westside Smile Studio</td>
                        <td><span class="fw-bold text-success">65 packs</span></td>
                        <td>20 packs</td>
                        <td><span class="small text-muted fw-mono">LOT-DM-014</span></td>
                        <td><span class="small text-dark">Dec 2029</span></td>
                        <td><span class="badge bg-success-subtle text-success">Optimal Stock</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
