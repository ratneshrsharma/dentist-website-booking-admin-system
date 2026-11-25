<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Stores visitor chat sessions & JSON conversation logs in storage/app/chat_logs.json
 */
class ChatLogService
{
    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/chat_logs.json';
    }

    public static function getAllLogs(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data)) {
                usort($data, static function ($a, $b) {
                    return strtotime((string) ($b['updated_at'] ?? $b['created_at'] ?? ''))
                        <=> strtotime((string) ($a['updated_at'] ?? $a['created_at'] ?? ''));
                });
                return $data;
            }
        }
        return [];
    }

    public static function saveAllLogs(array $logs): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function getSession(string $sessionId): ?array
    {
        foreach (self::getAllLogs() as $log) {
            if (($log['session_id'] ?? '') === $sessionId) {
                return $log;
            }
        }
        return null;
    }

    public static function upsertSession(string $sessionId, array $leadInfo = []): array
    {
        $logs = self::getAllLogs();
        $now = date('c');

        foreach ($logs as &$log) {
            if (($log['session_id'] ?? '') === $sessionId) {
                if (!empty($leadInfo['visitor_name'])) $log['visitor_name'] = trim((string) $leadInfo['visitor_name']);
                if (!empty($leadInfo['phone'])) $log['phone'] = trim((string) $leadInfo['phone']);
                if (!empty($leadInfo['service_interest'])) $log['service_interest'] = trim((string) $leadInfo['service_interest']);
                if (!empty($leadInfo['booking_reference'])) $log['booking_reference'] = trim((string) $leadInfo['booking_reference']);
                $log['updated_at'] = $now;
                self::saveAllLogs($logs);
                return $log;
            }
        }
        unset($log);

        $newLog = [
            'session_id' => $sessionId,
            'visitor_name' => trim((string) ($leadInfo['visitor_name'] ?? 'Website Visitor')),
            'phone' => trim((string) ($leadInfo['phone'] ?? '')),
            'service_interest' => trim((string) ($leadInfo['service_interest'] ?? 'General Enquiry')),
            'booking_reference' => trim((string) ($leadInfo['booking_reference'] ?? '')),
            'messages' => [],
            'created_at' => $now,
            'updated_at' => $now,
        ];
        array_unshift($logs, $newLog);
        self::saveAllLogs($logs);
        return $newLog;
    }

    public static function appendMessage(string $sessionId, string $sender, string $text, array $meta = []): array
    {
        $logs = self::getAllLogs();
        $now = date('c');
        $msg = [
            'id' => 'msg_' . uniqid(),
            'sender' => $sender, // 'user' | 'assistant'
            'text' => $text,
            'meta' => $meta,
            'timestamp' => $now,
        ];

        $found = false;
        foreach ($logs as &$log) {
            if (($log['session_id'] ?? '') === $sessionId) {
                $log['messages'][] = $msg;
                $log['updated_at'] = $now;
                if (!empty($meta['booking_reference'])) {
                    $log['booking_reference'] = $meta['booking_reference'];
                }
                $found = true;
                $updated = $log;
                break;
            }
        }
        unset($log);

        if (!$found) {
            $updated = [
                'session_id' => $sessionId,
                'visitor_name' => 'Website Visitor',
                'phone' => '',
                'service_interest' => 'General Enquiry',
                'booking_reference' => $meta['booking_reference'] ?? '',
                'messages' => [$msg],
                'created_at' => $now,
                'updated_at' => $now,
            ];
            array_unshift($logs, $updated);
        }

        self::saveAllLogs($logs);
        return $updated;
    }

    public static function deleteSession(string $sessionId): void
    {
        $logs = array_values(array_filter(
            self::getAllLogs(),
            static fn($l) => ($l['session_id'] ?? '') !== $sessionId
        ));
        self::saveAllLogs($logs);
    }
}
