<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: string
{
    case INITIATED = 'initiated';
    case SUCCESSFUL = 'successful';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::INITIATED => 'Payment Initiated (Pending)',
            self::SUCCESSFUL => 'Payment Successful',
            self::FAILED => 'Payment Failed',
            self::REFUNDED => 'Refunded',
        };
    }
}
