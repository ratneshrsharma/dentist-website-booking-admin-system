<?php

use App\Core\App;

$logs = $logs ?? [];
$filters = $filters ?? [];
$roles = $roles ?? [];
$totalCount = (int) ($totalCount ?? 0);
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-activity text-success me-2"></i> System Activity &amp; Audit Logs
        </h3>
        <p class="text-muted small mb-0">
            Super Admin only. Tracks all user logins, profile/user changes, RBAC warnings, and CMS actions in compact JSON storage (Total: <?= $totalCount ?>).
        </p>
    </div>
    <form method="POST" action="<?= App::url('/admin/logs/clear') ?>" onsubmit="return confirm('Clear all previous activity logs?');">
        <button type="submit" class="btn btn-outline-danger btn-sm px-3">
            <i class="bi bi-trash3 me-1"></i> Clear All Logs
        </button>
    </form>
</div>

<!-- Multi-Filter Bar -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3 px-3">
        <form method="GET" action="<?= App::url('/admin/logs') ?>" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <?php foreach ($roles as $rKey => $rLabel): ?>
                        <option value="<?= htmlspecialchars($rKey) ?>" <?= ($filters['role'] ?? '') === $rKey ? 'selected' : '' ?>>
                            <?= htmlspecialchars($rLabel) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="Success" <?= ($filters['status'] ?? '') === 'Success' ? 'selected' : '' ?>>Success</option>
                    <option value="Warning" <?= ($filters['status'] ?? '') === 'Warning' ? 'selected' : '' ?>>Warning</option>
                    <option value="Error" <?= ($filters['status'] ?? '') === 'Error' ? 'selected' : '' ?>>Error</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">User Name / Key</label>
                <input type="text" name="user" value="<?= htmlspecialchars($filters['user'] ?? '') ?>" class="form-control form-control-sm" placeholder="Name, email or USR_...">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Date</label>
                <input type="date" name="date" value="<?= htmlspecialchars($filters['date'] ?? '') ?>" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Action / Module</label>
                <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" class="form-control form-control-sm" placeholder="Keyword...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-brand btn-sm flex-grow-1">Filter</button>
                <a href="<?= App::url('/admin/logs') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Timestamp</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>User (Key)</th>
                    <th>Module &amp; Action</th>
                    <th>JSON Details</th>
                    <th class="text-end" style="width: 70px;">Del</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No matching activity logs found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log):
                        $st = $log['status'] ?? 'Success';
                        $stClass = $st === 'Error' ? 'bg-danger text-white' : ($st === 'Warning' ? 'bg-warning text-dark' : 'bg-success text-white');
                    ?>
                        <tr>
                            <td class="small text-muted text-nowrap">
                                <?= htmlspecialchars(date('Y-m-d H:i:s', strtotime((string) ($log['created_at'] ?? 'now')))) ?>
                                <div style="font-size: 10.5px;"><?= htmlspecialchars($log['ip'] ?? '') ?></div>
                            </td>
                            <td><span class="badge <?= $stClass ?>"><?= htmlspecialchars($st) ?></span></td>
                            <td class="small"><span class="badge bg-light text-dark border"><?= htmlspecialchars($log['role'] ?? '') ?></span></td>
                            <td class="small">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($log['user_name'] ?? '') ?></div>
                                <code><?= htmlspecialchars($log['user_key'] ?? '') ?></code>
                            </td>
                            <td class="small">
                                <span class="badge bg-secondary-subtle text-secondary me-1"><?= htmlspecialchars($log['module'] ?? '') ?></span>
                                <span class="fw-semibold"><?= htmlspecialchars($log['action'] ?? '') ?></span>
                            </td>
                            <td class="small" style="max-width: 240px;">
                                <?php if (!empty($log['details'])): ?>
                                    <code style="font-size: 11px; word-break: break-all;"><?= htmlspecialchars(json_encode($log['details'], JSON_UNESCAPED_SLASHES)) ?></code>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="<?= App::url('/admin/logs/' . urlencode((string) ($log['id'] ?? '')) . '/delete') ?>" class="d-inline">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Log Entry">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
