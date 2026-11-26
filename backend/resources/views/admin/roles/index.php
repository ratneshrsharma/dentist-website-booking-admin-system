<?php

use App\Core\App;

$roles = $roles ?? [];
$userCounts = $userCounts ?? [];
$modules = $modules ?? [];
$isSuperAdmin = !empty($isSuperAdmin);
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-shield-check text-success me-2"></i> Role Management &amp; Permissions
        </h3>
        <p class="text-muted small mb-0">
            Configure section-level <strong>View, Add, Edit, Delete</strong> rights per role. Super Admin can create custom roles; both Super Admin &amp; Admin can assign roles and edit permissions.
        </p>
    </div>
    <?php if ($isSuperAdmin): ?>
        <a href="<?= App::url('/admin/roles/create') ?>" class="btn btn-brand btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Create New Role
        </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Role Name &amp; Key</th>
                    <th>Users</th>
                    <th>Allowed Modules (View / Add / Edit / Delete)</th>
                    <th class="text-end" style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $r):
                    $rk = $r['role_key'] ?? '';
                    $isSuper = ($rk === 'super_admin');
                    $isSys = !empty($r['is_system']);
                    $perms = $r['permissions'] ?? [];
                ?>
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">
                                <?= htmlspecialchars($r['label'] ?? $rk) ?>
                                <?php if (!$isSys): ?>
                                    <span class="badge bg-info-subtle text-info ms-1">Custom</span>
                                <?php endif; ?>
                            </div>
                            <code class="small"><?= htmlspecialchars($rk) ?></code>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?= (int) ($userCounts[$rk] ?? 0) ?></span></td>
                        <td>
                            <?php if ($isSuper): ?>
                                <span class="badge bg-dark text-white">Full System Access (*)</span>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($modules as $mKey => $mLabel):
                                        $mPerms = $perms[$mKey] ?? [];
                                        $acts = [];
                                        foreach (['view' => 'V', 'add' => 'A', 'edit' => 'E', 'delete' => 'D'] as $ak => $al) {
                                            if (!empty($mPerms[$ak])) $acts[] = $al;
                                        }
                                        if (!empty($acts)):
                                    ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">
                                            <?= htmlspecialchars($mLabel) ?> (<?= implode('/', $acts) ?>)
                                        </span>
                                    <?php endif; endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <?php if (!$isSuper): ?>
                                    <a href="<?= App::url('/admin/roles/' . urlencode($rk) . '/edit') ?>" class="btn btn-outline-primary" title="Edit Role Permissions">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($isSuperAdmin && !$isSys): ?>
                                    <form method="POST" action="<?= App::url('/admin/roles/' . urlencode($rk) . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this custom role?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Custom Role" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
