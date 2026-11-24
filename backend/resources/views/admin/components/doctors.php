<?php

declare(strict_types=1);

use App\Core\App;

$clinicians = $home['clinicians'] ?? [];
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-success-subtle text-success fw-bold">Common Component</span>
            <span class="text-muted small">/</span>
            <span class="text-dark small fw-semibold">Doctors & Avatars</span>
        </div>
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-people text-success me-2"></i> Doctors & Clinician Avatars Component
        </h2>
        <p class="text-muted small mb-0">Manage clinical dental surgeons, hygienists, qualification titles, badges, and professional profile headshots.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= App::url('/about-us#team') ?>" target="_blank" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
        </a>
    </div>
</div>

<form action="<?= App::url('/admin/components/doctors') ?>" method="POST" enctype="multipart/form-data">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Registered Dental Surgeons & Clinicians (<?= count($clinicians) ?> Total)</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <?php foreach ($clinicians as $idx => $doc): ?>
                    <div class="col-md-6">
                        <div class="card border rounded-4 shadow-none bg-light p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary-subtle text-primary fw-bold">Clinician #<?= $idx + 1 ?></span>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="clinician_active[]" value="<?= $idx ?>" id="docActive<?= $idx ?>" <?= ($doc['is_active'] ?? true) ? 'checked' : '' ?>>
                                    <label class="form-check-label small fw-semibold" for="docActive<?= $idx ?>">Active on Site</label>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4 text-center">
                                    <img src="<?= htmlspecialchars($doc['avatar'] ?? App::url('/images/doctor-das.jpg')) ?>" 
                                         alt="Avatar" class="rounded-circle shadow-sm mb-2 border border-2 border-white" 
                                         id="docAvatarPrev<?= $idx ?>" style="width: 90px; height: 90px; object-fit: cover;">
                                    <label class="form-label small fw-bold d-block">Change Photo</label>
                                    <input type="file" name="clinician_avatar_files[<?= $idx ?>]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'docAvatarPrev<?= $idx ?>')">
                                    <input type="hidden" name="clinician_avatars[<?= $idx ?>]" value="<?= htmlspecialchars($doc['avatar'] ?? '') ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Doctor Full Name</label>
                                        <input type="text" name="clinician_names[]" class="form-control form-control-sm fw-bold" value="<?= htmlspecialchars($doc['name'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Degree / Professional Title</label>
                                        <input type="text" name="clinician_titles[]" class="form-control form-control-sm" value="<?= htmlspecialchars($doc['title'] ?? '') ?>" placeholder="BDS Associate Dental Surgeon">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Clinical Role Badge</label>
                                        <input type="text" name="clinician_badges[]" class="form-control form-control-sm" value="<?= htmlspecialchars($doc['badge'] ?? '') ?>" placeholder="Associate Dentist">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">Clinical Bio & Specialty</label>
                                        <textarea name="clinician_bios[]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($doc['bio'] ?? '') ?></textarea>
                                    </div>
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
        <span class="text-muted small">Updated clinician records synchronize instantly across the team gallery.</span>
        <button type="submit" class="btn btn-brand px-4 py-2 rounded-pill shadow">
            <i class="bi bi-check2-circle me-1"></i> Save Doctors & Avatars Component
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
