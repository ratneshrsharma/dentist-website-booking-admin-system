<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $item_code
 * @property string $name
 * @property string $category restorative, endodontic, surgical_implant, orthodontic, ppe_consumable, pharmaceutical, sterilization
 * @property string $unit_of_measure piece, box, pack, syringe, bottle, vial
 * @property float $unit_purchase_cost
 * @property int $reorder_threshold_quantity
 * @property bool $is_active
 */
final class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $fillable = [
        'item_code',
        'name',
        'category',
        'unit_of_measure',
        'unit_purchase_cost',
        'reorder_threshold_quantity',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit_purchase_cost' => 'float',
            'reorder_threshold_quantity' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ClinicStock::class, 'inventory_item_id');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'inventory_item_id');
    }
}
