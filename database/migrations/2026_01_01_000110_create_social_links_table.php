<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Social profiles rendered in the footer and on the Contact page.
 * Figma: 1419:9317 (footer "Social Links"), 1363:8934 (contact icon row).
 *
 * Not translatable: platform names and URLs are identical across locales.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table): void {
            $table->id();
            $table->string('platform', 50)->unique();
            $table->string('label', 100);
            $table->string('url', 500);
            $table->string('icon', 50)->comment('lucide-vue-next icon name');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
