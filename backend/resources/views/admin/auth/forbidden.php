<?php

use App\Core\App;
use App\Core\Auth;

$u = Auth::user();
?>
<div class="card border-0 shadow-sm rounded-4 my-4">
    <div class="card-body text-center py-5 px-4">
        <div class="mb-3">
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fs-6">
                <i class="bi bi-shield-lock-fill me-1"></i> 403 — Access Denied
            </span>
        </div>
        <h3 class="fw-bold text-dark mb-2">You do not have permission to access this section</h3>
        <p class="text-muted mb-4">
            Your current role (<strong><?= htmlspecialchars($u['role'] ?? 'Staff') ?></strong>) is not authorized for
            <code><?= htmlspecialchars($permission ?? 'this module') ?></code>.
        </p>
        <a href="<?= App::url('/admin/dashboard') ?>" class="btn btn-brand btn-sm px-4">
            <i class="bi bi-speedometer2 me-1"></i> Return to Dashboard
        </a>
    </div>
</div>
