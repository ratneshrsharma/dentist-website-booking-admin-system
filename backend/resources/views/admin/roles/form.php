<?php

use App\Core\App;

$isEdit = !empty($isEdit);
$r = $role ?? [];
$modules = $modules ?? [];
$actions = $actions ?? ['view', 'add', 'edit', 'delete'];
$perms = $r['permissions'] ?? [];
$actionUrl = $isEdit
    ? App::url('/admin/roles/' . urlencode((string) ($r['role_key'] ?? '')) . '/edit')
    : App::url('/admin/roles/create');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0 text-dark">
        <i class="bi bi-shield-lock text-success me-2"></i> <?= $isEdit ? 'Edit Role Permissions: ' . htmlspecialchars($r['label'] ?? '') : 'Create New Role' ?>
    </h3>
    <a href="<?= App::url('/admin/roles') ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Roles
    </a>
</div>

<form method="POST" action="<?= $actionUrl ?>">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Role Display Name <span class="text-danger">*</span></label>
                    <input type="text" name="label" class="form-control" required
                           value="<?= htmlspecialchars($r['label'] ?? '') ?>"
                           <?= !empty($r['is_system']) ? 'readonly' : '' ?>
                           placeholder="e.g. Senior Dental Nurse">
                </div>
            </div>

            <h6 class="fw-bold mb-3">Section &amp; Action Permissions Matrix</h6>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Module / Section</th>
                            <?php foreach ($actions as $act): ?>
                                <th class="text-center text-capitalize" style="width: 110px;"><?= htmlspecialchars($act) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modules as $mKey => $mLabel): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($mLabel) ?> <code class="small text-muted ms-1"><?= htmlspecialchars($mKey) ?></code></td>
                                <?php foreach ($actions as $act): ?>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                               name="permissions[<?= htmlspecialchars($mKey) ?>][<?= htmlspecialchars($act) ?>]"
                                               value="1"
                                               <?= !empty($perms[$mKey][$act]) ? 'checked' : '' ?>>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="<?= App::url('/admin/roles') ?>" class="btn btn-outline-secondary btn-sm px-3">Cancel</a>
        <button type="submit" class="btn btn-brand btn-sm px-4">
            <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Save Role Permissions' : 'Create Role' ?>
        </button>
    </div>
</form>
