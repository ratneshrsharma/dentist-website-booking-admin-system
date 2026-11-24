<?php

declare(strict_types=1);

use App\Core\App;

$contact = $home['contact_section'] ?? [];
$hours = $contact['hours'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Hours & Map</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-geo-alt text-success me-2"></i> Hours & Clinic Location Map Component
        </h2>
        <p class="text-muted small mb-0">Manage surgery physical address, patient reception phone, clinical hours schedule, and location map photography.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/contact') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/contact') ?>" method="POST" enctype="multipart/form-data">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Clinic Details & Reception Contact Info</h5>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($contact['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Component Page ID / Anchor</label>
                    <input type="text" name="component_id" class="form-control" value="<?= htmlspecialchars($contact['component_id'] ?? 'clinic-hours-map') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Custom CSS Class</label>
                    <input type="text" name="custom_class" class="form-control" value="<?= htmlspecialchars($contact['custom_class'] ?? 'hours-map-block') ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Section Headline Title</label>
                    <input type="text" name="title" class="form-control fw-bold" value="<?= htmlspecialchars($contact['title'] ?? 'Visit Our Modern Surgery in Birmingham B27') ?>" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Physical Street Address</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($contact['address'] ?? '1078 Warwick Road, Acocks Green, Birmingham B27 6BH') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Reception Telephone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? '+44 121 765 2870') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Reception Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? 'acocksgreendentalpractice@gmail.com') ?>" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Operating Hours & Map Photo Card -->
    <div class="row g-4 mb-4">
        <!-- Operating Hours Schedule -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Surgery Opening Hours</h5>
                </div>
                <div class="card-body p-4">
                    <?php foreach ($hours as $idx => $h): ?>
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Day Range #<?= $idx + 1 ?></label>
                                <input type="text" name="hours_days[]" class="form-control form-control-sm fw-semibold" value="<?= htmlspecialchars($h['day_range'] ?? '') ?>">
                            </div>
                            <div>
                                <label class="form-label small fw-bold">Hours Open</label>
                                <input type="text" name="hours_times[]" class="form-control form-control-sm" value="<?= htmlspecialchars($h['hours'] ?? '') ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Map & Exterior Photo -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">Surgery Location Map / Photo</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <img src="<?= htmlspecialchars($contact['map_image'] ?? App::url('/images/surgery-clinic.jpg')) ?>" 
                             alt="Map Photo" class="preview-img-box w-100" style="height: 180px; object-fit: cover;" id="mapPhotoPrev">
                    </div>
                    <label class="form-label fw-semibold">Upload New Map / Clinic Image</label>
                    <input type="file" name="map_image_file" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'mapPhotoPrev')">
                    <label class="form-label small text-muted">Or Direct Image URL / Path</label>
                    <input type="text" name="map_image_manual" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($contact['map_image'] ?? '') ?>" placeholder="/images/surgery-clinic.jpg">
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted small">Hours & contact details update across all website footer & contact blocks.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Hours & Map Component
        </button>
    </div>
</form>

<script>
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
