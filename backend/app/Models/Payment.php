<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $payment_reference
 * @property int $invoice_id
 * @property PaymentMethod $payment_method
 * @property string|null $transaction_reference
 * @property float $amount
 * @property string $payment_date
 * @property PaymentStatus $status
 * @property array<string, mixed>|null $gateway_payload
 * @property int|null $received_by_user_id
 */
final class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'payment_reference',
        'invoice_id',
        'payment_method',
        'transaction_reference',
        'amount',
        'payment_date',
        'status',
        'gateway_payload',
        'received_by_user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payment_method' => PaymentMethod::class,
            'status' => PaymentStatus::class,
            'amount' => 'float',
            'payment_date' => 'datetime',
            'gateway_payload' => 'array',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }
}
