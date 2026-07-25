<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Repeatable children of a PageSection.
 *
 * One table serves every card list in the design — KPI counters, process
 * steps, why-us cards, how-we-think principles, packages, and (when attached
 * to a Project's sections) goals, strategy, deliverables and result stats.
 * They share an identical shape: an optional numeric/short value, a title and
 * a description, all translatable.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_items', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('page_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);

            $table->string('icon', 50)->nullable()->comment('lucide-vue-next icon name');
            $table->string('image_path', 500)->nullable();

            $table->timestamps();

            $table->index(['page_section_id', 'is_visible', 'sort_order'], 'section_items_render_index');
        });

        Schema::create('section_item_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('section_item_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            // KPI "+70k", result "+189%", process "01" — short display value.
            $table->string('value', 50)->nullable();
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('image_alt', 300)->nullable();

            $table->timestamps();

            $table->unique(['section_item_id', 'locale'], 'section_item_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_item_translations');
        Schema::dropIfExists('section_items');
    }
};
