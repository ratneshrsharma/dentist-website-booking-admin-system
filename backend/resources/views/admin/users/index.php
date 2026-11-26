<?php

use App\Core\App;

$users = $users ?? [];
$roles = $roles ?? [];
$roleFilter = $roleFilter ?? '';
$search = $search ?? '';
$isSuperAdmin = !empty($isSuperAdmin);
$currentUserKey = $currentUserKey ?? '';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-people-fill text-success me-2"></i> User Management &amp; Roles
        </h3>
        <p class="text-muted small mb-0">
            Manage Admin, Website Manager, Receptionist, Doctor, and Accountant accounts. Each account uses an immutable <code>user_key</code> so changing an email never loses user data.
        </p>
    </div>
    <a href="<?= App::url('/admin/users/create') ?>" class="btn btn-brand btn-sm px-3">
        <i class="bi bi-person-plus-fill me-1"></i> Add New User
    </a>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <form method="GET" action="<?= App::url('/admin/users') ?>" class="d-flex align-items-center gap-2 flex-wrap w-100">
            <select name="role" class="form-select form-select-sm" style="width: 190px;" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <?php foreach ($roles as $rKey => $rLabel): ?>
                    <option value="<?= htmlspecialchars($rKey) ?>" <?= $roleFilter === $rKey ? 'selected' : '' ?>><?= htmlspecialchars($rLabel) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control form-control-sm" placeholder="Search name, email, key..." style="width: 240px;">
            <button type="submit" class="btn btn-outline-primary btn-sm" title="Filter"><i class="bi bi-search"></i></button>
            <?php if ($roleFilter !== '' || $search !== ''): ?>
                <a href="<?= App::url('/admin/users') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>User Key</th>
                    <th>Name &amp; Mobile</th>
                    <th>Primary Email (Login ID)</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 175px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u):
                    $uKey = $u['user_key'] ?? '';
                    $isSuperRow = ($u['role_key'] ?? '') === 'super_admin';
                    $isSelf = ($uKey === $currentUserKey);
                    $active = !empty($u['is_active']);
                ?>
                    <tr>
                        <td><code class="small"><?= htmlspecialchars($uKey) ?></code></td>
                        <td>
                            <div class="fw-bold text-dark">
                                <?= htmlspecialchars($u['name'] ?? '') ?>
                                <?php if ($isSelf): ?><span class="badge bg-info-subtle text-info ms-1">You</span><?php endif; ?>
                            </div>
                            <div class="small text-muted"><?= htmlspecialchars($u['mobile'] ?: '—') ?></div>
                        </td>
                        <td class="small"><?= htmlspecialchars($u['email'] ?? '') ?></td>
                        <td>
                            <span class="badge <?= $isSuperRow ? 'bg-dark text-white' : 'bg-success-subtle text-success border border-success-subtle' ?>">
                                <?= htmlspecialchars($u['role'] ?? '') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($isSuperRow): ?>
                                <span class="badge bg-success rounded-pill px-2">Active</span>
                            <?php else: ?>
                                <form method="POST" action="<?= App::url('/admin/users/' . urlencode($uKey) . '/toggle') ?>" class="d-inline">
                                    <button type="submit" class="btn btn-sm rounded-pill px-2 py-0 <?= $active ? 'btn-success' : 'btn-secondary' ?>" style="font-size: 11px;" title="Toggle Active/Inactive">
                                        <?= $active ? 'Active' : 'Inactive' ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <?php if ($isSuperAdmin && !$isSelf && $active): ?>
                                    <form method="POST" action="<?= App::url('/admin/users/' . urlencode($uKey) . '/impersonate') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-outline-dark btn-sm" title="Login As This User (Without Logout)">
                                            <i class="bi bi-person-badge"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if (!$isSuperRow || $isSuperAdmin): ?>
                                    <a href="<?= App::url('/admin/users/' . urlencode($uKey) . '/edit') ?>" class="btn btn-outline-primary" title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!$isSuperRow && !$isSelf): ?>
                                    <form method="POST" action="<?= App::url('/admin/users/' . urlencode($uKey) . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this user account?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete User">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
