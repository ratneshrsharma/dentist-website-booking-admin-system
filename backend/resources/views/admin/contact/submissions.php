<?php

use App\Core\App;

$statusFilter = $statusFilter ?? 'all';
$counts = $counts ?? ['all' => 0, 'new' => 0, 'contacted' => 0, 'resolved' => 0];
$forwardingEmails = $forwardingEmails ?? [];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="<?= App::url('/admin/pages') ?>" class="text-decoration-none">CMS Pages</a></li>
                <li class="breadcrumb-item"><a href="<?= App::url('/admin/pages/contact/edit') ?>" class="text-decoration-none">Contact Page</a></li>
                <li class="breadcrumb-item active">Form Entries</li>
            </ol>
        </nav>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-envelope-paper text-success me-2"></i> Contact Form Entries
        </h3>
        <p class="text-muted small mb-0">
            All patient enquiries submitted from the Contact page are saved here and forwarded to configured emails.
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= App::url('/admin/pages/contact/edit') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-pencil-square me-1"></i> Edit Contact Page
        </a>
        <a href="<?= App::url('/admin/settings') ?>" class="btn btn-brand btn-sm px-3">
            <i class="bi bi-gear me-1"></i> Email Forwarding Settings
        </a>
    </div>
</div>

<!-- Active Forwarding Emails Banner -->
<div class="alert alert-light border d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="small">
        <i class="bi bi-send-check text-success me-1"></i>
        <strong>Forwarding Emails:</strong>
        <?php if (!empty($forwardingEmails)): ?>
            <?php foreach ($forwardingEmails as $em): ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle me-1"><?= htmlspecialchars($em) ?></span>
            <?php endforeach; ?>
        <?php else: ?>
            <span class="text-danger">No forwarding emails configured.</span>
        <?php endif; ?>
    </div>
    <a href="<?= App::url('/admin/settings') ?>" class="small fw-semibold text-decoration-none">Update Comma-Separated Emails →</a>
</div>

<!-- Status Filter Bar -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3 d-flex align-items-center gap-2 flex-wrap">
        <a href="<?= App::url('/admin/contact/submissions?status=all') ?>" class="btn btn-sm <?= $statusFilter === 'all' ? 'btn-dark' : 'btn-outline-secondary' ?>">
            All <span class="badge bg-secondary ms-1"><?= (int) $counts['all'] ?></span>
        </a>
        <a href="<?= App::url('/admin/contact/submissions?status=new') ?>" class="btn btn-sm <?= $statusFilter === 'new' ? 'btn-primary' : 'btn-outline-primary' ?>">
            New <span class="badge bg-primary ms-1"><?= (int) $counts['new'] ?></span>
        </a>
        <a href="<?= App::url('/admin/contact/submissions?status=contacted') ?>" class="btn btn-sm <?= $statusFilter === 'contacted' ? 'btn-info text-dark' : 'btn-outline-info' ?>">
            Contacted <span class="badge bg-info text-dark ms-1"><?= (int) $counts['contacted'] ?></span>
        </a>
        <a href="<?= App::url('/admin/contact/submissions?status=resolved') ?>" class="btn btn-sm <?= $statusFilter === 'resolved' ? 'btn-success' : 'btn-outline-success' ?>">
            Resolved <span class="badge bg-success ms-1"><?= (int) $counts['resolved'] ?></span>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Reference &amp; Date</th>
                    <th>Patient</th>
                    <th>Service &amp; Preferences</th>
                    <th>Message</th>
                    <th>Forwarded To</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            No contact form entries yet.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($submissions as $item): ?>
                        <?php
                        $pStatus = $item['patient_status'] ?? 'new';
                        $st = $item['status'] ?? 'new';
                        ?>
                        <tr>
                            <td>
                                <div class="fw-bold small"><code><?= htmlspecialchars($item['reference'] ?? '') ?></code></div>
                                <div class="small text-muted"><?= htmlspecialchars(date('d M Y, H:i', strtotime((string) ($item['created_at'] ?? 'now')))) ?></div>
                                <?php if ($pStatus === 'emergency'): ?>
                                    <span class="badge bg-danger mt-1">Emergency / Pain</span>
                                <?php elseif ($pStatus === 'existing'): ?>
                                    <span class="badge bg-secondary-subtle text-secondary mt-1">Existing Patient</span>
                                <?php else: ?>
                                    <span class="badge bg-success-subtle text-success mt-1">New Patient</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($item['full_name'] ?? '') ?></div>
                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($item['phone'] ?? '') ?></div>
                                <div class="small text-muted"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($item['email'] ?? '') ?></div>
                            </td>
                            <td class="small">
                                <div class="fw-semibold"><?= htmlspecialchars($item['service_required'] ?? '') ?></div>
                                <div class="text-muted">Time: <?= htmlspecialchars($item['preferred_time'] ?? '') ?> | Via: <?= htmlspecialchars($item['comm_method'] ?? '') ?></div>
                            </td>
                            <td class="small" style="max-width: 260px;">
                                <?= nl2br(htmlspecialchars($item['message'] ?? '—')) ?>
                            </td>
                            <td class="small">
                                <?php foreach (($item['forwarded_to'] ?? []) as $fwd): ?>
                                    <span class="badge bg-light text-dark border mb-1"><?= htmlspecialchars($fwd) ?></span><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <form method="POST" action="<?= App::url('/admin/contact/submissions/' . $item['id'] . '/status') ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                                        <option value="new" <?= $st === 'new' ? 'selected' : '' ?>>New</option>
                                        <option value="contacted" <?= $st === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                        <option value="resolved" <?= $st === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="<?= App::url('/admin/contact/submissions/' . $item['id'] . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this contact entry?');">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Entry">
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
