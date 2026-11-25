<?php

use App\Core\App;

$logs = $logs ?? [];
$activeLog = $activeLog ?? null;
$activeSessionId = $activeLog['session_id'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-chat-dots-fill text-success me-2"></i> Smart Dental Assistant — Chat Logs
        </h3>
        <p class="text-muted small mb-0">
            View visitor leads (Name, Contact Number, Service Interest), live booking references, and full JSON chat transcripts.
        </p>
    </div>
    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
        <i class="bi bi-people me-1"></i> Total Conversations: <?= count($logs) ?>
    </span>
</div>

<?php if (empty($logs)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-chat-square-text fs-1 d-block mb-2 opacity-50"></i>
            <h5 class="fw-bold text-dark">No Chat Conversations Yet</h5>
            <p class="small mb-0">When visitors use the <strong>Smart Dental Assistant</strong> from the website WhatsApp widget, their lead info and chat transcript will appear here.</p>
        </div>
    </div>
<?php else: ?>
    <div class="row g-3">
        <!-- LEFT PANE: CONVERSATIONS LIST -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold small text-uppercase text-secondary">Visitor Sessions</span>
                    <input type="text" id="chatSearchInput" class="form-control form-control-sm" placeholder="Filter by name/phone..." style="width: 170px;">
                </div>
                <div class="list-group list-group-flush" id="chatSessionsList" style="max-height: 620px; overflow-y: auto;">
                    <?php foreach ($logs as $log):
                        $sid = $log['session_id'] ?? '';
                        $isSelected = ($sid === $activeSessionId);
                        $msgCount = count($log['messages'] ?? []);
                    ?>
                        <a href="<?= App::url('/admin/chat-logs?session=' . urlencode($sid)) ?>"
                           class="list-group-item list-group-item-action py-3 px-3 chat-session-row <?= $isSelected ? 'active bg-success-subtle text-dark border-start border-4 border-success' : '' ?>"
                           data-search="<?= htmlspecialchars(strtolower(($log['visitor_name'] ?? '') . ' ' . ($log['phone'] ?? '') . ' ' . ($log['service_interest'] ?? ''))) ?>">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark"><?= htmlspecialchars($log['visitor_name'] ?? 'Visitor') ?></span>
                                <small class="text-muted" style="font-size: 11px;">
                                    <?= htmlspecialchars(date('d M, H:i', strtotime((string) ($log['updated_at'] ?? 'now')))) ?>
                                </small>
                            </div>
                            <div class="small text-muted mb-1">
                                <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($log['phone'] ?: 'No phone') ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                <span class="badge bg-light text-dark border" style="font-size: 11px;">
                                    <?= htmlspecialchars($log['service_interest'] ?? 'General') ?>
                                </span>
                                <?php if (!empty($log['booking_reference'])): ?>
                                    <span class="badge bg-success text-white" style="font-size: 10.5px;">
                                        <i class="bi bi-calendar-check me-1"></i><?= htmlspecialchars($log['booking_reference']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary" style="font-size: 10.5px;"><?= $msgCount ?> msgs</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANE: CHAT UI TRANSCRIPT -->
        <div class="col-lg-8">
            <?php if ($activeLog): ?>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <!-- Visitor Header -->
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                <?= htmlspecialchars($activeLog['visitor_name'] ?? 'Visitor') ?>
                                <?php if (!empty($activeLog['booking_reference'])): ?>
                                    <span class="badge bg-success ms-2" style="font-size: 12px;">
                                        Booked: <?= htmlspecialchars($activeLog['booking_reference']) ?>
                                    </span>
                                <?php endif; ?>
                            </h5>
                            <div class="small text-muted d-flex flex-wrap gap-3">
                                <span><i class="bi bi-telephone text-success me-1"></i><?= htmlspecialchars($activeLog['phone'] ?: '—') ?></span>
                                <span><i class="bi bi-heart-pulse text-success me-1"></i>Looking for: <strong><?= htmlspecialchars($activeLog['service_interest'] ?? 'General') ?></strong></span>
                            </div>
                        </div>
                        <form method="POST" action="<?= App::url('/admin/chat-logs/' . urlencode($activeLog['session_id']) . '/delete') ?>" onsubmit="return confirm('Delete this chat conversation?');">
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Chat Session">
                                <i class="bi bi-trash3 me-1"></i> Delete
                            </button>
                        </form>
                    </div>

                    <!-- Chat Bubbles -->
                    <div class="card-body p-4" style="background: #f0f7f2; max-height: 520px; overflow-y: auto;">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach (($activeLog['messages'] ?? []) as $msg):
                                $isUser = ($msg['sender'] ?? 'user') === 'user';
                            ?>
                                <div class="d-flex <?= $isUser ? 'justify-content-start' : 'justify-content-end' ?>">
                                    <div class="p-3 rounded-4 shadow-sm"
                                         style="max-width: 78%; background: <?= $isUser ? '#ffffff' : '#0d631b' ?>; color: <?= $isUser ? '#151d1a' : '#ffffff' ?>; border: 1px solid <?= $isUser ? '#dbe5de' : '#0d631b' ?>;">
                                        <div class="small fw-bold mb-1" style="opacity: 0.85; font-size: 11px;">
                                            <?= $isUser ? htmlspecialchars($activeLog['visitor_name'] ?? 'Visitor') : 'Smart Dental Assistant' ?>
                                            • <?= htmlspecialchars(date('H:i', strtotime((string) ($msg['timestamp'] ?? 'now')))) ?>
                                        </div>
                                        <div style="font-size: 14px; line-height: 1.55; white-space: pre-line;">
                                            <?= htmlspecialchars($msg['text'] ?? '') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Raw JSON Toggle -->
                    <div class="card-footer bg-white py-2 px-4 border-top">
                        <details>
                            <summary class="small fw-semibold text-muted" style="cursor: pointer;">
                                <i class="bi bi-braces me-1"></i> View Raw JSON Log
                            </summary>
                            <pre class="bg-light p-3 rounded mt-2 mb-0 small" style="max-height: 220px; overflow: auto;"><?= htmlspecialchars(json_encode($activeLog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                        </details>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<script>
(function() {
    var input = document.getElementById('chatSearchInput');
    if (!input) return;
    input.addEventListener('input', function() {
        var q = input.value.toLowerCase().trim();
        document.querySelectorAll('.chat-session-row').forEach(function(row) {
            var hay = row.getAttribute('data-search') || '';
            row.style.display = hay.indexOf(q) !== -1 ? '' : 'none';
        });
    });
})();
</script>
