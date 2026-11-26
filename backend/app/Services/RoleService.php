<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Dynamic Role Management & Granular (view/add/edit/delete) Permissions Service
 */
class RoleService
{
    public const ACTIONS = ['view', 'add', 'edit', 'delete'];

    public const MODULES = [
        'bookings' => 'Patient Bookings',
        'doctors_availability' => 'Doctor Availability & Leave',
        'patients' => 'Patients Management',
        'accounts' => 'Accounts & Invoices',
        'cms_pages' => 'CMS Website Pages',
        'cms_components' => 'Common Components',
        'blog' => 'Blog & Articles',
        'contact_submissions' => 'Contact Form Entries',
        'chat_logs' => 'Assistant Chat Logs',
        'theme' => 'Global Theme & Fonts',
        'settings' => 'Practice Settings',
        'users' => 'User Management',
        'roles' => 'Role Management',
    ];

    private static function getStorageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/app/roles.json';
    }

    public static function getAllRoles(): array
    {
        $file = self::getStorageFile();
        if (file_exists($file)) {
            $data = json_decode((string) file_get_contents($file), true);
            if (is_array($data) && !empty($data)) {
                return $data;
            }
        }
        $defaults = self::getDefaultRoles();
        self::saveAllRoles($defaults);
        return $defaults;
    }

    public static function saveAllRoles(array $roles): void
    {
        $file = self::getStorageFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode(array_values($roles), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function findByKey(string $roleKey): ?array
    {
        foreach (self::getAllRoles() as $r) {
            if (($r['role_key'] ?? '') === $roleKey) {
                return $r;
            }
        }
        return null;
    }

    public static function hasPermission(string $roleKey, string $module, string $action = 'view'): bool
    {
        if ($roleKey === 'super_admin') {
            return true;
        }
        if ($module === 'dashboard' || $module === 'profile') {
            return true;
        }
        if ($module === 'logs' || $module === 'impersonate' || $module === 'create_role') {
            return false;
        }
        $role = self::findByKey($roleKey);
        if (!$role) {
            return false;
        }
        return !empty($role['permissions'][$module][$action]);
    }

    public static function createRole(string $label, array $permissions): array
    {
        $label = trim($label);
        if ($label === '') {
            throw new \InvalidArgumentException('Role name is required.');
        }
        $slug = strtolower((string) preg_replace('/[^a-z0-9]+/i', '_', $label));
        $slug = trim($slug, '_');
        if ($slug === '' || self::findByKey($slug) !== null) {
            $slug = ($slug ?: 'custom_role') . '_' . substr(uniqid(), -4);
        }

        $roles = self::getAllRoles();
        $newRole = [
            'role_key' => $slug,
            'label' => $label,
            'is_system' => false,
            'permissions' => self::normalizePermissions($permissions),
            'created_at' => date('c'),
        ];
        $roles[] = $newRole;
        self::saveAllRoles($roles);
        return $newRole;
    }

    public static function updateRole(string $roleKey, string $label, array $permissions): ?array
    {
        if ($roleKey === 'super_admin') {
            throw new \InvalidArgumentException('Super Admin permissions cannot be restricted.');
        }
        $roles = self::getAllRoles();
        foreach ($roles as &$r) {
            if (($r['role_key'] ?? '') === $roleKey) {
                if (trim($label) !== '' && empty($r['is_system'])) {
                    $r['label'] = trim($label);
                }
                $r['permissions'] = self::normalizePermissions($permissions);
                $r['updated_at'] = date('c');
                self::saveAllRoles($roles);
                return $r;
            }
        }
        unset($r);
        return null;
    }

    public static function deleteRole(string $roleKey): bool
    {
        $target = self::findByKey($roleKey);
        if (!$target || !empty($target['is_system'])) {
            return false;
        }
        $roles = array_values(array_filter(
            self::getAllRoles(),
            static fn($r) => ($r['role_key'] ?? '') !== $roleKey
        ));
        self::saveAllRoles($roles);
        return true;
    }

    public static function normalizePermissions(array $input): array
    {
        $matrix = [];
        foreach (array_keys(self::MODULES) as $mod) {
            $matrix[$mod] = [];
            foreach (self::ACTIONS as $act) {
                $matrix[$mod][$act] = !empty($input[$mod][$act]);
            }
        }
        return $matrix;
    }

    private static function fullPerms(array $modules, array $actions = ['view', 'add', 'edit', 'delete']): array
    {
        $matrix = [];
        foreach (array_keys(self::MODULES) as $mod) {
            $hasMod = in_array($mod, $modules, true);
            foreach (self::ACTIONS as $act) {
                $matrix[$mod][$act] = $hasMod && in_array($act, $actions, true);
            }
        }
        return $matrix;
    }

    private static function getDefaultRoles(): array
    {
        return [
            [
                'role_key' => 'super_admin',
                'label' => 'Super Admin',
                'is_system' => true,
                'permissions' => self::fullPerms(array_keys(self::MODULES)),
            ],
            [
                'role_key' => 'admin',
                'label' => 'Admin',
                'is_system' => true,
                'permissions' => self::fullPerms(array_keys(self::MODULES)),
            ],
            [
                'role_key' => 'website_manager',
                'label' => 'Website Manager',
                'is_system' => true,
                // Website Manager CANNOT see Patients or Smart Dental Assistant Chat Logs
                'permissions' => self::fullPerms(['cms_pages', 'cms_components', 'blog', 'contact_submissions', 'theme']),
            ],
            [
                'role_key' => 'receptionist',
                'label' => 'Receptionist',
                'is_system' => true,
                'permissions' => self::fullPerms(['bookings', 'doctors_availability', 'patients', 'contact_submissions', 'chat_logs']),
            ],
            [
                'role_key' => 'doctor',
                'label' => 'Doctor',
                'is_system' => true,
                // Doctor CANNOT see other doctors or Patients details
                'permissions' => self::fullPerms(['bookings', 'doctors_availability'], ['view', 'edit']),
            ],
            [
                'role_key' => 'accountant',
                'label' => 'Accountant',
                'is_system' => true,
                // Accountant CANNOT see Patients details or Doctors details
                'permissions' => self::fullPerms(['accounts', 'settings'], ['view', 'add', 'edit', 'delete']),
            ],
        ];
    }
}
