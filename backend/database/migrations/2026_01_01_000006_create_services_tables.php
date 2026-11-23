<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->string('icon_name', 60)->default('Stethoscope');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->restrictOnDelete();
            $table->string('name', 150);
            $table->string('slug', 170)->unique();
            $table->string('short_description', 255);
            $table->text('detailed_description')->nullable();
            $table->unsignedSmallInteger('standard_duration_minutes')->default(30);
            $table->decimal('base_cost', 10, 2);
            $table->boolean('requires_xray')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });

        Schema::create('doctor_services', function (Blueprint $table): void {
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->decimal('custom_fee', 10, 2)->nullable();
            $table->primary(['doctor_profile_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_services');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
};
