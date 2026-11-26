<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\UserService;
use App\Services\ActivityLogService;
use App\Services\ThemeService;

/**
 * Activity & Audit Logs CRUD Controller (Super Admin ONLY)
 */
class LogsController
{
    public function index(): void
    {
        Auth::requirePermission('logs');

        $filters = [
            'role' => $_GET['role'] ?? '',
            'user' => $_GET['user'] ?? '',
            'date' => $_GET['date'] ?? '',
            'status' => $_GET['status'] ?? '',
            'q' => $_GET['q'] ?? '',
        ];

        $logs = ActivityLogService::getFilteredLogs($filters);
        $allLogs = ActivityLogService::getAllLogs();
        $theme = ThemeService::getTheme();
        $retentionMonths = (int) ($theme['system_settings']['log_retention_months'] ?? 2);

        App::render('admin/logs/index', [
            'pageTitle' => 'System Activity Logs',
            'activeNav' => 'logs',
            'logs' => $logs,
            'totalCount' => count($allLogs),
            'retentionMonths' => max(1, $retentionMonths),
            'filters' => $filters,
            'roles' => UserService::getRoles(true),
        ]);
    }

    public function purgeOld(): void
    {
        Auth::requirePermission('logs');
        $theme = ThemeService::getTheme();
        $months = max(1, (int) ($theme['system_settings']['log_retention_months'] ?? 2));
        $deleted = ActivityLogService::purgeOlderThanMonths($months);
        ActivityLogService::log(
            "Purged {$deleted} activity logs older than {$months} month(s)",
            'Activity Logs',
            'Warning',
            ['months' => $months, 'deleted_count' => $deleted]
        );
        App::flash('success', "Deleted {$deleted} log entry(s) older than {$months} month(s).");
        App::redirect('/admin/logs');
    }

    public function delete(string $id): void
    {
        Auth::requirePermission('logs');
        ActivityLogService::deleteLog($id);
        App::flash('success', 'Log entry deleted.');
        App::redirect('/admin/logs');
    }

    public function clear(): void
    {
        Auth::requirePermission('logs');
        ActivityLogService::clearLogs();
        ActivityLogService::log('Cleared all previous activity logs', 'Activity Logs', 'Warning');
        App::flash('success', 'Activity logs cleared.');
        App::redirect('/admin/logs');
    }
}
