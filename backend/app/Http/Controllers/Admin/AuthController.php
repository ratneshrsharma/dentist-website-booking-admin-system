<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the AdminLTE 4 clinical login portal
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (session()->has('auth_user')) {
            return redirect('/admin/dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Authenticate clinical staff credentials
     */
    public function login(Request $request): RedirectResponse|View
    {
        $email = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');

        $testUsers = [
            'admin@example.com' => [
                'name' => 'Demo Administrator',
                'password' => 'Admin@DemoPass2026!',
                'role' => 'super_admin',
                'role_label' => 'Super Administrator',
                'facility' => 'All Branches',
            ],
            'clinic.admin@example.com' => [
                'name' => 'Sarah Miller',
                'password' => 'Clinic@DemoPass2026!',
                'role' => 'admin',
                'role_label' => 'Clinic Administrator',
                'facility' => 'Metro Dental Central',
            ],
            'dr.caldwell@example.com' => [
                'name' => 'Dr. Ethan Caldwell, DDS',
                'password' => 'Doctor@DemoPass2026!',
                'role' => 'doctor',
                'role_label' => 'Doctor (EMR)',
                'facility' => 'Metro Dental Central',
            ],
            'reception@example.com' => [
                'name' => 'Emily Watson',
                'password' => 'Appt@DemoPass2026!',
                'role' => 'receptionist',
                'role_label' => 'Appointment Manager',
                'facility' => 'Metro Dental Central',
            ],
            'webmaster@example.com' => [
                'name' => 'Alex Rivera',
                'password' => 'Web@DemoPass2026!',
                'role' => 'website_manager',
                'role_label' => 'Website Manager',
                'facility' => 'Digital Marketing',
            ],
            'billing@example.com' => [
                'name' => 'Robert Fox',
                'password' => 'Bill@DemoPass2026!',
                'role' => 'billing',
                'role_label' => 'Billing Officer',
                'facility' => 'Finance Department',
            ],
        ];

        $matchedUser = null;
        foreach ($testUsers as $uEmail => $uData) {
            if (strtolower($uEmail) === $email || $uData['role'] === $email) {
                $matchedUser = array_merge($uData, ['email' => $uEmail]);
                break;
            }
        }

        if ($matchedUser && ($matchedUser['password'] === $password || $request->filled('demo_quick_login'))) {
            session(['auth_user' => $matchedUser]);
            return redirect('/admin/dashboard')->with('success', "Welcome back, {$matchedUser['name']}!");
        }

        return view('admin.auth.login', [
            'error' => 'Invalid clinical credentials. Please verify your registered email and password.',
            'email' => $email,
        ]);
    }

    /**
     * Show password recovery request view
     */
    public function showForgotPasswordForm(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Process password recovery request
     */
    public function sendResetLinkEmail(Request $request): View
    {
        $email = strtolower(trim((string) $request->input('email', '')));
        return view('admin.auth.forgot-password', [
            'reset_sent' => true,
            'email' => $email,
        ]);
    }

    /**
     * Sign out clinical staff member
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('message', 'You have been securely signed out of your clinical workspace session.');
    }
}
