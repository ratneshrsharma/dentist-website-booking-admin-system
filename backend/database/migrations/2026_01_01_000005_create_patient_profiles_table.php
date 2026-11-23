<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->foreignId('primary_clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->string('medical_record_number', 40)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('gender', ['male', 'female', 'other', 'undisclosed'])->default('undisclosed');
            $table->date('date_of_birth');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'unknown'])->default('unknown');
            $table->string('phone', 30);
            $table->string('email', 191)->nullable();
            $table->string('emergency_contact_name', 150)->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->text('allergies')->nullable();
            $table->text('systemic_conditions')->nullable();
            $table->text('ongoing_medications')->nullable();
            $table->string('insurance_provider', 150)->nullable();
            $table->string('insurance_policy_number', 100)->nullable();
            $table->timestamps();

            $table->index('medical_record_number');
            $table->index('phone');
            $table->index(['last_name', 'first_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
