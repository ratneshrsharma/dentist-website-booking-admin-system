<?php

use App\Core\App;

$logs = $logs ?? [];
$filters = $filters ?? [];
$roles = $roles ?? [];
$totalCount = (int) ($totalCount ?? 0);
$retentionMonths = max(1, (int) ($retentionMonths ?? 2));
?>

<style>
.log-drawer-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    z-index: 1090;
    display: none;
}
.log-drawer-backdrop.open {
    display: block;
}
.log-drawer-panel {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 80vw;
    max-width: 1180px;
    background: #ffffff;
    z-index: 1095;
    box-shadow: -12px 0 40px rgba(15, 23, 42, 0.2);
    transform: translateX(100%);
    transition: transform 0.25s ease;
    display: flex;
    flex-direction: column;
}
.log-drawer-panel.open {
    transform: translateX(0);
}
@media (max-width: 767.98px) {
    .log-drawer-panel {
        width: 100vw;
    }
}
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-activity text-success me-2"></i> System Activity &amp; Audit Logs
        </h3>
        <p class="text-muted small mb-0">
            Super Admin only. Tracks all user logins, profile/user changes, RBAC warnings, and CMS actions in compact JSON storage (Total: <?= $totalCount ?>).
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form method="POST" action="<?= App::url('/admin/logs/purge') ?>" onsubmit="return confirm('Delete all activity logs older than <?= $retentionMonths ?> month(s)?');">
            <button type="submit" class="btn btn-outline-warning text-dark btn-sm px-3">
                <i class="bi bi-calendar-x me-1"></i> Delete Logs &gt; <?= $retentionMonths ?> Month(s) Old
            </button>
        </form>
        <form method="POST" action="<?= App::url('/admin/logs/clear') ?>" onsubmit="return confirm('Clear ALL activity logs permanently?');">
            <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                <i class="bi bi-trash3 me-1"></i> Clear All Logs
            </button>
        </form>
    </div>
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
                    <th>JSON Summary</th>
                    <th class="text-end" style="width: 110px;">Actions</th>
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
                        $logJson = json_encode($log, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
                                    <code style="font-size: 11px; word-break: break-all;"><?= htmlspecialchars(substr((string) json_encode($log['details'], JSON_UNESCAPED_SLASHES), 0, 110)) ?></code>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button"
                                            class="btn btn-outline-secondary"
                                            title="View Full Log & JSON"
                                            data-log='<?= htmlspecialchars((string) $logJson, ENT_QUOTES) ?>'
                                            onclick="openLogDrawer(this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <form method="POST" action="<?= App::url('/admin/logs/' . urlencode((string) ($log['id'] ?? '')) . '/delete') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Log Entry" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- 80% Width Slide-Over Audit Log Drawer -->
<div class="log-drawer-backdrop" id="logDrawerBackdrop" onclick="closeLogDrawer()"></div>
<aside class="log-drawer-panel" id="logDrawerPanel" aria-hidden="true">
    <div class="px-4 py-3 border-bottom bg-light d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-braces-asterisk text-success me-2"></i> Audit Log Entry Details</h5>
            <small class="text-muted" id="drawerLogId"></small>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="copyDrawerJson()">
                <i class="bi bi-clipboard me-1"></i> Copy JSON
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="closeLogDrawer()">
                <i class="bi bi-x-lg"></i> Close
            </button>
        </div>
    </div>
    <div class="p-4 overflow-auto flex-grow-1">
        <div class="row g-3 mb-4" id="drawerMetaGrid"></div>
        <h6 class="fw-bold text-dark mb-2">Full Raw JSON Payload</h6>
        <pre class="bg-dark text-light p-3 rounded-3 small mb-0" id="drawerRawJson" style="white-space: pre-wrap; word-break: break-word; font-size: 13px;"></pre>
    </div>
</aside>

<script>
function openLogDrawer(btn) {
    var raw = btn.getAttribute('data-log');
    if (!raw) return;
    var obj = JSON.parse(raw);
    document.getElementById('drawerLogId').textContent = 'Log ID: ' + (obj.id || '') + ' • ' + (obj.created_at || '');
    var st = obj.status || 'Success';
    var stBadge = st === 'Error' ? 'bg-danger text-white' : (st === 'Warning' ? 'bg-warning text-dark' : 'bg-success text-white');
    document.getElementById('drawerMetaGrid').innerHTML = `
        <div class="col-md-3"><div class="p-3 border rounded-3 bg-light"><div class="small text-muted">Status</div><span class="badge ${stBadge} mt-1">${st}</span></div></div>
        <div class="col-md-3"><div class="p-3 border rounded-3 bg-light"><div class="small text-muted">User &amp; Key</div><div class="fw-bold">${obj.user_name || ''}</div><code>${obj.user_key || ''}</code></div></div>
        <div class="col-md-3"><div class="p-3 border rounded-3 bg-light"><div class="small text-muted">Role &amp; Email</div><div class="fw-bold">${obj.role || ''}</div><div class="small text-muted">${obj.user_email || '—'}</div></div></div>
        <div class="col-md-3"><div class="p-3 border rounded-3 bg-light"><div class="small text-muted">Module &amp; IP</div><div class="fw-bold">${obj.module || ''}</div><div class="small text-muted">${obj.ip || ''}</div></div></div>
        <div class="col-12"><div class="p-3 border rounded-3 bg-light"><div class="small text-muted">Action</div><div class="fw-bold text-dark">${obj.action || ''}</div></div></div>
    `;
    document.getElementById('drawerRawJson').textContent = JSON.stringify(obj, null, 2);
    document.getElementById('logDrawerBackdrop').classList.add('open');
    document.getElementById('logDrawerPanel').classList.add('open');
}

function closeLogDrawer() {
    document.getElementById('logDrawerBackdrop').classList.remove('open');
    document.getElementById('logDrawerPanel').classList.remove('open');
}

function copyDrawerJson() {
    var txt = document.getElementById('drawerRawJson').textContent;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(txt);
    }
}
</script>
