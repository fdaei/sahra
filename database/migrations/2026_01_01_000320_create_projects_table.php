<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Case studies. Figma: listing 1362:7198, detail 1323:7541.
 *
 * Structured detail content (goals, strategy, deliverables, results) lives in
 * page_sections/section_items attached polymorphically via `sectionable`, so
 * the same card components serve both Pages and Projects.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('industry_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('status', 20)->default(PublicationStatus::Draft->value);
            $table->timestamp('published_at')->nullable();

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false)->comment('Home projects showcase 1419:9216');

            // Meta row — Figma 1323:7576
            $table->string('year', 10)->nullable();
            $table->string('instagram_handle', 100)->nullable();

            // Media
            $table->string('cover_path', 500)->nullable();
            $table->string('banner_path', 500)->nullable();
            $table->string('before_image_path', 500)->nullable();
            $table->string('after_image_path', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at', 'sort_order'], 'projects_public_index');
            $table->index(['is_featured', 'status']);
            $table->index('industry_id');
        });

        Schema::create('project_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('title', 200);
            $table->string('slug', 200);
            $table->string('subtitle', 300)->nullable();
            $table->text('excerpt')->nullable()->comment('Card description on the listing');

            // Challenge block — Figma 1323:7605
            $table->text('challenge')->nullable();
            $table->json('challenge_points')->nullable()->comment('array<string>');

            $table->text('results_summary')->nullable();

            $table->string('seo_title', 200)->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->string('cover_alt', 300)->nullable();

            $table->timestamps();

            $table->unique(['project_id', 'locale'], 'project_translations_unique');
            $table->unique(['locale', 'slug'], 'project_translations_slug_unique');
            $table->index('locale');
        });

        // Services delivered on a project — the "Services" meta row.
        Schema::create('project_service', function (Blueprint $table): void {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            $table->primary(['project_id', 'service_id']);
            $table->index('service_id');
        });

        // Content-showcase gallery — Figma 1323:7541 "Content Showcase".
        Schema::create('project_images', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('path', 500);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['project_id', 'sort_order']);
        });

        Schema::create('project_image_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('project_image_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('alt', 300)->nullable();
            $table->timestamps();

            $table->unique(['project_image_id', 'locale'], 'project_image_translations_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_image_translations');
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('project_service');
        Schema::dropIfExists('project_translations');
        Schema::dropIfExists('projects');
    }
};
