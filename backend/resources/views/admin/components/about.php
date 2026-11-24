<?php

declare(strict_types=1);

use App\Core\App;

$about = $home['about_summary'] ?? [];
$storyText = implode("\n\n", $about['story_paragraphs'] ?? []);
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">About & Clinic Photos</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-info-circle text-success me-2"></i> About & Clinic Photos Component
        </h2>
        <p class="text-muted small mb-0">Manage surgery history, experience metrics, story narrative, and surgery consultation photographs.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/about-us') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/about') ?>" method="POST" enctype="multipart/form-data">
    <!-- Component Meta Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Component Settings & Layout Attributes</h5>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_active" id="compActive" <?= ($about['is_active'] ?? true) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold small" for="compActive">Section Active on Frontend</label>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Component Page ID / Anchor</label>
                    <input type="text" name="component_id" class="form-control" value="<?= htmlspecialchars($about['component_id'] ?? 'about-surgery') ?>" placeholder="about-surgery">
                    <small class="text-muted">HTML anchor ID (e.g. #about)</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Custom CSS Class</label>
                    <input type="text" name="custom_class" class="form-control" value="<?= htmlspecialchars($about['custom_class'] ?? 'about-surgery-block') ?>" placeholder="about-surgery-block">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" class="form-control font-monospace" value="<?= htmlspecialchars($about['slug'] ?? 'about-us') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Eyebrow Tagline</label>
                    <input type="text" name="eyebrow" class="form-control" value="<?= htmlspecialchars($about['eyebrow'] ?? 'About Acocks Green Practice') ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Section Title</label>
                    <input type="text" name="title" class="form-control fw-bold" value="<?= htmlspecialchars($about['title'] ?? 'Dedicated Dental Professionals Serving Birmingham B27') ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Summary Subtitle</label>
                    <textarea name="subtitle" class="form-control" rows="2"><?= htmlspecialchars($about['subtitle'] ?? 'Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Experience Years Stat</label>
                    <input type="text" name="experience_years" class="form-control fw-bold" value="<?= htmlspecialchars($about['experience_years'] ?? '20+') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Patients Served Stat</label>
                    <input type="text" name="patients_served" class="form-control fw-bold" value="<?= htmlspecialchars($about['patients_served'] ?? '5,000+') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Story Paragraphs (Enter one per line)</label>
                    <textarea name="story_paragraphs" class="form-control" rows="4"><?= htmlspecialchars($storyText) ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Clinic Photos Upload Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0">Surgery & Practice Visual Photos</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border p-3 rounded-4 bg-light">
                        <label class="form-label fw-bold">Clinic Feature Photo 1 (Treatment Room)</label>
                        <div class="text-center mb-3">
                            <img src="<?= htmlspecialchars($about['image_1'] ?? App::url('/images/treatment-room.jpg')) ?>" alt="Room 1" class="preview-img-box w-100" style="height: 180px; object-fit: cover;" id="photo1Prev">
                        </div>
                        <input type="file" name="image_1_file" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'photo1Prev')">
                        <input type="text" name="image_1_manual" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($about['image_1'] ?? '') ?>" placeholder="Direct image path or URL">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border p-3 rounded-4 bg-light">
                        <label class="form-label fw-bold">Clinic Feature Photo 2 (Surgery Facility)</label>
                        <div class="text-center mb-3">
                            <img src="<?= htmlspecialchars($about['image_2'] ?? App::url('/images/surgery-clinic.jpg')) ?>" alt="Room 2" class="preview-img-box w-100" style="height: 180px; object-fit: cover;" id="photo2Prev">
                        </div>
                        <input type="file" name="image_2_file" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'photo2Prev')">
                        <input type="text" name="image_2_manual" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($about['image_2'] ?? '') ?>" placeholder="Direct image path or URL">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted small">Updates are saved directly to the CMS repository.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save About & Clinic Photos
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
