<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\ActivityLogService;

/**
 * Role Management CRUD & Granular Permissions (Super Admin & Admin; Create/Delete Role = Super Admin ONLY)
 */
class RolesController
{
    public function index(): void
    {
        Auth::requirePermission('roles', 'view');

        $roles = RoleService::getAllRoles();
        $users = UserService::getAllUsers();
        $userCounts = [];
        foreach ($users as $u) {
            $rk = $u['role_key'] ?? '';
            $userCounts[$rk] = ($userCounts[$rk] ?? 0) + 1;
        }

        App::render('admin/roles/index', [
            'pageTitle' => 'Role Management & Permissions',
            'activeNav' => 'roles',
            'roles' => $roles,
            'userCounts' => $userCounts,
            'modules' => RoleService::MODULES,
            'isSuperAdmin' => Auth::isSuperAdmin(),
        ]);
    }

    public function create(): void
    {
        Auth::requireAuth();
        if (!Auth::isSuperAdmin()) {
            ActivityLogService::log('Unauthorized role creation attempt', 'RBAC Security', 'Warning');
            App::flash('error', 'Only Super Admin can create new roles.');
            App::redirect('/admin/roles');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                $created = RoleService::createRole(
                    (string) ($_POST['label'] ?? ''),
                    (array) ($_POST['permissions'] ?? [])
                );
                ActivityLogService::log('Created role ' . $created['label'], 'Role Management', 'Success', ['role_key' => $created['role_key']]);
                App::flash('success', 'New role "' . $created['label'] . '" created. Admin & Super Admin can now assign it to users.');
                App::redirect('/admin/roles');
            } catch (\Throwable $e) {
                App::flash('error', $e->getMessage());
                App::redirect('/admin/roles/create');
            }
            return;
        }

        App::render('admin/roles/form', [
            'pageTitle' => 'Create New Role',
            'activeNav' => 'roles',
            'role' => ['role_key' => '', 'label' => '', 'is_system' => false, 'permissions' => []],
            'modules' => RoleService::MODULES,
            'actions' => RoleService::ACTIONS,
            'isEdit' => false,
        ]);
    }

    public function edit(string $roleKey): void
    {
        Auth::requirePermission('roles', 'edit');

        if ($roleKey === 'super_admin') {
            App::flash('error', 'Super Admin always has full unrestricted permissions.');
            App::redirect('/admin/roles');
        }

        $role = RoleService::findByKey($roleKey);
        if (!$role) {
            App::flash('error', 'Role not found.');
            App::redirect('/admin/roles');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                $updated = RoleService::updateRole(
                    $roleKey,
                    (string) ($_POST['label'] ?? $role['label']),
                    (array) ($_POST['permissions'] ?? [])
                );
                ActivityLogService::log('Updated permissions for role ' . ($updated['label'] ?? $roleKey), 'Role Management', 'Success', ['role_key' => $roleKey]);
                App::flash('success', 'Role permissions updated successfully.');
                App::redirect('/admin/roles');
            } catch (\Throwable $e) {
                App::flash('error', $e->getMessage());
                App::redirect('/admin/roles/' . urlencode($roleKey) . '/edit');
            }
            return;
        }

        App::render('admin/roles/form', [
            'pageTitle' => 'Edit Role Permissions: ' . ($role['label'] ?? ''),
            'activeNav' => 'roles',
            'role' => $role,
            'modules' => RoleService::MODULES,
            'actions' => RoleService::ACTIONS,
            'isEdit' => true,
        ]);
    }

    public function delete(string $roleKey): void
    {
        Auth::requireAuth();
        if (!Auth::isSuperAdmin()) {
            App::flash('error', 'Only Super Admin can delete custom roles.');
            App::redirect('/admin/roles');
        }
        if (RoleService::deleteRole($roleKey)) {
            ActivityLogService::log('Deleted custom role ' . $roleKey, 'Role Management', 'Warning', ['role_key' => $roleKey]);
            App::flash('success', 'Custom role deleted.');
        } else {
            App::flash('error', 'System built-in roles cannot be deleted.');
        }
        App::redirect('/admin/roles');
    }
}
