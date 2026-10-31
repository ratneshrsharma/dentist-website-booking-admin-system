<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $clinic_id
 * @property int $inventory_item_id
 * @property StockMovementType $movement_type
 * @property int $quantity
 * @property int|null $reference_procedure_id
 * @property int|null $destination_clinic_id
 * @property int $performed_by_user_id
 * @property string|null $movement_reason
 */
final class StockMovement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'stock_movements';

    protected $fillable = [
        'clinic_id',
        'inventory_item_id',
        'movement_type',
        'quantity',
        'reference_procedure_id',
        'destination_clinic_id',
        'performed_by_user_id',
        'movement_reason',
        'created_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'movement_type' => StockMovementType::class,
            'quantity' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function destinationClinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'destination_clinic_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }
}
