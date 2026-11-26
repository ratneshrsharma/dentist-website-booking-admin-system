<?php

declare(strict_types=1);

namespace App\Core;

use App\Services\UserService;
use App\Services\ActivityLogService;

/**
 * Authentication & Role-Based Access Control (RBAC) Manager
 */
class Auth
{
    public static function check(): bool
    {
        App::initSession();
        return !empty($_SESSION['auth_user']);
    }

    public static function user(): ?array
    {
        App::initSession();
        $sessionUser = $_SESSION['auth_user'] ?? null;
        if (!$sessionUser) {
            return null;
        }
        $userKey = $sessionUser['user_key'] ?? '';
        if ($userKey !== '') {
            $fresh = UserService::findByKey($userKey);
            if ($fresh) {
                $sessionUser['name'] = $fresh['name'];
                $sessionUser['email'] = $fresh['email'];
                $sessionUser['mobile'] = $fresh['mobile'] ?? '';
                $sessionUser['role_key'] = $fresh['role_key'];
                $sessionUser['role'] = $fresh['role'];
                $sessionUser['is_active'] = !empty($fresh['is_active']);
                $_SESSION['auth_user'] = $sessionUser;
            }
        }
        return $sessionUser;
    }

    public static function roleKey(): string
    {
        $u = self::user();
        return (string) ($u['role_key'] ?? 'guest');
    }

    public static function isSuperAdmin(): bool
    {
        return self::roleKey() === 'super_admin';
    }

    public static function can(string $permission): bool
    {
        if (!self::check()) {
            return false;
        }
        return UserService::hasPermission(self::roleKey(), $permission);
    }

    public static function validateCredentials(string $email, string $password): ?array
    {
        App::initSession();
        $user = UserService::findByEmail($email);
        if (!$user || empty($user['is_active'])) {
            return null;
        }

        if (password_verify($password, (string) ($user['password_hash'] ?? ''))) {
            return [
                'user_key' => $user['user_key'],
                'email' => $user['email'],
                'name' => $user['name'],
                'mobile' => $user['mobile'] ?? '',
                'role_key' => $user['role_key'],
                'role' => $user['role'],
                'avatar' => $user['avatar'] ?? '/images/doctor-das.jpg',
                'logged_at' => date('c'),
            ];
        }

        return null;
    }

    public static function create2FASession(array $user): string
    {
        App::initSession();
        $code = (string) random_int(100000, 999999);
        $_SESSION['2fa_pending'] = [
            'user' => $user,
            'code' => $code,
            'generated_at' => time(),
            'expires_at' => time() + 600,
        ];
        return $code;
    }

    public static function getPending2FA(): ?array
    {
        App::initSession();
        if (empty($_SESSION['2fa_pending'])) {
            return null;
        }
        if (time() > ($_SESSION['2fa_pending']['expires_at'] ?? 0)) {
            unset($_SESSION['2fa_pending']);
            return null;
        }
        return $_SESSION['2fa_pending'];
    }

    public static function verify2FACode(string $enteredCode): bool
    {
        App::initSession();
        $pending = self::getPending2FA();
        if (!$pending) {
            return false;
        }

        $cleanEntered = preg_replace('/\s+/', '', trim($enteredCode));
        if ($cleanEntered === (string) $pending['code']) {
            $_SESSION['auth_user'] = $pending['user'];
            unset($_SESSION['2fa_pending'], $_SESSION['impersonator_user_key']);
            return true;
        }

        return false;
    }

    public static function cancel2FA(): void
    {
        App::initSession();
        unset($_SESSION['2fa_pending']);
    }

    public static function isImpersonating(): bool
    {
        App::initSession();
        return !empty($_SESSION['impersonator_user_key']);
    }

    public static function impersonate(string $targetUserKey): bool
    {
        App::initSession();
        if (!self::isSuperAdmin() && !self::isImpersonating()) {
            return false;
        }
        $target = UserService::findByKey($targetUserKey);
        if (!$target || empty($target['is_active'])) {
            return false;
        }

        if (empty($_SESSION['impersonator_user_key'])) {
            $current = self::user();
            $_SESSION['impersonator_user_key'] = $current['user_key'] ?? 'USR_SUPERADMIN_001';
        }

        $impersonator = UserService::findByKey((string) $_SESSION['impersonator_user_key']);
        ActivityLogService::log(
            'Impersonated user ' . $target['name'] . ' (' . $target['role'] . ')',
            'User Management',
            'Warning',
            ['target_user_key' => $target['user_key'], 'target_email' => $target['email']],
            $impersonator
        );

        $_SESSION['auth_user'] = [
            'user_key' => $target['user_key'],
            'email' => $target['email'],
            'name' => $target['name'],
            'mobile' => $target['mobile'] ?? '',
            'role_key' => $target['role_key'],
            'role' => $target['role'],
            'avatar' => $target['avatar'] ?? '/images/doctor-das.jpg',
            'logged_at' => date('c'),
        ];
        return true;
    }

    public static function stopImpersonating(): bool
    {
        App::initSession();
        $origKey = (string) ($_SESSION['impersonator_user_key'] ?? '');
        if ($origKey === '') {
            return false;
        }
        $orig = UserService::findByKey($origKey);
        if (!$orig) {
            return false;
        }
        $current = self::user();
        unset($_SESSION['impersonator_user_key']);
        $_SESSION['auth_user'] = [
            'user_key' => $orig['user_key'],
            'email' => $orig['email'],
            'name' => $orig['name'],
            'mobile' => $orig['mobile'] ?? '',
            'role_key' => $orig['role_key'],
            'role' => $orig['role'],
            'avatar' => $orig['avatar'] ?? '/images/doctor-das.jpg',
            'logged_at' => date('c'),
        ];
        ActivityLogService::log(
            'Returned to Super Admin from impersonation (' . ($current['name'] ?? '') . ')',
            'User Management',
            'Success',
            ['from_user_key' => $current['user_key'] ?? ''],
            $_SESSION['auth_user']
        );
        return true;
    }

    public static function logout(): void
    {
        App::initSession();
        unset($_SESSION['auth_user'], $_SESSION['impersonator_user_key']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            App::redirect('/admin/login', ['error' => 'Please sign in to access the Dental Clinic Admin Portal.']);
        }
        $u = self::user();
        if (empty($u['is_active'])) {
            self::logout();
            App::redirect('/admin/login', ['error' => 'Your account has been deactivated. Contact an administrator.']);
        }
    }

    public static function requirePermission(string $permission): void
    {
        self::requireAuth();
        if (!self::can($permission)) {
            ActivityLogService::log(
                "Unauthorized access attempt to module: {$permission}",
                'RBAC Security',
                'Warning',
                ['permission' => $permission, 'uri' => $_SERVER['REQUEST_URI'] ?? '']
            );
            http_response_code(403);
            App::render('admin/auth/forbidden', [
                'pageTitle' => '403 Access Denied',
                'activeNav' => 'dashboard',
                'permission' => $permission,
            ]);
            exit;
        }
    }
}
