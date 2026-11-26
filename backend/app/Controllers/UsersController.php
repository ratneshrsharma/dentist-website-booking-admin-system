<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\UserService;
use App\Services\ActivityLogService;

class UsersController
{
    public function index(): void
    {
        Auth::requirePermission('users');

        $roleFilter = trim((string) ($_GET['role'] ?? ''));
        $search = strtolower(trim((string) ($_GET['q'] ?? '')));
        $users = UserService::getAllUsers();

        $filtered = array_values(array_filter($users, static function ($u) use ($roleFilter, $search) {
            if ($roleFilter !== '' && ($u['role_key'] ?? '') !== $roleFilter) {
                return false;
            }
            if ($search !== '') {
                $hay = strtolower(($u['name'] ?? '') . ' ' . ($u['email'] ?? '') . ' ' . ($u['user_key'] ?? '') . ' ' . ($u['mobile'] ?? ''));
                if (!str_contains($hay, $search)) {
                    return false;
                }
            }
            return true;
        }));

        App::render('admin/users/index', [
            'pageTitle' => 'User Management & Roles',
            'activeNav' => 'users',
            'users' => $filtered,
            'roles' => UserService::getRoles(true),
            'roleFilter' => $roleFilter,
            'search' => $search,
            'isSuperAdmin' => Auth::isSuperAdmin(),
            'currentUserKey' => Auth::user()['user_key'] ?? '',
        ]);
    }

    public function create(): void
    {
        Auth::requirePermission('users');

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                $roleKey = (string) ($_POST['role_key'] ?? 'receptionist');
                if ($roleKey === 'super_admin' && !Auth::isSuperAdmin()) {
                    $roleKey = 'admin';
                }
                $created = UserService::createUser([
                    'name' => $_POST['name'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'mobile' => $_POST['mobile'] ?? '',
                    'role_key' => $roleKey,
                    'doctor_id' => $_POST['doctor_id'] ?? null,
                    'use_custom_permissions' => !empty($_POST['use_custom_permissions']),
                    'custom_permissions' => $_POST['custom_permissions'] ?? [],
                    'password' => $_POST['password'] ?? '',
                    'is_active' => !empty($_POST['is_active']),
                ]);
                ActivityLogService::log(
                    'Created user ' . $created['name'] . ' (' . $created['role'] . ')',
                    'User Management',
                    'Success',
                    ['user_key' => $created['user_key'], 'email' => $created['email'], 'role_key' => $created['role_key']]
                );
                App::flash('success', 'User created successfully with key ' . $created['user_key'] . '.');
                App::redirect('/admin/users');
            } catch (\Throwable $e) {
                App::flash('error', $e->getMessage());
                App::redirect('/admin/users/create');
            }
            return;
        }

        App::render('admin/users/form', [
            'pageTitle' => 'Add New User',
            'activeNav' => 'users',
            'user' => ['name' => '', 'email' => '', 'mobile' => '', 'role_key' => 'receptionist', 'is_active' => true, 'use_custom_permissions' => false, 'custom_permissions' => []],
            'roles' => UserService::getRoles(Auth::isSuperAdmin()),
            'modules' => \App\Services\RoleService::MODULES,
            'actions' => \App\Services\RoleService::ACTIONS,
            'doctors' => \App\Services\BookingService::getDefaultDoctors(),
            'isEdit' => false,
        ]);
    }

    public function edit(string $userKey): void
    {
        Auth::requirePermission('users');

        $target = UserService::findByKey($userKey);
        if (!$target) {
            App::flash('error', 'User not found.');
            App::redirect('/admin/users');
        }
        if (($target['role_key'] ?? '') === 'super_admin' && !Auth::isSuperAdmin()) {
            ActivityLogService::log('Attempted to edit Super Admin account', 'User Management', 'Warning', ['target_user_key' => $userKey]);
            App::flash('error', 'Only Super Admin can edit a Super Admin account.');
            App::redirect('/admin/users');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                $oldEmail = $target['email'] ?? '';
                $updated = UserService::updateUser($userKey, [
                    'name' => $_POST['name'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'mobile' => $_POST['mobile'] ?? '',
                    'role_key' => $_POST['role_key'] ?? $target['role_key'],
                    'doctor_id' => $_POST['doctor_id'] ?? null,
                    'use_custom_permissions' => !empty($_POST['use_custom_permissions']),
                    'custom_permissions' => $_POST['custom_permissions'] ?? [],
                    'password' => $_POST['password'] ?? '',
                    'is_active' => !empty($_POST['is_active']),
                ], Auth::roleKey());

                $details = ['user_key' => $userKey, 'role_key' => $updated['role_key']];
                if ($oldEmail !== $updated['email']) {
                    $details['email_changed'] = $oldEmail . ' -> ' . $updated['email'];
                }
                ActivityLogService::log(
                    'Updated user ' . $updated['name'] . ' (' . $updated['role'] . ')',
                    'User Management',
                    'Success',
                    $details
                );
                App::flash('success', 'User updated successfully (User Key: ' . $userKey . ').');
                App::redirect('/admin/users');
            } catch (\Throwable $e) {
                App::flash('error', $e->getMessage());
                App::redirect('/admin/users/' . urlencode($userKey) . '/edit');
            }
            return;
        }

        App::render('admin/users/form', [
            'pageTitle' => 'Edit User: ' . ($target['name'] ?? ''),
            'activeNav' => 'users',
            'user' => $target,
            'roles' => UserService::getRoles(Auth::isSuperAdmin()),
            'modules' => \App\Services\RoleService::MODULES,
            'actions' => \App\Services\RoleService::ACTIONS,
            'doctors' => \App\Services\BookingService::getDefaultDoctors(),
            'isEdit' => true,
        ]);
    }

    public function toggle(string $userKey): void
    {
        Auth::requirePermission('users');
        $target = UserService::findByKey($userKey);
        if (!$target || ($target['role_key'] ?? '') === 'super_admin') {
            App::flash('error', 'Cannot change status of Super Admin.');
            App::redirect('/admin/users');
        }
        $updated = UserService::toggleStatus($userKey);
        ActivityLogService::log(
            'Toggled user status for ' . ($target['name'] ?? $userKey) . ' to ' . (!empty($updated['is_active']) ? 'Active' : 'Inactive'),
            'User Management',
            'Success',
            ['user_key' => $userKey]
        );
        App::flash('success', 'User status updated.');
        App::redirect('/admin/users');
    }

    public function delete(string $userKey): void
    {
        Auth::requirePermission('users');
        $currentKey = Auth::user()['user_key'] ?? '';
        $target = UserService::findByKey($userKey);
        if (!$target || ($target['role_key'] ?? '') === 'super_admin' || $userKey === $currentKey) {
            App::flash('error', 'Cannot delete this account.');
            App::redirect('/admin/users');
        }
        UserService::deleteUser($userKey);
        ActivityLogService::log(
            'Deleted user ' . ($target['name'] ?? $userKey),
            'User Management',
            'Warning',
            ['deleted_user_key' => $userKey, 'deleted_email' => $target['email'] ?? '']
        );
        App::flash('success', 'User deleted.');
        App::redirect('/admin/users');
    }

    public function impersonate(string $userKey): void
    {
        Auth::requireAuth();
        if (!Auth::isSuperAdmin()) {
            ActivityLogService::log('Unauthorized impersonation attempt', 'RBAC Security', 'Warning', ['target_user_key' => $userKey]);
            App::flash('error', 'Only Super Admin can log in as another user.');
            App::redirect('/admin/dashboard');
        }
        if (Auth::impersonate($userKey)) {
            $u = Auth::user();
            App::flash('success', 'Now viewing portal as ' . ($u['name'] ?? '') . ' (' . ($u['role'] ?? '') . ').');
            App::redirect('/admin/dashboard');
        }
        App::flash('error', 'Unable to switch to selected user (user may be inactive).');
        App::redirect('/admin/users');
    }

    public function stopImpersonate(): void
    {
        Auth::requireAuth();
        if (Auth::stopImpersonating()) {
            App::flash('success', 'Returned to Super Admin account.');
        }
        App::redirect('/admin/users');
    }
}
