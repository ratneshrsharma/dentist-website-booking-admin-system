<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_charts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignId('examined_by_doctor_id')->constrained('doctor_profiles')->restrictOnDelete();
            $table->string('chart_system', 30)->default('universal_32'); // universal_32, fdi_two_digit, palmer
            $table->date('chart_date');
            $table->text('clinical_notes')->nullable();
            $table->timestamps();

            $table->index(['patient_profile_id', 'chart_date'], 'idx_chart_patient_date');
        });

        Schema::create('tooth_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dental_chart_id')->constrained('dental_charts')->cascadeOnDelete();
            $table->unsignedTinyInteger('tooth_number'); // 1 to 32
            $table->string('condition_code', 50)->default('sound_healthy');
            $table->json('affected_surfaces')->nullable(); // ['mesial', 'occlusal', 'distal', 'buccal', 'lingual']
            $table->json('periodontal_pocket_depths')->nullable(); // mm depths [2, 3, 2, 4, 3, 2]
            $table->text('clinical_remarks')->nullable();
            $table->timestamps();

            $table->unique(['dental_chart_id', 'tooth_number'], 'uniq_chart_tooth');
            $table->index('condition_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tooth_records');
        Schema::dropIfExists('dental_charts');
    }
};
