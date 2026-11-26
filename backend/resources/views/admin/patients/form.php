<?php

use App\Core\App;

$isEdit = !empty($isEdit);
$p = $patient ?? [];
$actionUrl = $isEdit
    ? App::url('/admin/patients/' . urlencode((string) ($p['patient_key'] ?? '')) . '/edit')
    : App::url('/admin/patients/create');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0 text-dark">
        <i class="bi bi-person-vcard text-success me-2"></i> <?= $isEdit ? 'Edit Patient Record' : 'Add New Patient' ?>
    </h3>
    <a href="<?= App::url('/admin/patients') ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Patients
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4" style="max-width: 820px;">
    <div class="card-body p-4">
        <form method="POST" action="<?= $actionUrl ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($p['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Mobile / Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($p['phone'] ?? '') ?>" placeholder="+44 7700 900123">
                    <div class="form-text">Also used as the patient's password for viewing invoices online.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($p['email'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($p['dob'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Registration Status</label>
                    <select name="registration_status" class="form-select">
                        <option value="new" <?= ($p['registration_status'] ?? '') === 'new' ? 'selected' : '' ?>>New Patient</option>
                        <option value="existing" <?= ($p['registration_status'] ?? 'existing') === 'existing' ? 'selected' : '' ?>>Existing Patient</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Address</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($p['address'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Clinical &amp; Medical History Notes</label>
                    <textarea name="clinical_notes" class="form-control" rows="3"><?= htmlspecialchars($p['clinical_notes'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= App::url('/admin/patients') ?>" class="btn btn-outline-secondary btn-sm px-3">Cancel</a>
                <button type="submit" class="btn btn-brand btn-sm px-4">
                    <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update Patient' : 'Save Patient' ?>
                </button>
            </div>
        </form>
    </div>
</div>
