<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ChatLogService;

/**
 * Admin CMS Chat Logs & Visitor Leads Viewer (2-Pane Chat UI)
 */
class ChatLogsController
{
    public function index(): void
    {
        Auth::requirePermission('chat_logs');

        $logs = ChatLogService::getAllLogs();
        $activeId = trim((string) ($_GET['session'] ?? ''));
        $activeLog = null;
        if ($activeId !== '') {
            foreach ($logs as $l) {
                if (($l['session_id'] ?? '') === $activeId) {
                    $activeLog = $l;
                    break;
                }
            }
        }
        if (!$activeLog && !empty($logs)) {
            $activeLog = $logs[0];
        }

        App::render('admin/chat/logs', [
            'pageTitle' => 'Smart Assistant Chat Logs',
            'activeNav' => 'chat-logs',
            'logs' => $logs,
            'activeLog' => $activeLog,
        ]);
    }

    public function delete(string $sessionId): void
    {
        Auth::requirePermission('chat_logs');
        ChatLogService::deleteSession($sessionId);
        App::flash('success', 'Chat session deleted.');
        App::redirect('/admin/chat-logs');
    }
}

