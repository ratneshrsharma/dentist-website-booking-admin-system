<?php

use App\Core\App;

$patients = $patients ?? [];
$search = $search ?? '';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-person-vcard-fill text-success me-2"></i> Patients Management
        </h3>
        <p class="text-muted small mb-0">
            Complete patient records with visit history, appointment breakdown, treatments taken, payments, and invoices.
        </p>
    </div>
    <a href="<?= App::url('/admin/patients/create') ?>" class="btn btn-brand btn-sm px-3">
        <i class="bi bi-person-plus-fill me-1"></i> Add New Patient
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3">
        <form method="GET" action="<?= App::url('/admin/patients') ?>" class="d-flex gap-2">
            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-control form-control-sm" placeholder="Search by patient name, phone, email, or PAT_ key..." style="max-width: 340px;">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
            <?php if ($search !== ''): ?>
                <a href="<?= App::url('/admin/patients') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Patient &amp; Key</th>
                    <th>Contact</th>
                    <th>Visits &amp; Appointments</th>
                    <th>Total Paid / Due</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No patients found.</td></tr>
                <?php else: ?>
                    <?php foreach ($patients as $p):
                        $st = $p['stats'] ?? [];
                        $pKey = $p['patient_key'] ?? '';
                    ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($p['name'] ?? '') ?></div>
                                <code class="small"><?= htmlspecialchars($pKey) ?></code>
                            </td>
                            <td class="small">
                                <div><i class="bi bi-telephone text-success me-1"></i><?= htmlspecialchars($p['phone'] ?? '') ?></div>
                                <div class="text-muted"><?= htmlspecialchars($p['email'] ?: '—') ?></div>
                            </td>
                            <td class="small">
                                <span class="badge bg-success-subtle text-success">Visits: <?= (int) ($st['visits_completed'] ?? 0) ?></span>
                                <span class="badge bg-primary-subtle text-primary">Fixed: <?= (int) ($st['confirmed'] ?? 0) ?></span>
                                <span class="badge bg-warning-subtle text-dark">Resched: <?= (int) ($st['rescheduled'] ?? 0) ?></span>
                                <span class="badge bg-danger-subtle text-danger">Canc: <?= (int) ($st['cancelled'] ?? 0) ?></span>
                            </td>
                            <td class="small">
                                <div class="fw-bold text-success">Paid: £<?= number_format((float) ($st['total_paid'] ?? 0), 2) ?></div>
                                <?php if (($st['balance_due'] ?? 0) > 0): ?>
                                    <div class="text-danger fw-semibold">Due: £<?= number_format((float) $st['balance_due'], 2) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= App::url('/admin/patients/' . urlencode($pKey)) ?>" class="btn btn-outline-secondary" title="View Patient File">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= App::url('/admin/patients/' . urlencode($pKey) . '/edit') ?>" class="btn btn-outline-primary" title="Edit Patient">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form method="POST" action="<?= App::url('/admin/patients/' . urlencode($pKey) . '/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this patient record?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Patient" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
