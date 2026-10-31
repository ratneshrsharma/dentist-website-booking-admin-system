<?php

declare(strict_types=1);

namespace App\Enums;

enum StockMovementType: string
{
    case PURCHASE_RECEIPT = 'purchase_receipt';
    case PROCEDURE_CONSUMPTION = 'procedure_consumption';
    case BRANCH_TRANSFER_OUT = 'branch_transfer_out';
    case BRANCH_TRANSFER_IN = 'branch_transfer_in';
    case DAMAGE_WRITEOFF = 'damage_writeoff';
    case EXPIRY_DISPOSAL = 'expiry_disposal';
    case AUDIT_RECONCILIATION = 'audit_reconciliation';

    public function label(): string
    {
        return match ($this) {
            self::PURCHASE_RECEIPT => 'Purchase Order Receipt',
            self::PROCEDURE_CONSUMPTION => 'Clinical Procedure Consumption',
            self::BRANCH_TRANSFER_OUT => 'Inter-Branch Transfer (Outbound)',
            self::BRANCH_TRANSFER_IN => 'Inter-Branch Transfer (Inbound Receipt)',
            self::DAMAGE_WRITEOFF => 'Damage / Spoilage Write-Off',
            self::EXPIRY_DISPOSAL => 'Expired Product Disposal',
            self::AUDIT_RECONCILIATION => 'Physical Audit Stock Reconciliation',
        };
    }

    public function isPositive(): bool
    {
        return in_array($this, [
            self::PURCHASE_RECEIPT,
            self::BRANCH_TRANSFER_IN,
        ], true);
    }
}
