<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Project industries — the tag beside each project card ("Food & Beverage")
 * and the meta row on a case study. Figma: 1362:7211, 1323:7576.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('industry_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('industry_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->timestamps();

            $table->unique(['industry_id', 'locale'], 'industry_translations_unique');
            $table->unique(['locale', 'slug'], 'industry_translations_slug_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industry_translations');
        Schema::dropIfExists('industries');
    }
};
