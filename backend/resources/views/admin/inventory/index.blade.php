@extends('layouts.admin')

@section('title', 'Dental Supplies & Stock Inventory - Advanced Dental PRO')
@section('page_title', 'Dental Supplies & Stock Inventory')
@section('page_subtitle', 'Surgical implants, composites, anesthetics, and clinical supply chain monitor')

@section('page_actions')
<button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#receiveDeliveryModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
    <i class="bi bi-plus-circle me-1"></i> Receive Delivery (PO)
</button>
@endsection

@section('content')
<!-- Feedback Toast -->
<div id="inventoryAlertPlaceholder" class="mb-3"></div>

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
                    <h3 class="fw-bold mb-0 text-dark" id="statTrackedSkus">438 SKUs</h3>
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
                    <h3 class="fw-bold mb-0 text-dark" id="statLowStock">6 Items</h3>
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
            <div class="input-group input-group-sm" style="max-width: 300px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" id="inventorySearchInput" onkeyup="filterInventoryTable()" placeholder="Search SKU, brand, material...">
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#receiveDeliveryModal" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                <i class="bi bi-plus-circle me-1"></i>Receive Delivery (PO)
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="inventoryTable">
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
                <tbody id="inventoryTableBody">
                    <!-- Item 1 -->
                    <tr id="inv-row-1" data-sku="SKU-IMP-849" data-name="Straumann® BLX Titanium Implant 4.5mm × 10mm" data-supplier="Straumann AG Switzerland" data-category="Surgical Implants" data-branch="Metro Dental Central" data-stock="3" data-reorder="5" data-lot="LOT-2025-BLX" data-expiry="Nov 2028">
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono inv-sku">SKU-IMP-849</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block inv-name">Straumann® BLX Titanium Implant 4.5mm × 10mm</span>
                            <small class="text-muted inv-supplier">Supplier: Straumann AG Switzerland</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary inv-category">Surgical Implants</span></td>
                        <td class="inv-branch">Metro Dental Central</td>
                        <td><span class="fw-bold text-danger inv-stock">3 units</span></td>
                        <td class="inv-reorder">5 units</td>
                        <td><span class="small text-muted fw-mono inv-lot">LOT-2025-BLX</span></td>
                        <td><span class="small text-dark inv-expiry">Nov 2028</span></td>
                        <td><span class="badge bg-danger-subtle text-danger inv-status">Low Stock Warning</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openReorderModal('inv-row-1')" title="Reorder SKU"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditSkuModal('inv-row-1')" title="Edit SKU"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSkuRow('inv-row-1')" title="Decommission SKU"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 2 -->
                    <tr id="inv-row-2" data-sku="SKU-RES-104" data-name="3M™ Filtek™ Supreme Universal Composite (Shade A2)" data-supplier="3M Healthcare Oral Care" data-category="Restorative" data-branch="Metro Dental Central" data-stock="28" data-reorder="10" data-lot="LOT-88194-A2" data-expiry="Aug 2027">
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono inv-sku">SKU-RES-104</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block inv-name">3M™ Filtek™ Supreme Universal Composite (Shade A2)</span>
                            <small class="text-muted inv-supplier">Supplier: 3M Healthcare Oral Care</small>
                        </td>
                        <td><span class="badge bg-teal-subtle text-teal inv-category" style="background: #CCFBF1; color: #0F766E;">Restorative</span></td>
                        <td class="inv-branch">Metro Dental Central</td>
                        <td><span class="fw-bold text-success inv-stock">28 syringes</span></td>
                        <td class="inv-reorder">10 syringes</td>
                        <td><span class="small text-muted fw-mono inv-lot">LOT-88194-A2</span></td>
                        <td><span class="small text-dark inv-expiry">Aug 2027</span></td>
                        <td><span class="badge bg-success-subtle text-success inv-status">Optimal Stock</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openReorderModal('inv-row-2')" title="Reorder SKU"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditSkuModal('inv-row-2')" title="Edit SKU"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSkuRow('inv-row-2')" title="Decommission SKU"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 3 -->
                    <tr id="inv-row-3" data-sku="SKU-ANE-019" data-name="Septodont Septocaine® 4% (Articaine HCl + Epinephrine 1:100k)" data-supplier="Septodont Inc." data-category="Anesthetics" data-branch="All Branches" data-stock="140" data-reorder="50" data-lot="LOT-SEP-402" data-expiry="May 2026">
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono inv-sku">SKU-ANE-019</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block inv-name">Septodont Septocaine® 4% (Articaine HCl + Epinephrine 1:100k)</span>
                            <small class="text-muted inv-supplier">Supplier: Septodont Inc.</small>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning inv-category">Anesthetics</span></td>
                        <td class="inv-branch">All Branches</td>
                        <td><span class="fw-bold text-success inv-stock">140 carpules</span></td>
                        <td class="inv-reorder">50 carpules</td>
                        <td><span class="small text-muted fw-mono inv-lot">LOT-SEP-402</span></td>
                        <td><span class="small text-warning fw-bold inv-expiry">May 2026 (Expiring Soon)</span></td>
                        <td><span class="badge bg-warning-subtle text-warning inv-status">FIFO Rotation Alert</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openReorderModal('inv-row-3')" title="Reorder SKU"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditSkuModal('inv-row-3')" title="Edit SKU"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSkuRow('inv-row-3')" title="Decommission SKU"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 4 -->
                    <tr id="inv-row-4" data-sku="SKU-ORT-332" data-name="Ormco Damon™ Archwires (.014 Copper NiTi Upper/Lower)" data-supplier="Ormco Orthodontics" data-category="Orthodontics" data-branch="Westside Smile Studio" data-stock="65" data-reorder="20" data-lot="LOT-DM-014" data-expiry="Dec 2029">
                        <td class="ps-3"><span class="badge bg-light text-dark border fw-mono inv-sku">SKU-ORT-332</span></td>
                        <td>
                            <span class="fw-bold text-dark d-block inv-name">Ormco Damon™ Archwires (.014 Copper NiTi Upper/Lower)</span>
                            <small class="text-muted inv-supplier">Supplier: Ormco Orthodontics</small>
                        </td>
                        <td><span class="badge bg-info-subtle text-info inv-category">Orthodontics</span></td>
                        <td class="inv-branch">Westside Smile Studio</td>
                        <td><span class="fw-bold text-success inv-stock">65 packs</span></td>
                        <td class="inv-reorder">20 packs</td>
                        <td><span class="small text-muted fw-mono inv-lot">LOT-DM-014</span></td>
                        <td><span class="small text-dark inv-expiry">Dec 2029</span></td>
                        <td><span class="badge bg-success-subtle text-success inv-status">Optimal Stock</span></td>
                        <td class="text-end pe-3">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openReorderModal('inv-row-4')" title="Reorder SKU"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="openEditSkuModal('inv-row-4')" title="Edit SKU"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSkuRow('inv-row-4')" title="Decommission SKU"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal 1: Receive Delivery (PO) -->
<div class="modal fade" id="receiveDeliveryModal" tabindex="-1" aria-labelledby="receiveDeliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="receiveDeliveryModalLabel">
                    <i class="bi bi-box-arrow-in-down text-primary me-2"></i>Receive Clinical Supply Delivery (Purchase Order)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="receiveDeliveryForm" onsubmit="handleReceiveDelivery(event)">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Purchase Order (PO #) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="poNumber" required value="PO-2026-0941">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Supplier / Medical Distributor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="poSupplier" required placeholder="e.g. Henry Schein Dental / Straumann">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Material Name & Specifications <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="poMaterialName" required placeholder="e.g. Dentsply Sirona Prime&Bond Active Universal">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Category</label>
                            <select class="form-select" id="poCategory">
                                <option value="Restorative">Restorative</option>
                                <option value="Surgical Implants">Surgical Implants</option>
                                <option value="Anesthetics">Anesthetics</option>
                                <option value="Orthodontics">Orthodontics</option>
                                <option value="Hygiene & Sterilization">Hygiene & Sterilization</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Quantity Received <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="poQuantity" min="1" value="25" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Unit Type</label>
                            <input type="text" class="form-control" id="poUnit" value="syringes / boxes">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Assigned Clinic Branch</label>
                            <select class="form-select" id="poBranch">
                                <option value="Metro Dental Central">Metro Dental Central</option>
                                <option value="Westside Smile Studio">Westside Smile Studio</option>
                                <option value="North Dental Pavilion">North Dental Pavilion</option>
                                <option value="All Branches">All Branches</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Lot / Batch Identifier</label>
                            <input type="text" class="form-control" id="poLot" value="LOT-2026-RCV">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Expiry Date</label>
                            <input type="text" class="form-control" id="poExpiry" value="Oct 2028">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-check-circle me-1"></i>Check-in to Inventory
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Reorder SKU -->
<div class="modal fade" id="reorderSkuModal" tabindex="-1" aria-labelledby="reorderSkuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="reorderSkuModalLabel">
                    <i class="bi bi-cart-plus-fill text-primary me-2"></i>Express Reorder SKU
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reorderSkuForm" onsubmit="handleReorderSubmit(event)">
                <input type="hidden" id="reorderRowId">
                <div class="modal-body p-4">
                    <div class="bg-light p-3 rounded-3 mb-3 small">
                        <span class="text-muted d-block">Item SKU: <strong id="reorderSkuLabel" class="text-dark">SKU-IMP-849</strong></span>
                        <span class="fw-bold text-dark d-block" id="reorderNameLabel">Straumann BLX Implant</span>
                        <span class="text-muted d-block mt-1">Authorized Supplier: <strong id="reorderSupplierLabel" class="text-primary">Straumann AG</strong></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Reorder Quantity</label>
                        <input type="number" class="form-control" id="reorderQty" min="1" value="10" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Priority Dispatch</label>
                        <select class="form-select" id="reorderPriority">
                            <option value="Overnight Express (Emergency)">Overnight Express (Emergency 24-hr)</option>
                            <option value="Standard Ground (3-5 Days)" selected>Standard Ground (3-5 Days)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-send-fill me-1"></i>Dispatch Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Edit SKU Details -->
<div class="modal fade" id="editSkuModal" tabindex="-1" aria-labelledby="editSkuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="editSkuModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Stock SKU Configuration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSkuForm" onsubmit="handleEditSkuSubmit(event)">
                <input type="hidden" id="editSkuRowId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Material Name</label>
                            <input type="text" class="form-control" id="editSkuName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Current Quantity</label>
                            <input type="number" class="form-control" id="editSkuStock" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Reorder Threshold</label>
                            <input type="number" class="form-control" id="editSkuReorder" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Expiry Date</label>
                            <input type="text" class="form-control" id="editSkuExpiry" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Assigned Branch</label>
                            <select class="form-select" id="editSkuBranch">
                                <option value="Metro Dental Central">Metro Dental Central</option>
                                <option value="Westside Smile Studio">Westside Smile Studio</option>
                                <option value="North Dental Pavilion">North Dental Pavilion</option>
                                <option value="All Branches">All Branches</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--app-primary); border-color: var(--app-primary);">
                        <i class="bi bi-save me-1"></i>Save SKU Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showInventoryAlert(message, type = 'success') {
        const placeholder = document.getElementById('inventoryAlertPlaceholder');
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
    function filterInventoryTable() {
        const query = document.getElementById('inventorySearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#inventoryTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // 2. Receive Delivery Handler
    function handleReceiveDelivery(event) {
        event.preventDefault();
        const poNum = document.getElementById('poNumber').value.trim();
        const supplier = document.getElementById('poSupplier').value.trim();
        const name = document.getElementById('poMaterialName').value.trim();
        const category = document.getElementById('poCategory').value;
        const qty = parseInt(document.getElementById('poQuantity').value, 10) || 10;
        const branch = document.getElementById('poBranch').value;
        const lot = document.getElementById('poLot').value.trim();
        const expiry = document.getElementById('poExpiry').value.trim();

        const randSku = 'SKU-' + category.substring(0, 3).toUpperCase() + '-' + Math.floor(Math.random() * 800 + 100);
        const rowId = 'inv-row-' + Date.now();

        const rowHtml = `
            <tr id="${rowId}" data-sku="${randSku}" data-name="${name}" data-supplier="${supplier}" data-category="${category}" data-branch="${branch}" data-stock="${qty}" data-reorder="5" data-lot="${lot}" data-expiry="${expiry}">
                <td class="ps-3"><span class="badge bg-light text-dark border fw-mono inv-sku">${randSku}</span></td>
                <td>
                    <span class="fw-bold text-dark d-block inv-name">${name}</span>
                    <small class="text-muted inv-supplier">Supplier: ${supplier} (via ${poNum})</small>
                </td>
                <td><span class="badge bg-teal-subtle text-teal inv-category" style="background: #CCFBF1; color: #0F766E;">${category}</span></td>
                <td class="inv-branch">${branch}</td>
                <td><span class="fw-bold text-success inv-stock">${qty} units</span></td>
                <td class="inv-reorder">5 units</td>
                <td><span class="small text-muted fw-mono inv-lot">${lot}</span></td>
                <td><span class="small text-dark inv-expiry">${expiry}</span></td>
                <td><span class="badge bg-success-subtle text-success inv-status">Optimal Stock</span></td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary" onclick="openReorderModal('${rowId}')" title="Reorder SKU"><i class="bi bi-cart-plus me-1"></i>Reorder</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="openEditSkuModal('${rowId}')" title="Edit SKU"><i class="bi bi-pencil"></i></button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSkuRow('${rowId}')" title="Decommission SKU"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('inventoryTableBody').insertAdjacentHTML('afterbegin', rowHtml);

        const count = document.querySelectorAll('#inventoryTableBody tr').length;
        document.getElementById('statTrackedSkus').innerText = `${438 + count - 4} SKUs`;

        const modal = bootstrap.Modal.getInstance(document.getElementById('receiveDeliveryModal'));
        if (modal) modal.hide();
        document.getElementById('receiveDeliveryForm').reset();

        showInventoryAlert(`Delivery received! <strong>${qty} units</strong> of <strong>${name}</strong> checked into ${branch}.`);
    }

    // 3. Reorder SKU Modal
    function openReorderModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('reorderRowId').value = rowId;
        document.getElementById('reorderSkuLabel').innerText = row.getAttribute('data-sku');
        document.getElementById('reorderNameLabel').innerText = row.getAttribute('data-name');
        document.getElementById('reorderSupplierLabel').innerText = row.getAttribute('data-supplier');

        const modal = new bootstrap.Modal(document.getElementById('reorderSkuModal'));
        modal.show();
    }

    function handleReorderSubmit(event) {
        event.preventDefault();
        const rowId = document.getElementById('reorderRowId').value;
        const qty = document.getElementById('reorderQty').value;
        const row = document.getElementById(rowId);
        const name = row ? row.getAttribute('data-name') : 'Material';

        if (row) {
            const statusBadge = row.querySelector('.inv-status');
            statusBadge.className = 'badge bg-primary-subtle text-primary inv-status';
            statusBadge.innerText = 'PO Dispatched (' + qty + ' units)';
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('reorderSkuModal'));
        if (modal) modal.hide();

        showInventoryAlert(`Purchase Order for <strong>${qty} units</strong> of <strong>${name}</strong> dispatched to supplier!`);
    }

    // 4. Edit SKU Modal
    function openEditSkuModal(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;

        document.getElementById('editSkuRowId').value = rowId;
        document.getElementById('editSkuName').value = row.getAttribute('data-name');
        document.getElementById('editSkuStock').value = row.getAttribute('data-stock');
        document.getElementById('editSkuReorder').value = row.getAttribute('data-reorder');
        document.getElementById('editSkuExpiry').value = row.getAttribute('data-expiry');
        document.getElementById('editSkuBranch').value = row.getAttribute('data-branch');

        const modal = new bootstrap.Modal(document.getElementById('editSkuModal'));
        modal.show();
    }

    function handleEditSkuSubmit(event) {
        event.preventDefault();
        const rowId = document.getElementById('editSkuRowId').value;
        const row = document.getElementById(rowId);
        if (!row) return;

        const name = document.getElementById('editSkuName').value.trim();
        const stock = parseInt(document.getElementById('editSkuStock').value, 10);
        const reorder = parseInt(document.getElementById('editSkuReorder').value, 10);
        const expiry = document.getElementById('editSkuExpiry').value.trim();
        const branch = document.getElementById('editSkuBranch').value;

        row.setAttribute('data-name', name);
        row.setAttribute('data-stock', stock);
        row.setAttribute('data-reorder', reorder);
        row.setAttribute('data-expiry', expiry);
        row.setAttribute('data-branch', branch);

        row.querySelector('.inv-name').innerText = name;
        row.querySelector('.inv-stock').innerText = `${stock} units`;
        row.querySelector('.inv-reorder').innerText = `${reorder} units`;
        row.querySelector('.inv-expiry').innerText = expiry;
        row.querySelector('.inv-branch').innerText = branch;

        const statusBadge = row.querySelector('.inv-status');
        if (stock <= reorder) {
            statusBadge.className = 'badge bg-danger-subtle text-danger inv-status';
            statusBadge.innerText = 'Low Stock Warning';
        } else {
            statusBadge.className = 'badge bg-success-subtle text-success inv-status';
            statusBadge.innerText = 'Optimal Stock';
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('editSkuModal'));
        if (modal) modal.hide();

        showInventoryAlert(`SKU configuration for <strong>${name}</strong> saved successfully!`);
    }

    // 5. Delete SKU Row
    function deleteSkuRow(rowId) {
        const row = document.getElementById(rowId);
        if (!row) return;
        const name = row.getAttribute('data-name');
        if (confirm(`Decommission SKU for ${name}?`)) {
            row.remove();
            showInventoryAlert(`SKU for <strong>${name}</strong> decommissioned from inventory ledger.`, 'warning');
        }
    }
</script>
@endpush
