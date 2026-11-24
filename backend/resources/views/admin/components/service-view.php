<?php

declare(strict_types=1);

use App\Core\App;
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="<?= App::url('/admin/components/services') ?>" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Back to Services List
            </a>
            <span class="text-muted small">/</span>
            <span class="text-success small fw-semibold">Service Details</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-eye text-success me-2"></i> <?= htmlspecialchars($service['title'] ?? '') ?>
        </h2>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        <a href="<?= App::url('/admin/components/services/' . $service['id'] . '/edit') ?>" class="btn btn-brand rounded-pill shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit This Service
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($service['category'] ?? 'General') ?></span>
                    <?php if (!empty($service['badge'])): ?>
                        <span class="badge bg-success-subtle text-success"><?= htmlspecialchars($service['badge']) ?></span>
                    <?php endif; ?>
                </div>
                <span class="badge <?= ($service['is_active'] ?? true) ? 'bg-success' : 'bg-secondary' ?> rounded-pill px-3 py-1">
                    <?= ($service['is_active'] ?? true) ? 'Active' : 'Inactive' ?>
                </span>
            </div>
            <div class="card-body p-4">
                <h4 class="fw-bold text-dark mb-3"><?= htmlspecialchars($service['title'] ?? '') ?></h4>
                <div class="p-3 bg-light rounded-3 border mb-4">
                    <label class="form-label small fw-bold text-secondary d-block">Card Summary (Teaser)</label>
                    <p class="mb-0 text-dark"><?= nl2br(htmlspecialchars($service['summary'] ?? $service['description'] ?? '')) ?></p>
                </div>

                <label class="form-label small fw-bold text-secondary d-block">Full Clinical Inner Page Content</label>
                <div class="p-4 bg-white rounded-3 border text-secondary lh-lg">
                    <?= nl2br(htmlspecialchars($service['content'] ?? 'No detailed clinical content added yet. Click "Edit This Service" to add patient instructions, procedure overview, and clinical benefits.')) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0">Feature Photography & Icon</h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <?php if (!empty($service['feature_image'])): ?>
                        <img src="<?= htmlspecialchars($service['feature_image']) ?>" alt="Feature" class="w-100 rounded-3 shadow-sm border" style="height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div class="p-5 bg-light rounded-3 border text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2"></i> No Feature Image
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-success fs-3"><?= htmlspecialchars($service['icon'] ?? 'dentistry') ?></span>
                    <span class="fw-semibold"><code><?= htmlspecialchars($service['icon'] ?? 'dentistry') ?></code></span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0">Pricing & Operational Parameters</h6>
            </div>
            <div class="card-body p-4">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Starting Price:</span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($service['starting_price'] ?? '—') ?></span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Estimated Duration:</span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($service['duration'] ?? '—') ?></span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">CDT Code:</span>
                        <span class="font-monospace text-dark"><?= htmlspecialchars($service['cdt_code'] ?? '—') ?></span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Display Order:</span>
                        <span class="badge bg-light text-dark border"><?= htmlspecialchars((string)($service['display_order'] ?? 1)) ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">Inner Page Route:</span>
                        <code class="small">/treatments/<?= htmlspecialchars($service['slug'] ?? '') ?></code>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
