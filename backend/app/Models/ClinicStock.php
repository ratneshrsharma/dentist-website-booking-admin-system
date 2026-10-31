<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $clinic_id
 * @property int $inventory_item_id
 * @property string $batch_lot_number
 * @property int $current_quantity
 * @property string|null $expiry_date
 * @property string|null $bin_location
 */
final class ClinicStock extends Model
{
    use HasFactory;

    protected $table = 'clinic_stocks';

    protected $fillable = [
        'clinic_id',
        'inventory_item_id',
        'batch_lot_number',
        'current_quantity',
        'expiry_date',
        'bin_location',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'current_quantity' => 'integer',
            'expiry_date' => 'date:Y-m-d',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}
