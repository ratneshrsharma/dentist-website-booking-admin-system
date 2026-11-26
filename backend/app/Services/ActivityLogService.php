<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;

/**
 * Compact JSON Activity & Audit Logs Service (Super Admin Only)
 */
class ActivityLogService
{
    private const MAX_ENTRIES = 2000;

    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/activity_logs.json';
    }

    public static function getAllLogs(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data)) {
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
        if (count($logs) > self::MAX_ENTRIES) {
            $logs = array_slice($logs, 0, self::MAX_ENTRIES);
        }
        file_put_contents($file, json_encode(array_values($logs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public static function log(string $action, string $module, string $status = 'Success', array $details = [], ?array $actor = null): void
    {
        if (!in_array($status, ['Success', 'Warning', 'Error'], true)) {
            $status = 'Success';
        }
        $user = $actor ?? Auth::user() ?? [
            'user_key' => 'GUEST',
            'name' => 'Guest / System',
            'email' => '',
            'role_key' => 'guest',
            'role' => 'Guest',
        ];

        $entry = [
            'id' => 'log_' . uniqid(),
            'user_key' => $user['user_key'] ?? 'UNKNOWN',
            'user_name' => $user['name'] ?? 'Unknown',
            'user_email' => $user['email'] ?? '',
            'role_key' => $user['role_key'] ?? 'guest',
            'role' => $user['role'] ?? 'Guest',
            'module' => $module,
            'action' => $action,
            'status' => $status,
            'details' => $details,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'created_at' => date('c'),
        ];

        $logs = self::getAllLogs();
        array_unshift($logs, $entry);
        self::saveAllLogs($logs);
    }

    public static function getFilteredLogs(array $filters): array
    {
        $role = trim((string) ($filters['role'] ?? ''));
        $user = strtolower(trim((string) ($filters['user'] ?? '')));
        $date = trim((string) ($filters['date'] ?? ''));
        $status = trim((string) ($filters['status'] ?? ''));
        $q = strtolower(trim((string) ($filters['q'] ?? '')));

        return array_values(array_filter(self::getAllLogs(), static function ($l) use ($role, $user, $date, $status, $q) {
            if ($role !== '' && ($l['role_key'] ?? '') !== $role) {
                return false;
            }
            if ($status !== '' && ($l['status'] ?? '') !== $status) {
                return false;
            }
            if ($date !== '' && !str_starts_with((string) ($l['created_at'] ?? ''), $date)) {
                return false;
            }
            if ($user !== '') {
                $uHay = strtolower(($l['user_name'] ?? '') . ' ' . ($l['user_key'] ?? '') . ' ' . ($l['user_email'] ?? ''));
                if (!str_contains($uHay, $user)) {
                    return false;
                }
            }
            if ($q !== '') {
                $hay = strtolower(($l['action'] ?? '') . ' ' . ($l['module'] ?? '') . ' ' . json_encode($l['details'] ?? []));
                if (!str_contains($hay, $q)) {
                    return false;
                }
            }
            return true;
        }));
    }

    public static function deleteLog(string $id): void
    {
        $logs = array_values(array_filter(
            self::getAllLogs(),
            static fn($l) => ($l['id'] ?? '') !== $id
        ));
        self::saveAllLogs($logs);
    }

    public static function clearLogs(): void
    {
        self::saveAllLogs([]);
    }

    public static function purgeOlderThanMonths(int $months): int
    {
        $months = max(1, $months);
        $cutoff = strtotime("-{$months} months");
        $all = self::getAllLogs();
        $kept = [];
        $deleted = 0;
        foreach ($all as $l) {
            $ts = strtotime((string) ($l['created_at'] ?? 'now'));
            if ($ts !== false && $ts < $cutoff) {
                $deleted++;
            } else {
                $kept[] = $l;
            }
        }
        if ($deleted > 0) {
            self::saveAllLogs($kept);
        }
        return $deleted;
    }
}
