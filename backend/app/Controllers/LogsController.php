<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\UserService;
use App\Services\ActivityLogService;

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

        App::render('admin/logs/index', [
            'pageTitle' => 'System Activity Logs',
            'activeNav' => 'logs',
            'logs' => $logs,
            'totalCount' => count($allLogs),
            'filters' => $filters,
            'roles' => UserService::getRoles(true),
        ]);
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
