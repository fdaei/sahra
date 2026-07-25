<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ordered content blocks, attached polymorphically.
 *
 * `sectionable` is either a Page (home hero, about story…) or a Project
 * (goals, strategy, deliverables, results). Both render through the same card
 * components, so one table and one Filament relation manager serve both rather
 * than duplicating the machinery per parent type.
 *
 * Maps 1:1 to the section inventory in docs/FIGMA-AUDIT.md §5. `type` selects
 * the Vue component; `is_visible` lets an editor hide a section without
 * deleting its content (the empty `packages` frame, audit gap G4, ships hidden).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table): void {
            $table->id();

            $table->morphs('sectionable'); // sectionable_type + sectionable_id, indexed

            $table->string('type', 40)->comment('App\Enums\SectionType');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);

            // Background / feature image for hero-style sections.
            $table->string('image_path', 500)->nullable();

            $table->timestamps();

            $table->index(
                ['sectionable_type', 'sectionable_id', 'is_visible', 'sort_order'],
                'page_sections_render_index',
            );
            $table->index('type');
        });

        Schema::create('page_section_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('page_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('eyebrow', 150)->nullable()->comment('Figma "small title" 1419:9231');
            $table->string('title', 300)->nullable();
            $table->string('subtitle', 300)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();

            // Figma hero shows two CTAs; cards show one.
            $table->string('primary_cta_label', 100)->nullable();
            $table->string('primary_cta_url', 500)->nullable();
            $table->string('secondary_cta_label', 100)->nullable();
            $table->string('secondary_cta_url', 500)->nullable();

            $table->string('image_alt', 300)->nullable();

            $table->timestamps();

            $table->unique(['page_section_id', 'locale'], 'page_section_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_section_translations');
        Schema::dropIfExists('page_sections');
    }
};
