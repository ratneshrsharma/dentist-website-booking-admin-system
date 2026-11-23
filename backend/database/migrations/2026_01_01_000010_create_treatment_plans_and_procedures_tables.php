<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_plans', function (Blueprint $table): void {
            $table->id();
            $table->string('plan_code', 32)->unique();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->restrictOnDelete();
            $table->string('title', 200);
            $table->text('diagnosis_summary');
            $table->enum('status', [
                'draft',
                'presented',
                'accepted',
                'in_progress',
                'completed',
                'declined',
            ])->default('draft');
            $table->decimal('total_estimated_amount', 10, 2)->default(0.00);
            $table->timestamp('accepted_at')->nullable();
            $table->string('patient_signature_hash', 64)->nullable();
            $table->timestamps();

            $table->index(['patient_profile_id', 'status'], 'idx_plans_patient_status');
            $table->index('plan_code');
        });

        Schema::create('treatment_procedures', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('treatment_plan_id')->constrained('treatment_plans')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->unsignedTinyInteger('tooth_number')->nullable();
            $table->unsignedTinyInteger('phase_number')->default(1);
            $table->unsignedSmallInteger('sequence_order')->default(1);
            $table->decimal('estimated_cost', 10, 2);
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->enum('status', [
                'planned',
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('planned');
            $table->foreignId('linked_appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('completed_by_doctor_id')->nullable()->constrained('doctor_profiles')->nullOnDelete();
            $table->text('clinical_notes')->nullable();
            $table->timestamps();

            $table->index(['treatment_plan_id', 'phase_number', 'sequence_order'], 'idx_plan_phase_order');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_procedures');
        Schema::dropIfExists('treatment_plans');
    }
};
