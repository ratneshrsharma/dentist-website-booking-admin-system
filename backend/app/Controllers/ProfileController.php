<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Services\UserService;
use App\Services\ActivityLogService;

/**
 * Self-Service Profile Controller (Name, Mobile, Password; Email is locked)
 */
class ProfileController
{
    public function index(): void
    {
        Auth::requireAuth();
        $user = Auth::user();
        $userKey = (string) ($user['user_key'] ?? '');

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                // Email is intentionally ignored here — only Admin / Super Admin can change primary login email
                $updated = UserService::updateProfile($userKey, [
                    'name' => $_POST['name'] ?? '',
                    'mobile' => $_POST['mobile'] ?? '',
                    'new_password' => $_POST['new_password'] ?? '',
                    'confirm_password' => $_POST['confirm_password'] ?? '',
                ]);

                ActivityLogService::log(
                    'Updated own profile' . (!empty($_POST['new_password']) ? ' (including password)' : ''),
                    'Profile',
                    'Success',
                    ['user_key' => $userKey]
                );
                App::flash('success', 'Your profile has been updated.');
            } catch (\Throwable $e) {
                ActivityLogService::log('Profile update failed: ' . $e->getMessage(), 'Profile', 'Error', ['user_key' => $userKey]);
                App::flash('error', $e->getMessage());
            }
            App::redirect('/admin/profile');
            return;
        }

        App::render('admin/profile/index', [
            'pageTitle' => 'My Profile',
            'activeNav' => 'profile',
            'profile' => UserService::findByKey($userKey) ?? $user,
        ]);
    }
}
