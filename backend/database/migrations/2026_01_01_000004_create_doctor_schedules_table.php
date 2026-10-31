<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0 = Sunday, 6 = Saturday
            $table->time('shift_start_time');
            $table->time('shift_end_time');
            $table->unsignedSmallInteger('slot_duration_minutes')->default(30);
            $table->unsignedTinyInteger('max_parallel_chairs')->default(1);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['clinic_id', 'doctor_profile_id', 'day_of_week'], 'idx_schedule_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
