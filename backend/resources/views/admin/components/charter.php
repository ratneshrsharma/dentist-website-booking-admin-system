<?php

declare(strict_types=1);

use App\Core\App;

$charter = $home['safety_charter'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Safety Charter</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-shield-check text-success me-2"></i> NHS Safety Charter Component
        </h2>
        <p class="text-muted small mb-0">Manage clinical compliance, sexual safety charter declaration, badge details, and external standard links.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/about-us#charter') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/charter') ?>" method="POST">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Safety Charter Content & Signatory Settings</h5>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($charter['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Component Page ID / Anchor</label>
                    <input type="text" name="component_id" class="form-control" value="<?= htmlspecialchars($charter['component_id'] ?? 'safety-charter') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Custom CSS Class</label>
                    <input type="text" name="custom_class" class="form-control" value="<?= htmlspecialchars($charter['custom_class'] ?? 'safety-charter-block') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Charter Badge Tag</label>
                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($charter['badge'] ?? 'Official NHS Charter') ?>" placeholder="Official NHS Charter">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Charter Headline Title</label>
                    <input type="text" name="title" class="form-control fw-bold" value="<?= htmlspecialchars($charter['title'] ?? 'NHS Sexual Safety Charter Signatory') ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Charter Statement Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($charter['description'] ?? 'Acocks Green Dental Practice is an official signatory of the NHS Sexual Safety Charter, championing zero tolerance for harassment and fostering a safe, respectful clinical environment.') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Action Link Text</label>
                    <input type="text" name="link_text" class="form-control" value="<?= htmlspecialchars($charter['link_text'] ?? 'Read Our Safety Standards') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Action Target Link URL</label>
                    <input type="text" name="link_url" class="form-control font-monospace" value="<?= htmlspecialchars($charter['link_url'] ?? 'https://www.england.nhs.uk/publication/sexual-safety-in-healthcare-charter/') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted small">Synchronized with patient portal and compliance footers.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Safety Charter Component
        </button>
    </div>
</form>
