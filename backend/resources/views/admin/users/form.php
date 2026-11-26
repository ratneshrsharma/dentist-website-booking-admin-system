<?php

use App\Core\App;

$isEdit = !empty($isEdit);
$u = $user ?? [];
$roles = $roles ?? [];
$modules = $modules ?? [];
$actions = $actions ?? ['view', 'add', 'edit', 'delete'];
$doctors = $doctors ?? [];
$useCustom = !empty($u['use_custom_permissions']);
$customPerms = $u['custom_permissions'] ?? [];
$actionUrl = $isEdit
    ? App::url('/admin/users/' . urlencode((string) ($u['user_key'] ?? '')) . '/edit')
    : App::url('/admin/users/create');
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-person-gear text-success me-2"></i> <?= $isEdit ? 'Edit User Account' : 'Create New User Account' ?>
        </h3>
        <?php if ($isEdit): ?>
            <p class="text-muted small mb-0">Immutable User Key: <code><?= htmlspecialchars($u['user_key'] ?? '') ?></code></p>
        <?php endif; ?>
    </div>
    <a href="<?= App::url('/admin/users') ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Users
    </a>
</div>

<form method="POST" action="<?= $actionUrl ?>">
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="max-width: 920px;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($u['name'] ?? '') ?>" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Primary Login Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($u['email'] ?? '') ?>" placeholder="sarah@acocksgreendental.co.uk">
                    <div class="form-text">Only Admin &amp; Super Admin can change this email.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($u['mobile'] ?? '') ?>" placeholder="+44 7700 900123">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Role &amp; Permissions <span class="text-danger">*</span></label>
                    <select name="role_key" class="form-select">
                        <?php foreach ($roles as $rKey => $rLabel): ?>
                            <option value="<?= htmlspecialchars($rKey) ?>" <?= ($u['role_key'] ?? '') === $rKey ? 'selected' : '' ?>>
                                <?= htmlspecialchars($rLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Linked Doctor Profile (For Doctor Role)</label>
                    <select name="doctor_id" class="form-select">
                        <option value="">-- Not Linked / N/A --</option>
                        <?php foreach ($doctors as $doc): ?>
                            <option value="<?= (int) $doc['id'] ?>" <?= ((int) ($u['doctor_id'] ?? 0)) === (int) $doc['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($doc['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">
                        <?= $isEdit ? 'New Password (leave blank to keep current)' : 'Password *' ?>
                    </label>
                    <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?> minlength="6" placeholder="Minimum 6 characters">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="userActiveSwitch" <?= !isset($u['is_active']) || !empty($u['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="userActiveSwitch">Account Active</label>
                    </div>
                </div>
            </div>

            <?php if (($u['role_key'] ?? '') !== 'super_admin' && !empty($modules)): ?>
                <hr class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0"><i class="bi bi-sliders text-success me-1"></i> User-Specific Permission Overrides</h6>
                        <small class="text-muted">Enable to override this user's Role defaults with custom View/Add/Edit/Delete rights.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="use_custom_permissions" value="1" id="useCustomPerms" <?= $useCustom ? 'checked' : '' ?> onchange="document.getElementById('customPermsMatrix').classList.toggle('d-none', !this.checked);">
                        <label class="form-check-label fw-semibold small" for="useCustomPerms">Use Custom Per-User Rights</label>
                    </div>
                </div>
                <div id="customPermsMatrix" class="table-responsive <?= $useCustom ? '' : 'd-none' ?>">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Section / Module</th>
                                <?php foreach ($actions as $act): ?>
                                    <th class="text-center text-capitalize" style="width: 90px;"><?= htmlspecialchars($act) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $mKey => $mLabel): ?>
                                <tr>
                                    <td class="small fw-semibold"><?= htmlspecialchars($mLabel) ?></td>
                                    <?php foreach ($actions as $act): ?>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                   name="custom_permissions[<?= htmlspecialchars($mKey) ?>][<?= htmlspecialchars($act) ?>]"
                                                   value="1"
                                                   <?= !empty($customPerms[$mKey][$act]) ? 'checked' : '' ?>>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= App::url('/admin/users') ?>" class="btn btn-outline-secondary btn-sm px-3">Cancel</a>
                <button type="submit" class="btn btn-brand btn-sm px-4">
                    <i class="bi bi-check2-circle me-1"></i> <?= $isEdit ? 'Update User' : 'Create User' ?>
                </button>
            </div>
        </div>
    </div>
</form>
