<?php

declare(strict_types=1);

use App\Core\App;

$intro = $home['services_intro'] ?? [];
$services = $home['featured_services'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Services Grid</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-grid-3x3-gap text-success me-2"></i> Services Grid Component
        </h2>
        <p class="text-muted small mb-0">Configure section identifier, custom CSS class, title, summary, and treatment cards with icons & featured photos.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/#services') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/services') ?>" method="POST" enctype="multipart/form-data">
    <!-- Component Meta Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Component Settings & Layout Attributes</h5>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($intro['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Component Page ID / Anchor</label>
                    <input type="text" name="component_id" class="form-control" value="<?= htmlspecialchars($intro['component_id'] ?? 'services') ?>" placeholder="services">
                    <small class="text-muted">HTML anchor ID (e.g. #services)</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Custom CSS Class</label>
                    <input type="text" name="custom_class" class="form-control" value="<?= htmlspecialchars($intro['custom_class'] ?? 'services-grid-wrapper') ?>" placeholder="services-grid-wrapper">
                    <small class="text-muted">Custom modular LESS / CSS hook</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Eyebrow Badge</label>
                    <input type="text" name="eyebrow" class="form-control" value="<?= htmlspecialchars($intro['eyebrow'] ?? 'Our Practice Services') ?>" placeholder="Our Practice Services">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Section Headline Title</label>
                    <input type="text" name="title" class="form-control fw-bold" value="<?= htmlspecialchars($intro['title'] ?? 'Discover Quality Dental Care in Acocks Green') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Summary / Subtitle Content</label>
                    <textarea name="subtitle" class="form-control" rows="2"><?= htmlspecialchars($intro['subtitle'] ?? 'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment Cards List -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Managed Clinical Services (<?= count($services) ?> Total)</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <?php foreach ($services as $idx => $s): ?>
                    <div class="col-md-6">
                        <div class="card border rounded-4 shadow-none bg-light p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success-subtle text-success fw-bold">Service #<?= $idx + 1 ?></span>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="service_active[]" value="<?= $idx ?>" id="srvActive<?= $idx ?>" <?= ($s['is_active'] ?? true) ? 'checked' : '' ?>>
                                    <label class="form-check-label small fw-semibold" for="srvActive<?= $idx ?>">Active</label>
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Service Title</label>
                                    <input type="text" name="service_titles[]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($s['title'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Slug URL</label>
                                    <input type="text" name="service_slugs[]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($s['slug'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Category</label>
                                    <input type="text" name="service_categories[]" class="form-control form-control-sm" value="<?= htmlspecialchars($s['category'] ?? 'General Dentistry') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Badge Tag</label>
                                    <input type="text" name="service_badges[]" class="form-control form-control-sm" value="<?= htmlspecialchars($s['badge'] ?? '') ?>" placeholder="Preventive">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Icon Symbol</label>
                                    <input type="text" name="service_icons[]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($s['icon'] ?? 'dentistry') ?>" placeholder="dentistry">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Summary Description</label>
                                    <textarea name="service_descs[]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($s['description'] ?? '') ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Feature Image File</label>
                                    <input type="file" name="service_image_files[<?= $idx ?>]" class="form-control form-control-sm" accept="image/*">
                                    <input type="hidden" name="service_images[<?= $idx ?>]" value="<?= htmlspecialchars($s['feature_image'] ?? '') ?>">
                                    <?php if (!empty($s['feature_image'])): ?>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="<?= htmlspecialchars($s['feature_image']) ?>" alt="Feature" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            <small class="text-muted text-truncate"><?= htmlspecialchars($s['feature_image']) ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted small">All changes are immediately reflected on the live website and REST API.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Services Grid Component
        </button>
    </div>
</form>
