<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\InvoiceGenerationDTO;
use App\Enums\PaymentStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final class BillingCalculationService
{
    /**
     * Generate an invoice from structured item inputs with tax and discount calculation.
     */
    public function generateInvoice(InvoiceGenerationDTO $dto): Invoice
    {
        if (empty($dto->items)) {
            throw new InvalidArgumentException('Invoice must contain at least one line item.');
        }

        return DB::transaction(function () use ($dto): Invoice {
            $subtotal = 0.0;

            foreach ($dto->items as $item) {
                $subtotal += ($item['quantity'] * $item['unit_price']);
            }

            $taxAmount = round(($subtotal * ($dto->taxPercentage / 100.0)), 2);
            $totalAmount = round($subtotal + $taxAmount - $dto->discountAmount, 2);

            $invoiceNumber = $this->generateUniqueInvoiceNumber($dto->clinicId);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'clinic_id' => $dto->clinicId,
                'patient_profile_id' => $dto->patientProfileId,
                'treatment_plan_id' => $dto->treatmentPlanId,
                'appointment_id' => $dto->appointmentId,
                'issue_date' => $dto->issueDate,
                'due_date' => $dto->dueDate,
                'subtotal' => $subtotal,
                'tax_percentage' => $dto->taxPercentage,
                'tax_amount' => $taxAmount,
                'discount_amount' => $dto->discountAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => 0.0,
                'balance_due' => $totalAmount,
                'status' => 'issued',
                'billing_notes' => $dto->notes,
            ]);

            foreach ($dto->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $item['service_id'] ?? null,
                    'treatment_procedure_id' => $item['treatment_procedure_id'] ?? null,
                    'item_description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => round($item['quantity'] * $item['unit_price'], 2),
                ]);
            }

            return $invoice;
        });
    }

    /**
     * Apply a payment toward an outstanding invoice balance.
     */
    public function recordPayment(
        Invoice $invoice,
        float $amount,
        string $paymentMethod,
        ?string $transactionReference = null,
        ?int $receivedByUserId = null
    ): Payment {
        if ($amount <= 0.0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        return DB::transaction(function () use ($invoice, $amount, $paymentMethod, $transactionReference, $receivedByUserId): Payment {
            $paymentReference = 'PAY-' . strtoupper(bin2hex(random_bytes(6)));

            $payment = Payment::create([
                'payment_reference' => $paymentReference,
                'invoice_id' => $invoice->id,
                'payment_method' => $paymentMethod,
                'transaction_reference' => $transactionReference,
                'amount' => $amount,
                'payment_date' => now(),
                'status' => PaymentStatus::SUCCESSFUL,
                'received_by_user_id' => $receivedByUserId,
            ]);

            $newPaidAmount = $invoice->paid_amount + $amount;
            $newBalanceDue = max(0.0, $invoice->total_amount - $newPaidAmount);

            $status = $newBalanceDue <= 0.0 ? 'paid' : 'partially_paid';

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'balance_due' => $newBalanceDue,
                'status' => $status,
            ]);

            return $payment;
        });
    }

    /**
     * Generate unique clinical invoice identifier: SCD-INV-2026-XXXX
     */
    private function generateUniqueInvoiceNumber(int $clinicId): string
    {
        $prefix = sprintf('INV-%03d-%s-', $clinicId, date('Y'));

        return $prefix . strtoupper(bin2hex(random_bytes(3)));
    }
}
