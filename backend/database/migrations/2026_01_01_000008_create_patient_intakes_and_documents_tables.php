<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_intakes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('appointment_id')->unique()->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->cascadeOnDelete();
            $table->text('chief_complaint');
            $table->unsignedTinyInteger('pain_level_1_to_10')->default(0);
            $table->string('last_dental_visit_interval', 80)->default('more_than_one_year');
            $table->boolean('is_experiencing_sensitivity')->default(false);
            $table->boolean('has_bleeding_gums')->default(false);
            $table->boolean('has_jaw_clicking_or_pain')->default(false);
            $table->boolean('is_pregnant_or_nursing')->default(false);
            $table->boolean('has_pacemaker_or_heart_valve')->default(false);
            $table->string('digital_signature_hash', 64);
            $table->timestamp('consent_acknowledged_at');
            $table->timestamps();

            $table->index('patient_profile_id');
        });

        Schema::create('patient_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->string('document_type', 60); // xray_bitewing, xray_periapical, panoramic_opg, intraoral_photo, lab_report, consent_form
            $table->string('file_title', 150);
            $table->string('stored_file_path', 255);
            $table->string('original_filename', 255);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size_bytes');
            $table->string('sha256_checksum', 64);
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['patient_profile_id', 'document_type'], 'idx_patient_doc_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_documents');
        Schema::dropIfExists('patient_intakes');
    }
};
