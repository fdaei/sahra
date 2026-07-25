<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Customer reviews marquee. Figma: 1419:9243, card 1419:9251.
 * The design shows a 7-card horizontal track (animation A6).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();

            $table->string('avatar_path', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('testimonial_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('testimonial_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('author_name', 150);
            $table->string('author_role', 200)->nullable();
            $table->text('quote');
            $table->string('avatar_alt', 300)->nullable();
            $table->timestamps();

            $table->unique(['testimonial_id', 'locale'], 'testimonial_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_translations');
        Schema::dropIfExists('testimonials');
    }
};
