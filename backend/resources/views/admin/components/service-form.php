<?php

declare(strict_types=1);

use App\Core\App;

$isEdit = isset($service) && !empty($service['id']);
$formAction = $isEdit 
    ? App::url('/admin/components/services/' . $service['id'] . '/edit') 
    : App::url('/admin/components/services/create');
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/components/services') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Services List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold"><?= $isEdit ? 'Edit Service' : 'Create New Service' ?></span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi <?= $isEdit ? 'bi-pencil-square' : 'bi-plus-circle' ?> text-success me-2"></i>
            <?= $isEdit ? 'Edit Clinical Service: ' . htmlspecialchars($service['title'] ?? '') : 'Add New Dental Service' ?>
        </h2>
        <p class="text-muted small mb-0">
            Manage treatment parameters, inner page clinical content, feature imagery, pricing, and thumbnail display.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/admin/components/services') ?>" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-list me-1"></i> All Services
        </a>
    </div>
</div>

<form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">
    <div class="row g-4">
        <!-- Main Service Content Column (Left) -->
        <div class="col-lg-8">
            <!-- 1. Basic Details Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">1. Service Identity & Titles</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Service Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="serviceTitle" class="form-control fw-bold" 
                                   value="<?= htmlspecialchars($service['title'] ?? '') ?>" 
                                   placeholder="e.g. Routine Dental Examinations" required
                                   onkeyup="autoGenerateSlug(this.value)">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Slug (URL Route) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="serviceSlug" class="form-control font-monospace" 
                                   value="<?= htmlspecialchars($service['slug'] ?? '') ?>" 
                                   placeholder="routine-examinations" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Clinical Category</label>
                            <select name="category" class="form-select">
                                <?php
                                $categories = [
                                    'General Dentistry', 'Hygiene', 'Restorations', 
                                    'Endodontics', 'Prosthetics', 'Orthodontics', 
                                    'Oral Surgery', 'Cosmetic Dentistry', 'Emergency'
                                ];
                                $currCat = $service['category'] ?? 'General Dentistry';
                                foreach ($categories as $cat): ?>
                                    <option value="<?= $cat ?>" <?= $currCat === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Badge Tag</label>
                            <input type="text" name="badge" class="form-control" 
                                   value="<?= htmlspecialchars($service['badge'] ?? '') ?>" 
                                   placeholder="e.g. Preventive, Airflow Polish, Same-Day">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Short Summary / Description (for Cards & Thumbnails) <span class="text-danger">*</span></label>
                            <textarea name="summary" class="form-control" rows="2" required 
                                      placeholder="Brief summary appearing on homepage cards and search results..."><?= htmlspecialchars($service['summary'] ?? $service['description'] ?? '') ?></textarea>
                            <small class="text-muted">Recommended: 100 - 160 characters for optimal card layouts.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Inner Page Full Clinical Content Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">2. Inner Page Clinical Narrative & Patient Info</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Inner Page Body Content</label>
                        <textarea name="content" class="form-control" rows="8" 
                                  placeholder="Provide detailed clinical information about this procedure, what patients can expect during the appointment, aftercare instructions, and benefits..."><?= htmlspecialchars($service['content'] ?? '') ?></textarea>
                        <small class="text-muted">Displayed on the dedicated service inner page (e.g. <code>/treatments/<?= htmlspecialchars($service['slug'] ?? 'service-slug') ?></code>).</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Meta Column (Right) -->
        <div class="col-lg-4">
            <!-- Status & Order Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Publishing & Order</h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="serviceActive" 
                               <?= ($service['is_active'] ?? true) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="serviceActive">Active on Website</label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Display Sort Order</label>
                        <input type="number" name="display_order" class="form-control fw-bold" 
                               value="<?= htmlspecialchars((string)($service['display_order'] ?? 1)) ?>" min="1">
                        <small class="text-muted">Controls card order on homepage and inner service listings.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon Symbol (Material Symbols)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined fs-5" id="iconDisplay">
                                    <?= htmlspecialchars($service['icon'] ?? 'dentistry') ?>
                                </span>
                            </span>
                            <input type="text" name="icon" id="iconInput" class="form-control font-monospace" 
                                   value="<?= htmlspecialchars($service['icon'] ?? 'dentistry') ?>" 
                                   onkeyup="document.getElementById('iconDisplay').textContent = this.value || 'dentistry'">
                        </div>
                        <small class="text-muted">e.g. <code>dentistry</code>, <code>clean_hands</code>, <code>healing</code>, <code>vital_signs</code>, <code>crown</code>, <code>auto_fix_high</code>, <code>medical_services</code>, <code>e911_emergency</code></small>
                    </div>
                </div>
            </div>

            <!-- Feature Image Upload Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Feature Photography</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars(!empty($service['feature_image']) ? $service['feature_image'] : App::url('/images/hero-patient.jpg')) ?>" 
                             alt="Feature Preview" class="preview-img-box w-100" style="height: 160px; object-fit: cover;" id="serviceFeaturePrev">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Upload Feature Image File</label>
                        <input type="file" name="feature_image_file" class="form-control form-control-sm" accept="image/*" 
                               onchange="previewImage(this, 'serviceFeaturePrev')">
                    </div>
                    <div class="text-start">
                        <label class="form-label small fw-bold">Or Direct Image URL / Path</label>
                        <input type="text" name="feature_image" class="form-control form-control-sm font-monospace" 
                               value="<?= htmlspecialchars($service['feature_image'] ?? '') ?>" 
                               placeholder="/images/hero-patient.jpg">
                    </div>
                </div>
            </div>

            <!-- Pricing & Duration Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Pricing & Time</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Starting Price / Tariff</label>
                        <input type="text" name="starting_price" class="form-control" 
                               value="<?= htmlspecialchars($service['starting_price'] ?? '') ?>" 
                               placeholder="e.g. From £65.00 or NHS Band 1 (£26.80)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estimated Duration</label>
                        <input type="text" name="duration" class="form-control" 
                               value="<?= htmlspecialchars($service['duration'] ?? '') ?>" 
                               placeholder="e.g. 30 mins or 45 mins">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">CDT / Dental Code</label>
                        <input type="text" name="cdt_code" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($service['cdt_code'] ?? '') ?>" 
                               placeholder="e.g. D0120">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Action Footer -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <a href="<?= App::url('/admin/components/services') ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
            Cancel
        </a>
        <button type="submit" class="btn btn-brand px-5 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update Service' : 'Save New Service' ?>
        </button>
    </div>
</form>

<script>
function autoGenerateSlug(title) {
    <?php if (!$isEdit): ?>
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('serviceSlug').value = slug;
    <?php endif; ?>
}

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
