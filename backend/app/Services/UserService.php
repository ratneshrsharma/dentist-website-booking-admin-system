<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Multi-Role User Management Service (Keyed by immutable user_key)
 */
class UserService
{
    public const ROLES = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'website_manager' => 'Website Manager',
        'receptionist' => 'Receptionist',
        'doctor' => 'Doctor',
        'accountant' => 'Accountant',
    ];

    public const PERMISSIONS = [
        'super_admin' => ['*'],
        'admin' => [
            'dashboard', 'profile', 'bookings', 'doctors_availability',
            'cms_pages', 'cms_components', 'blog', 'contact_submissions',
            'chat_logs', 'theme', 'settings', 'users',
        ],
        'website_manager' => [
            'dashboard', 'profile', 'cms_pages', 'cms_components',
            'blog', 'contact_submissions', 'chat_logs', 'theme',
        ],
        'receptionist' => [
            'dashboard', 'profile', 'bookings', 'doctors_availability',
            'contact_submissions', 'chat_logs',
        ],
        'doctor' => [
            'dashboard', 'profile', 'bookings', 'doctors_availability',
        ],
        'accountant' => [
            'dashboard', 'profile', 'bookings', 'settings',
        ],
    ];

    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/users.json';
    }

    public static function getRoles(bool $includeSuperAdmin = true): array
    {
        $roles = self::ROLES;
        if (!$includeSuperAdmin) {
            unset($roles['super_admin']);
        }
        return $roles;
    }

    public static function getRoleLabel(string $roleKey): string
    {
        return self::ROLES[$roleKey] ?? ucfirst(str_replace('_', ' ', $roleKey));
    }

    public static function hasPermission(string $roleKey, string $permission): bool
    {
        $allowed = self::PERMISSIONS[$roleKey] ?? [];
        if (in_array('*', $allowed, true)) {
            return true;
        }
        return in_array($permission, $allowed, true);
    }

    public static function getAllUsers(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                return $data;
            }
        }
        $defaults = self::getDefaultUsers();
        self::saveAllUsers($defaults);
        return $defaults;
    }

    public static function saveAllUsers(array $users): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function findByKey(string $userKey): ?array
    {
        foreach (self::getAllUsers() as $u) {
            if (($u['user_key'] ?? '') === $userKey) {
                return $u;
            }
        }
        return null;
    }

    public static function findByEmail(string $email): ?array
    {
        $email = strtolower(trim($email));
        foreach (self::getAllUsers() as $u) {
            if (strtolower((string) ($u['email'] ?? '')) === $email) {
                return $u;
            }
        }
        return null;
    }

    public static function generateUserKey(): string
    {
        return 'USR_' . strtoupper(bin2hex(random_bytes(5)));
    }

    public static function createUser(array $input): array
    {
        $users = self::getAllUsers();
        $email = strtolower(trim((string) ($input['email'] ?? '')));
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('A valid email address is required.');
        }
        if (self::findByEmail($email) !== null) {
            throw new \InvalidArgumentException('A user with this email address already exists.');
        }

        $password = (string) ($input['password'] ?? '');
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException('Password must be at least 6 characters.');
        }

        $roleKey = (string) ($input['role_key'] ?? 'receptionist');
        if (!array_key_exists($roleKey, self::ROLES)) {
            $roleKey = 'receptionist';
        }

        $newUser = [
            'user_key' => self::generateUserKey(),
            'name' => trim((string) ($input['name'] ?? 'Clinic User')),
            'email' => $email,
            'mobile' => trim((string) ($input['mobile'] ?? '')),
            'role_key' => $roleKey,
            'role' => self::getRoleLabel($roleKey),
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'avatar' => '/images/doctor-das.jpg',
            'is_active' => !empty($input['is_active']),
            'created_at' => date('c'),
            'updated_at' => date('c'),
        ];

        $users[] = $newUser;
        self::saveAllUsers($users);
        return $newUser;
    }

    public static function updateUser(string $userKey, array $input, string $actorRoleKey): array
    {
        $users = self::getAllUsers();
        $newEmail = strtolower(trim((string) ($input['email'] ?? '')));
        if ($newEmail === '' || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('A valid email address is required.');
        }

        $existingEmail = self::findByEmail($newEmail);
        if ($existingEmail !== null && ($existingEmail['user_key'] ?? '') !== $userKey) {
            throw new \InvalidArgumentException('Another user already uses this email address.');
        }

        foreach ($users as &$u) {
            if (($u['user_key'] ?? '') === $userKey) {
                if (($u['role_key'] ?? '') === 'super_admin' && $actorRoleKey !== 'super_admin') {
                    throw new \InvalidArgumentException('Only Super Admin can modify a Super Admin account.');
                }

                $roleKey = (string) ($input['role_key'] ?? $u['role_key']);
                if (!array_key_exists($roleKey, self::ROLES)) {
                    $roleKey = $u['role_key'];
                }
                if ($roleKey === 'super_admin' && $actorRoleKey !== 'super_admin') {
                    $roleKey = $u['role_key'];
                }

                $u['name'] = trim((string) ($input['name'] ?? $u['name']));
                $u['email'] = $newEmail;
                $u['mobile'] = trim((string) ($input['mobile'] ?? ''));
                $u['role_key'] = $roleKey;
                $u['role'] = self::getRoleLabel($roleKey);
                $u['is_active'] = ($u['role_key'] === 'super_admin') ? true : !empty($input['is_active']);

                $newPass = (string) ($input['password'] ?? '');
                if ($newPass !== '') {
                    if (strlen($newPass) < 6) {
                        throw new \InvalidArgumentException('Password must be at least 6 characters.');
                    }
                    $u['password_hash'] = password_hash($newPass, PASSWORD_BCRYPT);
                }
                $u['updated_at'] = date('c');

                self::saveAllUsers($users);
                return $u;
            }
        }
        unset($u);

        throw new \InvalidArgumentException('User not found.');
    }

    public static function updateProfile(string $userKey, array $input): array
    {
        $users = self::getAllUsers();
        foreach ($users as &$u) {
            if (($u['user_key'] ?? '') === $userKey) {
                $name = trim((string) ($input['name'] ?? ''));
                if ($name === '') {
                    throw new \InvalidArgumentException('Full name cannot be empty.');
                }
                $u['name'] = $name;
                $u['mobile'] = trim((string) ($input['mobile'] ?? ''));

                $newPass = (string) ($input['new_password'] ?? '');
                if ($newPass !== '') {
                    $confirmPass = (string) ($input['confirm_password'] ?? '');
                    if (strlen($newPass) < 6) {
                        throw new \InvalidArgumentException('New password must be at least 6 characters.');
                    }
                    if ($newPass !== $confirmPass) {
                        throw new \InvalidArgumentException('New password and confirmation do not match.');
                    }
                    $u['password_hash'] = password_hash($newPass, PASSWORD_BCRYPT);
                }
                $u['updated_at'] = date('c');
                self::saveAllUsers($users);
                return $u;
            }
        }
        unset($u);

        throw new \InvalidArgumentException('User account not found.');
    }

    public static function toggleStatus(string $userKey): ?array
    {
        $users = self::getAllUsers();
        foreach ($users as &$u) {
            if (($u['user_key'] ?? '') === $userKey) {
                if (($u['role_key'] ?? '') === 'super_admin') {
                    return $u;
                }
                $u['is_active'] = empty($u['is_active']);
                $u['updated_at'] = date('c');
                self::saveAllUsers($users);
                return $u;
            }
        }
        unset($u);
        return null;
    }

    public static function deleteUser(string $userKey): void
    {
        $users = array_values(array_filter(
            self::getAllUsers(),
            static fn($u) => ($u['user_key'] ?? '') !== $userKey || ($u['role_key'] ?? '') === 'super_admin'
        ));
        self::saveAllUsers($users);
    }

    private static function getDefaultUsers(): array
    {
        return [
            [
                'user_key' => 'USR_SUPERADMIN_001',
                'name' => 'Dr. Ratnesh Sharma',
                'email' => 'admin@example.com',
                'mobile' => '+44 121 765 2870',
                'role_key' => 'super_admin',
                'role' => 'Super Admin',
                'password_hash' => password_hash('Admin@DemoPass2026!', PASSWORD_BCRYPT),
                'avatar' => '/images/doctor-das.jpg',
                'is_active' => true,
                'created_at' => '2026-01-01T09:00:00+00:00',
                'updated_at' => '2026-01-01T09:00:00+00:00',
            ],
        ];
    }
}
