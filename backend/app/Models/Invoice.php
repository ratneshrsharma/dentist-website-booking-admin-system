<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $invoice_number
 * @property int $clinic_id
 * @property int $patient_profile_id
 * @property int|null $treatment_plan_id
 * @property int|null $appointment_id
 * @property string $issue_date
 * @property string $due_date
 * @property float $subtotal
 * @property float $tax_percentage
 * @property float $tax_amount
 * @property float $discount_amount
 * @property float $total_amount
 * @property float $paid_amount
 * @property float $balance_due
 * @property string $status draft, issued, partially_paid, paid, voided, refunded
 */
final class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'clinic_id',
        'patient_profile_id',
        'treatment_plan_id',
        'appointment_id',
        'issue_date',
        'due_date',
        'subtotal',
        'tax_percentage',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'balance_due',
        'status',
        'billing_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'date:Y-m-d',
            'due_date' => 'date:Y-m-d',
            'subtotal' => 'float',
            'tax_percentage' => 'float',
            'tax_amount' => 'float',
            'discount_amount' => 'float',
            'total_amount' => 'float',
            'paid_amount' => 'float',
            'balance_due' => 'float',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }
}
