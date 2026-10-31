<?php

declare(strict_types=1);

namespace App\Enums;

enum AppointmentStatus: string
{
    case PENDING_CONFIRMATION = 'pending_confirmation';
    case CONFIRMED = 'confirmed';
    case CHECKED_IN = 'checked_in';
    case IN_TREATMENT = 'in_treatment';
    case COMPLETED = 'completed';
    case RESCHEDULED = 'rescheduled';
    case CANCELLED_BY_PATIENT = 'cancelled_by_patient';
    case CANCELLED_BY_CLINIC = 'cancelled_by_clinic';
    case NO_SHOW = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_CONFIRMATION => 'Pending Confirmation',
            self::CONFIRMED => 'Confirmed',
            self::CHECKED_IN => 'Checked In (Waiting Room)',
            self::IN_TREATMENT => 'In Treatment (Chair Active)',
            self::COMPLETED => 'Completed',
            self::RESCHEDULED => 'Rescheduled',
            self::CANCELLED_BY_PATIENT => 'Cancelled by Patient',
            self::CANCELLED_BY_CLINIC => 'Cancelled by Clinic',
            self::NO_SHOW => 'No Show',
        };
    }

    public function colorCode(): string
    {
        return match ($this) {
            self::PENDING_CONFIRMATION => '#FFA726', // Orange
            self::CONFIRMED => '#66BB6A',            // Green
            self::CHECKED_IN => '#29B6F6',           // Light Blue
            self::IN_TREATMENT => '#AB47BC',         // Purple
            self::COMPLETED => '#78909C',            // Blue-Grey
            self::RESCHEDULED => '#FFCA28',          // Amber
            self::CANCELLED_BY_PATIENT => '#EF5350', // Red
            self::CANCELLED_BY_CLINIC => '#D32F2F',  // Dark Red
            self::NO_SHOW => '#B71C1C',              // Crimson Red
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::CANCELLED_BY_PATIENT,
            self::CANCELLED_BY_CLINIC,
            self::NO_SHOW,
        ], true);
    }
}
