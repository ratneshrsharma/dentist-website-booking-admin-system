<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class InventoryTransferDTO
{
    public function __construct(
        public int $sourceClinicId,
        public int $destinationClinicId,
        public int $inventoryItemId,
        public string $batchLotNumber,
        public int $quantityToTransfer,
        public int $performedByUserId,
        public string $transferReason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sourceClinicId: (int) $data['source_clinic_id'],
            destinationClinicId: (int) $data['destination_clinic_id'],
            inventoryItemId: (int) $data['inventory_item_id'],
            batchLotNumber: (string) $data['batch_lot_number'],
            quantityToTransfer: (int) $data['quantity_to_transfer'],
            performedByUserId: (int) $data['performed_by_user_id'],
            transferReason: (string) ($data['transfer_reason'] ?? 'Standard inter-branch supply replenishment'),
        );
    }
}
