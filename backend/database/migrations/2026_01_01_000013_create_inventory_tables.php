<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table): void {
            $table->id();
            $table->string('item_code', 50)->unique();
            $table->string('name', 150);
            $table->string('category', 60); // restorative, endodontic, surgical_implant, orthodontic, ppe_consumable, pharmaceutical, sterilization
            $table->string('unit_of_measure', 30); // piece, box, pack, syringe, bottle, vial
            $table->decimal('unit_purchase_cost', 10, 2);
            $table->unsignedInteger('reorder_threshold_quantity')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category');
            $table->index('is_active');
            $table->index('item_code');
        });

        Schema::create('clinic_stocks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->string('batch_lot_number', 60);
            $table->integer('current_quantity')->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('bin_location', 60)->nullable();
            $table->timestamps();

            $table->unique(['clinic_id', 'inventory_item_id', 'batch_lot_number'], 'uniq_clinic_item_batch');
            $table->index('expiry_date');
        });

        Schema::create('stock_movements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->string('movement_type', 50); // purchase_receipt, procedure_consumption, branch_transfer_out, branch_transfer_in, waste_disposal, audit_adjustment
            $table->integer('quantity'); // Positive for receipt/transfer-in, negative for consumption/transfer-out
            $table->foreignId('reference_procedure_id')->nullable()->constrained('treatment_procedures')->nullOnDelete();
            $table->foreignId('destination_clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->foreignId('performed_by_user_id')->constrained('users')->restrictOnDelete();
            $table->string('movement_reason', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['clinic_id', 'inventory_item_id', 'created_at'], 'idx_stock_movement_history');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('clinic_stocks');
        Schema::dropIfExists('inventory_items');
    }
};
