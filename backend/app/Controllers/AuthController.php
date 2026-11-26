<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ThemeService;
use App\Services\ActivityLogService;

class AuthController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            App::redirect('/admin/dashboard');
        }

        $pending2FA = Auth::getPending2FA();
        $theme = ThemeService::getTheme();

        App::render('admin/auth/login', [
            'theme' => $theme,
            'pageTitle' => ($pending2FA ? 'Two-Factor Verification (2FA)' : 'Staff Sign In') . ' — ' . $theme['branding']['clinic_name'],
            'is2FAPending' => ($pending2FA !== null),
            'twoFactorCode' => $pending2FA['code'] ?? '',
            'pendingEmail' => $pending2FA['user']['email'] ?? '',
            'pendingName' => $pending2FA['user']['name'] ?? '',
        ], false);
    }

    public function login(): void
    {
        $action = $_POST['action'] ?? 'credentials';

        if ($action === 'verify_2fa') {
            $code = trim($_POST['code'] ?? '');
            $pending = Auth::getPending2FA();
            if (empty($code)) {
                App::redirect('/admin/login', ['error' => 'Please enter the 6-digit security code.']);
            }

            if (Auth::verify2FACode($code)) {
                ActivityLogService::log('Signed in (2FA verified)', 'Authentication', 'Success');
                App::redirect('/admin/dashboard', ['success' => 'Two-Factor Authentication verified. Welcome back to the clinic workspace!']);
            }

            ActivityLogService::log(
                'Failed 2FA verification attempt',
                'Authentication',
                'Warning',
                ['email' => $pending['user']['email'] ?? 'unknown'],
                $pending['user'] ?? null
            );
            App::redirect('/admin/login', ['error' => 'Invalid or expired 6-digit code. Please enter the verification code displayed below.']);
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            App::redirect('/admin/login', ['error' => 'Please enter both your work email and password.']);
        }

        $user = Auth::validateCredentials($email, $password);
        if ($user !== null) {
            Auth::create2FASession($user);
            App::redirect('/admin/login', ['success' => 'Credentials verified. Please enter the 6-digit security code to complete sign in.']);
        }

        ActivityLogService::log(
            'Failed login attempt',
            'Authentication',
            'Error',
            ['email' => $email],
            ['user_key' => 'GUEST', 'name' => $email, 'email' => $email, 'role_key' => 'guest', 'role' => 'Guest']
        );
        App::redirect('/admin/login', ['error' => 'Invalid email, password, or inactive account. Please try again.']);
    }

    public function cancel2FA(): void
    {
        Auth::cancel2FA();
        App::redirect('/admin/login');
    }

    public function logout(): void
    {
        if (Auth::check()) {
            ActivityLogService::log('Signed out', 'Authentication', 'Success');
        }
        Auth::logout();
        App::redirect('/admin/login', ['success' => 'You have been securely signed out.']);
    }
}
