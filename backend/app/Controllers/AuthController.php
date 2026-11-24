<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\ThemeService;

class AuthController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            App::redirect('/admin/dashboard');
        }

        $theme = ThemeService::getTheme();
        App::render('admin/auth/login', [
            'theme' => $theme,
            'pageTitle' => 'Staff Login — ' . $theme['branding']['clinic_name'],
        ], false);
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::attempt($email, $password)) {
            App::redirect('/admin/dashboard', ['success' => 'Welcome back! You are now logged into the clinic workspace.']);
        }

        App::redirect('/admin/login', ['error' => 'Invalid email or password. You can use the Quick Demo Sign-in button below.']);
    }

    public function logout(): void
    {
        Auth::logout();
        App::redirect('/admin/login', ['success' => 'You have been securely signed out.']);
    }
}
