<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('page_key', 60)->unique();
            $table->string('active_template', 50)->default('modern_minimalist'); // modern_minimalist, classic_heritage, clinical_luxury
            $table->string('meta_title', 200);
            $table->string('meta_description', 255);
            $table->string('hero_headline', 255);
            $table->text('hero_subheadline');
            $table->string('cta_primary_label', 60)->default('Book Appointment');
            $table->string('cta_primary_url', 255)->default('/booking');
            $table->json('content_blocks')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('page_key');
            $table->index('is_published');
        });

        Schema::create('cms_services', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('service_id')->unique()->constrained('services')->cascadeOnDelete();
            $table->string('featured_badge', 60)->nullable(); // "Most Popular", "Pain Free", "Cosmetic Top"
            $table->string('hero_image_url', 255)->nullable();
            $table->json('before_after_gallery')->nullable();
            $table->json('faq_items')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_featured_on_home')->default(false);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index('is_featured_on_home');
        });

        Schema::create('cms_reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->string('patient_name', 100);
            $table->unsignedTinyInteger('rating_stars')->default(5); // 1-5
            $table->string('treatment_name', 100)->nullable();
            $table->text('review_text');
            $table->string('verified_source', 50)->default('google_reviews'); // google_reviews, trustpilot, direct_patient
            $table->boolean('is_approved')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_reviews');
        Schema::dropIfExists('cms_services');
        Schema::dropIfExists('cms_pages');
    }
};
