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

    public static function attempt(string $email, string $password): bool
    {
        App::initSession();
        $email = strtolower(trim($email));

        if (isset(self::$credentials[$email]) && self::$credentials[$email]['password'] === $password) {
            $_SESSION['auth_user'] = [
                'email' => $email,
                'name' => self::$credentials[$email]['name'],
                'role' => self::$credentials[$email]['role'],
                'avatar' => self::$credentials[$email]['avatar'],
                'logged_at' => date('c'),
            ];
            return true;
        }

        // Also allow quick-login bypass if demo button is clicked
        if (!empty($_POST['demo_login'])) {
            $_SESSION['auth_user'] = [
                'email' => 'admin@example.com',
                'name' => 'Dr. Ratnesh Sharma',
                'role' => 'Super Administrator',
                'avatar' => '/images/doctor-das.jpg',
                'logged_at' => date('c'),
            ];
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
