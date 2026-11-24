<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Authentication Manager
 */
class Auth
{
    /**
     * Default administrator credentials for local development & demonstration
     */
    private static array $credentials = [
        'admin@example.com' => [
            'name' => 'Dr. Ratnesh Sharma',
            'role' => 'Super Administrator',
            'password' => 'Admin@DemoPass2026!',
            'avatar' => '/images/doctor-das.jpg',
        ],
    ];

    public static function check(): bool
    {
        App::initSession();
        return !empty($_SESSION['auth_user']);
    }

    public static function user(): ?array
    {
        App::initSession();
        return $_SESSION['auth_user'] ?? null;
    }

    public static function validateCredentials(string $email, string $password): ?array
    {
        App::initSession();
        $email = strtolower(trim($email));

        if (isset(self::$credentials[$email]) && self::$credentials[$email]['password'] === $password) {
            return [
                'email' => $email,
                'name' => self::$credentials[$email]['name'],
                'role' => self::$credentials[$email]['role'],
                'avatar' => self::$credentials[$email]['avatar'],
                'logged_at' => date('c'),
            ];
        }

        return null;
    }

    public static function create2FASession(array $user): string
    {
        App::initSession();
        // Generate random 6-digit code
        $code = (string)random_int(100000, 999999);
        $_SESSION['2fa_pending'] = [
            'user' => $user,
            'code' => $code,
            'generated_at' => time(),
            'expires_at' => time() + 600, // 10 minutes validity
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
        if ($cleanEntered === (string)$pending['code']) {
            $_SESSION['auth_user'] = $pending['user'];
            unset($_SESSION['2fa_pending']);
            return true;
        }

        return false;
    }

    public static function cancel2FA(): void
    {
        App::initSession();
        unset($_SESSION['2fa_pending']);
    }

    public static function attempt(string $email, string $password): bool
    {
        App::initSession();
        $user = self::validateCredentials($email, $password);
        if ($user !== null) {
            $_SESSION['auth_user'] = $user;
            return true;
        }

        return false;
    }

    public static function logout(): void
    {
        App::initSession();
        unset($_SESSION['auth_user']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            App::redirect('/admin/login', ['error' => 'Please sign in to access the clinic administration dashboard.']);
        }
    }
}
