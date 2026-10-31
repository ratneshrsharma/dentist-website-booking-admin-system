<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\ClinicStock;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

final class InventoryItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $hqClinic = Clinic::where('slug', 'advanced-dental-central')->first();
        if (! $hqClinic) {
            return;
        }

        $items = [
            [
                'item_code' => 'MAT-COMP-A2',
                'name' => '3M Filtek Supreme Ultra Universal Restorative (Shade A2)',
                'category' => 'restorative',
                'unit_of_measure' => 'syringe',
                'unit_purchase_cost' => 68.50,
                'reorder_threshold_quantity' => 15,
                'batch' => 'LOT-3M-99120',
                'quantity' => 45,
                'expiry' => '2027-12-31',
                'bin' => 'A-02-01',
            ],
            [
                'item_code' => 'MAT-ANES-SEPT',
                'name' => 'Septocaine 4% Articaine Hydrochloride with Epinephrine 1:100,000',
                'category' => 'pharmaceutical',
                'unit_of_measure' => 'box',
                'unit_purchase_cost' => 54.00,
                'reorder_threshold_quantity' => 20,
                'batch' => 'LOT-SPT-88412',
                'quantity' => 60,
                'expiry' => '2028-06-30',
                'bin' => 'PHARM-LOCKER-1',
            ],
            [
                'item_code' => 'MAT-BOND-SCOTCH',
                'name' => '3M Scotchbond Universal Plus Adhesive (5ml Bottle)',
                'category' => 'restorative',
                'unit_of_measure' => 'bottle',
                'unit_purchase_cost' => 115.00,
                'reorder_threshold_quantity' => 8,
                'batch' => 'LOT-SB-77401',
                'quantity' => 22,
                'expiry' => '2027-09-15',
                'bin' => 'A-02-04',
            ],
            [
                'item_code' => 'IMP-STR-BLX-41',
                'name' => 'Straumann BLX Dental Implant Ø 4.1mm RB Roxolid SLActive (12mm)',
                'category' => 'surgical_implant',
                'unit_of_measure' => 'piece',
                'unit_purchase_cost' => 285.00,
                'reorder_threshold_quantity' => 10,
                'batch' => 'LOT-STM-55102',
                'quantity' => 25,
                'expiry' => '2030-01-01',
                'bin' => 'SURG-CABINET-A',
            ],
            [
                'item_code' => 'PPE-GLOVE-NIT-M',
                'name' => 'Halyard Health Lavender Nitrile Exam Gloves Powder-Free (Medium, Box of 250)',
                'category' => 'ppe_consumable',
                'unit_of_measure' => 'box',
                'unit_purchase_cost' => 18.50,
                'reorder_threshold_quantity' => 30,
                'batch' => 'LOT-HYD-11200',
                'quantity' => 120,
                'expiry' => '2029-05-31',
                'bin' => 'SUPPLY-ROOM-SHELF-4',
            ],
        ];

        foreach ($items as $itemData) {
            $batch = $itemData['batch'];
            $quantity = $itemData['quantity'];
            $expiry = $itemData['expiry'];
            $bin = $itemData['bin'];

            unset($itemData['batch'], $itemData['quantity'], $itemData['expiry'], $itemData['bin']);

            $item = InventoryItem::updateOrCreate(['item_code' => $itemData['item_code']], $itemData);

            ClinicStock::updateOrCreate(
                [
                    'clinic_id' => $hqClinic->id,
                    'inventory_item_id' => $item->id,
                    'batch_lot_number' => $batch,
                ],
                [
                    'current_quantity' => $quantity,
                    'expiry_date' => $expiry,
                    'bin_location' => $bin,
                ]
            );
        }
    }
}
