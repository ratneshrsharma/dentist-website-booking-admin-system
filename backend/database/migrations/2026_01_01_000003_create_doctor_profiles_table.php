<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('license_number', 80)->unique();
            $table->string('specialization', 150);
            $table->string('qualifications', 255);
            $table->unsignedTinyInteger('years_of_experience')->default(1);
            $table->text('biography')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(500.00);
            $table->string('calendar_color_code', 10)->default('#1976D2');
            $table->boolean('is_accepting_new_patients')->default(true);
            $table->timestamps();

            $table->index('specialization');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
