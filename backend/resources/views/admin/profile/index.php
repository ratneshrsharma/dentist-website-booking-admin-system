<?php

use App\Core\App;

$p = $profile ?? [];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-person-circle text-success me-2"></i> My Profile
        </h3>
        <p class="text-muted small mb-0">
            Update your display name, mobile number, and password. Your primary login email is locked for security.
        </p>
    </div>
    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
        Role: <?= htmlspecialchars($p['role'] ?? 'Staff') ?>
    </span>
</div>

<div class="card border-0 shadow-sm rounded-4" style="max-width: 720px;">
    <div class="card-body p-4">
        <form method="POST" action="<?= App::url('/admin/profile') ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Unique User Key</label>
                    <input type="text" class="form-control bg-light font-monospace" value="<?= htmlspecialchars($p['user_key'] ?? '') ?>" disabled readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Primary Login Email (Locked)</label>
                    <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($p['email'] ?? '') ?>" disabled readonly>
                    <div class="form-text">Only an Admin or Super Admin can change your login email.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($p['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($p['mobile'] ?? '') ?>" placeholder="+44 7700 900123">
                </div>

                <div class="col-12 mt-3 pt-3 border-top">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-key me-1 text-success"></i> Change Password (Optional)</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">New Password</label>
                    <input type="password" name="new_password" class="form-control" minlength="6" placeholder="Leave blank to keep current">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" minlength="6" placeholder="Repeat new password">
                </div>
            </div>
            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                <button type="submit" class="btn btn-brand btn-sm px-4">
                    <i class="bi bi-check2-circle me-1"></i> Save Profile
                </button>
            </div>
        </form>
    </div>
</div>
