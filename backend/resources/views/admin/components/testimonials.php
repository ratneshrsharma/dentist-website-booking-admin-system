<?php

declare(strict_types=1);

use App\Core\App;

$testi = $home['testimonials'] ?? [];
$items = $testi['items'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Patient Testimonials</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-star text-success me-2"></i> Patient Testimonials Component
        </h2>
        <p class="text-muted small mb-0">Manage Google Review ratings, aggregate patient satisfaction scores, and authentic patient feedback quotes.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/#reviews') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/testimonials') ?>" method="POST">
    <!-- Component Meta Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Aggregate Review Metrics</h5>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($testi['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Average Google Review Rating</label>
                    <input type="number" step="0.1" min="1" max="5" name="average_rating" class="form-control fw-bold" value="<?= htmlspecialchars((string)($testi['average_rating'] ?? 4.9)) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Verified Reviews Count</label>
                    <input type="number" name="total_reviews" class="form-control fw-bold" value="<?= htmlspecialchars((string)($testi['total_reviews'] ?? 148)) ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Review Items List -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0">Published Patient Testimonials</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <?php foreach ($items as $idx => $r): ?>
                    <div class="col-md-6">
                        <div class="card border rounded-4 shadow-none bg-light p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-warning-subtle text-dark fw-bold">Testimonial #<?= $idx + 1 ?></span>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="review_active[]" value="<?= $idx ?>" id="revActive<?= $idx ?>" <?= ($r['is_active'] ?? true) ? 'checked' : '' ?>>
                                    <label class="form-check-label small fw-semibold" for="revActive<?= $idx ?>">Active</label>
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Patient Name</label>
                                    <input type="text" name="review_names[]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($r['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Location / Town</label>
                                    <input type="text" name="review_locations[]" class="form-control form-control-sm" value="<?= htmlspecialchars($r['location'] ?? 'Acocks Green') ?>">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Treatment Received</label>
                                    <input type="text" name="review_treatments[]" class="form-control form-control-sm" value="<?= htmlspecialchars($r['treatment'] ?? 'General Dentistry') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Star Rating (1-5)</label>
                                    <input type="number" min="1" max="5" name="review_ratings[]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars((string)($r['rating'] ?? 5)) ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Patient Comment / Story</label>
                                    <textarea name="review_comments[]" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($r['comment'] ?? '') ?></textarea>
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
        <span class="text-muted small">Testimonial updates appear instantly on the home slider.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Patient Testimonials
        </button>
    </div>
</form>
