<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class InvoiceGenerationDTO
{
    /**
     * @param list<array{
     *     service_id?: int|null,
     *     treatment_procedure_id?: int|null,
     *     item_description: string,
     *     quantity: int,
     *     unit_price: float,
     *     total_price: float
     * }> $items
     */
    public function __construct(
        public int $clinicId,
        public int $patientProfileId,
        public string $issueDate,
        public string $dueDate,
        public array $items,
        public float $taxPercentage = 0.0,
        public float $discountAmount = 0.0,
        public ?int $treatmentPlanId = null,
        public ?int $appointmentId = null,
        public ?string $billingNotes = null,
    ) {}

    public function calculateSubtotal(): float
    {
        return array_reduce(
            $this->items,
            fn (float $carry, array $item): float => $carry + ((float) $item['unit_price'] * (int) $item['quantity']),
            0.0
        );
    }

    public function calculateTotal(): float
    {
        $subtotal = $this->calculateSubtotal();
        $discounted = max(0.0, $subtotal - $this->discountAmount);
        $tax = $discounted * ($this->taxPercentage / 100.0);

        return round($discounted + $tax, 2);
    }
}
