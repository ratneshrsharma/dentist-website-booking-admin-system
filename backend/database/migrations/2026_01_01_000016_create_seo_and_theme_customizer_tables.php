<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Yoast-Style SEO Metadata Table
        Schema::create('seo_metadata', function (Blueprint $table): void {
            $table->id();
            $table->string('entity_type', 50)->default('page'); // page, treatment, doctor, blog
            $table->string('entity_slug', 150)->unique();
            $table->string('meta_title', 200)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->string('canonical_url', 255)->nullable();

            // OpenGraph (Social Sharing)
            $table->string('og_title', 200)->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image_url', 255)->nullable();
            $table->string('og_type', 50)->default('website');

            // Twitter / X Card
            $table->string('twitter_card', 50)->default('summary_large_image');
            $table->string('twitter_title', 200)->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image_url', 255)->nullable();

            // Robot Directives
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);

            // JSON-LD Structured Data Schema
            $table->string('schema_type', 60)->default('MedicalBusiness'); // MedicalBusiness, Dentist, MedicalProcedure, FAQPage, BreadcrumbList, Custom
            $table->json('schema_json')->nullable();

            // Per-Page Code Injection
            $table->mediumText('custom_css')->nullable();
            $table->mediumText('custom_js_head')->nullable(); // Injected in <head>
            $table->mediumText('custom_js_footer')->nullable(); // Injected before </body>

            $table->timestamps();

            $table->index(['entity_type', 'entity_slug']);
        });

        // 2. SEO Redirects Engine (301, 302, 404, 410)
        Schema::create('seo_redirects', function (Blueprint $table): void {
            $table->id();
            $table->string('source_url', 255)->unique();
            $table->string('target_url', 255);
            $table->unsignedSmallInteger('status_code')->default(301); // 301, 302, 307, 308, 404, 410
            $table->unsignedBigInteger('hit_count')->default(0);
            $table->timestamp('last_hit_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('status_code');
        });

        // 3. Dynamic Visual Theme Customizer Settings
        Schema::create('theme_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group', 50); // colors, typography, fonts, general
            $table->string('key', 80)->unique();
            $table->json('value');
            $table->string('description', 255)->nullable();
            $table->timestamps();

            $table->index('group');
        });

        // 4. Headless CMS Rich Treatment Procedures
        Schema::create('cms_treatments', function (Blueprint $table): void {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('title', 150);
            $table->string('category_name', 100); // Dental Implants, Cosmetic Dentistry, Periodontics, General & Restorative
            $table->string('subtitle', 255)->nullable();
            $table->string('hero_image_url', 255)->nullable();
            $table->longText('overview_html')->nullable();
            $table->json('benefits_list')->nullable();
            $table->json('procedure_steps')->nullable();
            $table->json('faq_items')->nullable();
            $table->string('duration', 60)->nullable();
            $table->string('recovery_time', 60)->nullable();
            $table->string('cost_estimate', 80)->nullable();
            $table->string('featured_badge', 60)->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('category_name');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_treatments');
        Schema::dropIfExists('theme_settings');
        Schema::dropIfExists('seo_redirects');
        Schema::dropIfExists('seo_metadata');
    }
};
