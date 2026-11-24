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
            <i class="bi bi-star text-success me-2"></i> Patient Testimonials & Google Reviews
        </h2>
        <p class="text-muted small mb-0">Manage customer feedback, add/delete/reorder testimonials, and connect directly with Google Reviews.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="<?= App::url('/#reviews') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
        <button type="submit" form="testimonialsForm" class="btn btn-brand rounded-pill px-4 shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Changes
        </button>
    </div>
</div>

<form action="<?= App::url('/admin/components/testimonials') ?>" method="POST" id="testimonialsForm">
    <!-- 1. Google Reviews Connection & Aggregate Metrics Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="p-2 rounded-3 bg-danger-subtle text-danger">
                    <i class="bi bi-google fs-5"></i>
                </span>
                <div>
                    <h5 class="fw-bold mb-0">Google Reviews & Aggregate Metrics</h5>
                    <small class="text-muted">Connect your Google Business Profile & display real star ratings</small>
                </div>
            </div>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($testi['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Average Google Rating</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-warning"><i class="bi bi-star-fill"></i></span>
                        <input type="number" step="0.1" min="1" max="5" name="average_rating" class="form-control fw-bold" 
                               value="<?= htmlspecialchars((string)($testi['average_rating'] ?? 4.9)) ?>">
                        <span class="input-group-text bg-light">/ 5.0</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Total Verified Reviews Count</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary"><i class="bi bi-chat-heart"></i></span>
                        <input type="number" name="total_reviews" class="form-control fw-bold" 
                               value="<?= htmlspecialchars((string)($testi['total_reviews'] ?? 148)) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Minimum Rating Display Filter</label>
                    <select name="google_min_rating" class="form-select">
                        <option value="5" <?= ($testi['google_min_rating'] ?? 4) == 5 ? 'selected' : '' ?>>5 Stars Only</option>
                        <option value="4" <?= ($testi['google_min_rating'] ?? 4) == 4 ? 'selected' : '' ?>>4 Stars and Above</option>
                        <option value="3" <?= ($testi['google_min_rating'] ?? 4) == 3 ? 'selected' : '' ?>>3 Stars and Above</option>
                    </select>
                </div>

                <!-- Google Integration Fields -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google Business Direct Review URL</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-danger"><i class="bi bi-link-45deg"></i></span>
                        <input type="url" name="google_reviews_url" class="form-control" 
                               value="<?= htmlspecialchars($testi['google_reviews_url'] ?? 'https://g.page/review') ?>" 
                               placeholder="https://g.page/r/your-clinic/review">
                    </div>
                    <small class="text-muted">Target link for the "Leave a Google Review" button on the website.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google Place ID (API Sync)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-geo-alt-fill"></i></span>
                        <input type="text" name="google_place_id" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($testi['google_place_id'] ?? '') ?>" 
                               placeholder="ChIJN1t_tDeuEmsRUsoyG83frY4">
                    </div>
                    <small class="text-muted">Optional: Connect via Google Places API to sync latest 5-star patient reviews automatically.</small>
                </div>

                <div class="col-12 mt-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="google_auto_sync" id="googleSync" <?= !empty($testi['google_auto_sync']) ? 'checked' : '' ?>>
                        <label class="form-check-label small fw-semibold" for="googleSync">
                            Enable live Google Reviews Badge & auto-refresh from Google Places API
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Testimonials Management List with Add / Delete / Reorder -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-0">Published Patient Testimonials</h5>
                <small class="text-muted">Add, delete, or change order of patient reviews shown on the website</small>
            </div>
            <div>
                <button type="button" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="addTestimonialCard()">
                    <i class="bi bi-plus-circle me-1"></i> Add New Testimonial
                </button>
            </div>
        </div>

        <div class="card-body p-4 bg-light">
            <div class="row g-4" id="testimonialsContainer">
                <?php foreach ($items as $idx => $r): ?>
                    <div class="col-md-6 testimonial-card-item" data-index="<?= $idx ?>">
                        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative">
                            <!-- Card Header Toolbar (Reorder, Active, Delete) -->
                            <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="moveTestimonialUp(this)" title="Move Up">
                                            <i class="bi bi-arrow-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="moveTestimonialDown(this)" title="Move Down">
                                            <i class="bi bi-arrow-down"></i>
                                        </button>
                                    </div>
                                    <span class="badge bg-dark-subtle text-dark font-monospace order-badge">
                                        #<?= $idx + 1 ?>
                                    </span>
                                    <input type="hidden" name="review_orders[]" class="order-input" value="<?= $idx + 1 ?>">
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" name="review_active[]" value="<?= $idx ?>" 
                                               id="revActive<?= $idx ?>" <?= ($r['is_active'] ?? true) ? 'checked' : '' ?>>
                                        <label class="form-check-label small fw-semibold" for="revActive<?= $idx ?>">Active</label>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeTestimonialCard(this)" title="Delete Testimonial">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Inputs -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="review_names[]" class="form-control form-control-sm fw-bold" 
                                           value="<?= htmlspecialchars($r['name'] ?? '') ?>" placeholder="e.g. Sarah Thompson" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Location / Town</label>
                                    <input type="text" name="review_locations[]" class="form-control form-control-sm" 
                                           value="<?= htmlspecialchars($r['location'] ?? 'Acocks Green') ?>" placeholder="e.g. Birmingham">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold">Treatment Received</label>
                                    <input type="text" name="review_treatments[]" class="form-control form-control-sm" 
                                           value="<?= htmlspecialchars($r['treatment'] ?? 'Routine Examination') ?>" placeholder="e.g. Dental Hygiene & Airflow">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold">Star Rating</label>
                                    <select name="review_ratings[]" class="form-select form-select-sm fw-bold text-warning">
                                        <option value="5" <?= ($r['rating'] ?? 5) == 5 ? 'selected' : '' ?>>★★★★★ (5 Stars)</option>
                                        <option value="4" <?= ($r['rating'] ?? 5) == 4 ? 'selected' : '' ?>>★★★★☆ (4 Stars)</option>
                                        <option value="3" <?= ($r['rating'] ?? 5) == 3 ? 'selected' : '' ?>>★★★☆☆ (3 Stars)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Patient Comment / Story</label>
                                    <textarea name="review_comments[]" class="form-control form-control-sm" rows="3" 
                                              placeholder="What did the patient share about their experience?"><?= htmlspecialchars($r['comment'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Sticky Bottom Save Bar -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <a href="<?= App::url('/admin/dashboard') ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
            Back to Dashboard
        </a>
        <button type="submit" class="btn btn-brand px-5 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Testimonials & Google Settings
        </button>
    </div>
</form>

<script>
let testimonialCount = <?= count($items) ?>;

function addTestimonialCard() {
    testimonialCount++;
    const container = document.getElementById('testimonialsContainer');
    const newIdx = container.children.length;

    const col = document.createElement('div');
    col.className = 'col-md-6 testimonial-card-item';
    col.setAttribute('data-index', newIdx);

    col.innerHTML = `
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative">
            <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary" onclick="moveTestimonialUp(this)" title="Move Up">
                            <i class="bi bi-arrow-up"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="moveTestimonialDown(this)" title="Move Down">
                            <i class="bi bi-arrow-down"></i>
                        </button>
                    </div>
                    <span class="badge bg-dark-subtle text-dark font-monospace order-badge">
                        #${newIdx + 1}
                    </span>
                    <input type="hidden" name="review_orders[]" class="order-input" value="${newIdx + 1}">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="review_active[]" value="${newIdx}" id="revActive${newIdx}" checked>
                        <label class="form-check-label small fw-semibold" for="revActive${newIdx}">Active</label>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="removeTestimonialCard(this)" title="Delete Testimonial">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Patient Name <span class="text-danger">*</span></label>
                    <input type="text" name="review_names[]" class="form-control form-control-sm fw-bold" placeholder="e.g. David Miller" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Location / Town</label>
                    <input type="text" name="review_locations[]" class="form-control form-control-sm" value="Acocks Green">
                </div>
                <div class="col-md-7">
                    <label class="form-label small fw-bold">Treatment Received</label>
                    <input type="text" name="review_treatments[]" class="form-control form-control-sm" placeholder="e.g. Routine Examination">
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Star Rating</label>
                    <select name="review_ratings[]" class="form-select form-select-sm fw-bold text-warning">
                        <option value="5" selected>★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Patient Comment / Story</label>
                    <textarea name="review_comments[]" class="form-control form-control-sm" rows="3" placeholder="Enter patient feedback quote..."></textarea>
                </div>
            </div>
        </div>
    `;

    container.appendChild(col);
    renumberTestimonials();
}

function removeTestimonialCard(btn) {
    const cardCol = btn.closest('.testimonial-card-item');
    if (confirm('Are you sure you want to delete this testimonial?')) {
        cardCol.remove();
        renumberTestimonials();
    }
}

function moveTestimonialUp(btn) {
    const cardCol = btn.closest('.testimonial-card-item');
    const prev = cardCol.previousElementSibling;
    if (prev) {
        cardCol.parentNode.insertBefore(cardCol, prev);
        renumberTestimonials();
    }
}

function moveTestimonialDown(btn) {
    const cardCol = btn.closest('.testimonial-card-item');
    const next = cardCol.nextElementSibling;
    if (next) {
        cardCol.parentNode.insertBefore(next, cardCol);
        renumberTestimonials();
    }
}

function renumberTestimonials() {
    const container = document.getElementById('testimonialsContainer');
    const cards = container.querySelectorAll('.testimonial-card-item');
    cards.forEach((card, idx) => {
        const badge = card.querySelector('.order-badge');
        const input = card.querySelector('.order-input');
        const checkbox = card.querySelector('input[type="checkbox"]');
        if (badge) badge.textContent = '#' + (idx + 1);
        if (input) input.value = idx + 1;
        if (checkbox) checkbox.value = idx;
    });
}
</script>
