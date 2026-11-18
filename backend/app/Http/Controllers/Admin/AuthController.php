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

        if (session()->has('pending_2fa_user')) {
            return view('admin.auth.login', [
                'step' => '2fa',
                'pendingUser' => session('pending_2fa_user'),
                'demoOtp' => session('pending_2fa_otp', '849201'),
            ]);
        }

        return view('admin.auth.login');
    }

    /**
     * Authenticate clinical staff credentials with 2-Step 2FA Verification
     */
    public function login(Request $request): RedirectResponse|View
    {
        // Cancel/Reset 2FA
        if ($request->has('reset_2fa')) {
            $request->session()->forget(['pending_2fa_user', 'pending_2fa_otp']);
            return redirect('/admin/login');
        }

        $authStep = $request->input('auth_step', 'credentials');

        // ============================================================
        // STEP 2: TWO-FACTOR AUTHENTICATION (2FA) OTP VERIFICATION
        // ============================================================
        if ($authStep === '2fa') {
            if (!$request->session()->has('pending_2fa_user')) {
                return view('admin.auth.login', [
                    'error' => '2FA session expired. Please sign in again with your email and password.',
                ]);
            }

            // Normalize submitted OTP (strip spaces, hyphens, and non-numeric characters)
            $enteredOtp = preg_replace('/\D/', '', (string) $request->input('otp', ''));
            $expectedOtp = (string) $request->session()->get('pending_2fa_otp', '849201');

            if ($enteredOtp !== '' && ($enteredOtp === $expectedOtp || $enteredOtp === '849201')) {
                $user = $request->session()->get('pending_2fa_user');
                $request->session()->forget(['pending_2fa_user', 'pending_2fa_otp']);
                $request->session()->put('auth_user', $user);
                return redirect('/admin/dashboard')->with('success', "Welcome back, {$user['name']}!");
            }

            return view('admin.auth.login', [
                'step' => '2fa',
                'error' => 'Invalid 2FA verification code. Please enter the active 6-digit OTP code displayed below.',
                'pendingUser' => $request->session()->get('pending_2fa_user'),
                'demoOtp' => $expectedOtp,
            ]);
        }

        // ============================================================
        // STEP 1: WORK EMAIL & PASSWORD CREDENTIAL VALIDATION
        // ============================================================
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
            $activeOtp = (string) rand(100000, 999999);
            $request->session()->put('pending_2fa_user', $matchedUser);
            $request->session()->put('pending_2fa_otp', $activeOtp);

            return view('admin.auth.login', [
                'step' => '2fa',
                'pendingUser' => $matchedUser,
                'demoOtp' => $activeOtp,
                'message' => 'Credentials verified. Complete Step 2: Enter the 6-digit Two-Factor (2FA) verification code.',
            ]);
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
