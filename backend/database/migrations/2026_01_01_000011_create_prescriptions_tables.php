<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table): void {
            $table->id();
            $table->string('prescription_code', 32)->unique();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->cascadeOnDelete();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->restrictOnDelete();
            $table->foreignId('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->text('diagnosis_notes');
            $table->text('doctor_advice')->nullable();
            $table->date('issued_date');
            $table->timestamps();

            $table->index(['patient_profile_id', 'issued_date'], 'idx_rx_patient_date');
            $table->index('prescription_code');
        });

        Schema::create('prescription_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->cascadeOnDelete();
            $table->string('medication_name', 150);
            $table->string('dosage_form', 60)->default('tablet'); // tablet, capsule, syrup, gel, mouthwash, drops, injection
            $table->string('frequency', 60)->default('twice_daily'); // once_daily, twice_daily, thrice_daily, four_times_daily, as_needed
            $table->string('timing', 60)->default('after_meals'); // before_meals, after_meals, with_meals, bedtime
            $table->unsignedSmallInteger('duration_days')->default(5);
            $table->unsignedSmallInteger('total_quantity')->default(10);
            $table->text('special_instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
    }
};
