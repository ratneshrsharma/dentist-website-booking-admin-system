<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case RECEPTIONIST = 'receptionist';
    case BILLING = 'billing';
    case WEBSITE_MANAGER = 'website_manager';
    case PATIENT = 'patient';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrator',
            self::ADMIN => 'Clinic Administrator',
            self::DOCTOR => 'Dental Specialist / Doctor',
            self::RECEPTIONIST => 'Front Desk Receptionist',
            self::BILLING => 'Billing & Accounts Officer',
            self::WEBSITE_MANAGER => 'Website Content Manager',
            self::PATIENT => 'Registered Patient',
        };
    }

    public function canAccessAdminPanel(): bool
    {
        return $this !== self::PATIENT;
    }

    public function canManageMultipleClinics(): bool
    {
        return $this === self::SUPER_ADMIN;
    }
}
