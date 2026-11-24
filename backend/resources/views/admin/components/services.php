<?php

declare(strict_types=1);

use App\Core\App;

$intro = $home['services_intro'] ?? [];
$services = $services ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-7">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Services Catalog & Inner Pages</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-grid-3x3-gap text-success me-2"></i> Clinical Services Management
        </h2>
        <p class="text-muted small mb-0">
            Manage treatment inner pages with full CRUD (Add, Edit, View, Delete), reorder display priority, and toggle active/inactive status.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        <a href="<?= App::url('/#services') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview on Site
        </a>
        <a href="<?= App::url('/admin/components/services/create') ?>" class="btn btn-brand rounded-pill shadow">
            <i class="bi bi-plus-circle me-1"></i> Add New Service
        </a>
    </div>
</div>

<!-- 1. Section Header & Anchor Configuration Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Homepage Services Section Intro & Anchor</h5>
        <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#introSettingsCollapse">
            <i class="bi bi-gear me-1"></i> Edit Section Intro
        </button>
    </div>
    <div class="collapse show" id="introSettingsCollapse">
        <form action="<?= App::url('/admin/components/services/intro') ?>" method="POST">
            <div class="card-body p-4 border-bottom">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Section Anchor ID</label>
                        <input type="text" name="component_id" class="form-control form-control-sm font-monospace" 
                               value="<?= htmlspecialchars($intro['component_id'] ?? 'services') ?>" placeholder="services">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Custom CSS Class</label>
                        <input type="text" name="custom_class" class="form-control form-control-sm font-monospace" 
                               value="<?= htmlspecialchars($intro['custom_class'] ?? 'services-grid-wrapper') ?>" placeholder="services-grid-wrapper">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Eyebrow Tagline</label>
                        <input type="text" name="eyebrow" class="form-control form-control-sm" 
                               value="<?= htmlspecialchars($intro['eyebrow'] ?? 'Our Practice Services') ?>" placeholder="Our Practice Services">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Section Headline Title</label>
                        <input type="text" name="title" class="form-control form-control-sm fw-bold" 
                               value="<?= htmlspecialchars($intro['title'] ?? 'Discover Quality Dental Care in Acocks Green') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Section Subtitle Summary</label>
                        <input type="text" name="subtitle" class="form-control form-control-sm" 
                               value="<?= htmlspecialchars($intro['subtitle'] ?? 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.') ?>">
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3">
                        <i class="bi bi-check2 me-1"></i> Save Intro Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 2. Services Data Table Card with Reordering & CRUD -->
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">Managed Clinical Services List</h5>
            <small class="text-muted">Total: <?= count($services) ?> Treatments Registered</small>
        </div>
        <div>
            <button type="submit" form="reorderForm" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-arrow-down-up me-1"></i> Save Custom Orders
            </button>
        </div>
    </div>

    <form action="<?= App::url('/admin/components/services/reorder') ?>" method="POST" id="reorderForm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Order</th>
                        <th style="width: 60px;">Icon</th>
                        <th style="width: 80px;">Photo</th>
                        <th style="width: 25%;">Service Title & Category</th>
                        <th style="width: 15%;">Badge Tag</th>
                        <th style="width: 15%;">Starting Price</th>
                        <th style="width: 10%;">Status</th>
                        <th class="text-end pe-4" style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No clinical services found. Click "Add New Service" above to create one.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $s): ?>
                            <tr>
                                <td class="ps-4">
                                    <input type="hidden" name="service_ids[]" value="<?= $s['id'] ?>">
                                    <input type="number" name="display_orders[]" 
                                           class="form-control form-control-sm text-center fw-bold" 
                                           value="<?= htmlspecialchars((string)($s['display_order'] ?? 1)) ?>" 
                                           style="width: 65px;" min="1">
                                </td>
                                <td>
                                    <span class="p-2 rounded-3 bg-light border text-success d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <span class="material-symbols-outlined fs-5">
                                            <?= htmlspecialchars($s['icon'] ?? 'dentistry') ?>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($s['feature_image'])): ?>
                                        <img src="<?= htmlspecialchars($s['feature_image']) ?>" alt="Thumbnail" 
                                             class="rounded-3 shadow-sm border" style="width: 50px; height: 40px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-light border text-muted d-flex align-items-center justify-content-center small" style="width: 50px; height: 40px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block"><?= htmlspecialchars($s['title']) ?></span>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 11px;">
                                            <?= htmlspecialchars($s['category'] ?? 'General') ?>
                                        </span>
                                        <code class="text-muted small">/treatments/<?= htmlspecialchars($s['slug']) ?></code>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($s['badge'])): ?>
                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                            <?= htmlspecialchars($s['badge']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-dark"><?= htmlspecialchars($s['starting_price'] ?? 'Free Consult') ?></span>
                                    <?php if (!empty($s['duration'])): ?>
                                        <small class="d-block text-muted"><?= htmlspecialchars($s['duration']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?= App::url('/admin/components/services/' . $s['id'] . '/toggle') ?>" method="POST" class="d-inline">
                                        <button type="submit" class="badge rounded-pill border-0 <?= ($s['is_active'] ?? true) ? 'bg-success text-white' : 'bg-secondary text-white' ?>" 
                                                title="Click to toggle status" style="cursor: pointer; padding: 6px 12px;">
                                            <i class="bi <?= ($s['is_active'] ?? true) ? 'bi-check-circle-fill' : 'bi-pause-circle' ?> me-1"></i>
                                            <?= ($s['is_active'] ?? true) ? 'Active' : 'Inactive' ?>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="<?= App::url('/admin/components/services/' . $s['id'] . '/view') ?>" 
                                           class="btn btn-outline-secondary btn-sm" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= App::url('/admin/components/services/' . $s['id'] . '/edit') ?>" 
                                           class="btn btn-outline-primary btn-sm" title="Edit Service">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" title="Delete Service" 
                                                onclick="confirmDelete(<?= $s['id'] ?>, '<?= htmlspecialchars(addslashes($s['title'])) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Delete Service
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-1">Are you sure you want to permanently delete this service?</p>
                <p class="fw-bold text-dark fs-5 mb-0" id="deleteServiceName"></p>
                <small class="text-muted d-block mt-2">This will remove the treatment from all homepage cards, sidebar listings, and inner page routes.</small>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteServiceForm" method="POST" action="">
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash me-1"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('deleteServiceName').textContent = title;
    document.getElementById('deleteServiceForm').action = '<?= App::url('/admin/components/services/') ?>' + id + '/delete';
    const modal = new bootstrap.Modal(document.getElementById('deleteServiceModal'));
    modal.show();
}
</script>
