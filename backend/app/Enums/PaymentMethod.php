<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CARD_POS = 'card_pos';
    case UPI = 'upi';
    case BANK_TRANSFER = 'bank_transfer';
    case STRIPE = 'stripe';
    case RAZORPAY = 'razorpay';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash Payment',
            self::CARD_POS => 'Credit / Debit Card (Clinic POS Terminal)',
            self::UPI => 'Unified Payments Interface (UPI / QR Code)',
            self::BANK_TRANSFER => 'Direct Bank Transfer / NEFT',
            self::STRIPE => 'Stripe Online Gateway',
            self::RAZORPAY => 'Razorpay Gateway',
        };
    }
}
