<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table): void {
            $table->id();
            $table->string('booking_reference', 32)->unique();
            $table->foreignId('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->restrictOnDelete();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->restrictOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', [
                'pending_confirmation',
                'confirmed',
                'checked_in',
                'in_treatment',
                'completed',
                'rescheduled',
                'cancelled_by_patient',
                'cancelled_by_clinic',
                'no_show',
            ])->default('pending_confirmation');
            $table->string('cancellation_reason', 255)->nullable();
            $table->string('booking_channel', 50)->default('website_booking'); // website_booking, phone, walk_in, app
            $table->text('patient_notes')->nullable();
            $table->text('internal_staff_notes')->nullable();
            $table->timestamps();

            $table->index(['clinic_id', 'appointment_date', 'status'], 'idx_appointments_daily_schedule');
            $table->index(['doctor_profile_id', 'appointment_date', 'start_time'], 'idx_doctor_slot_lookup');
            $table->index(['patient_profile_id', 'status'], 'idx_patient_appointment_history');
            $table->index('booking_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
