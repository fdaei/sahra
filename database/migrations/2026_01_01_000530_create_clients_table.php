<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Trust-proof logo strip. Figma: 1419:9205 — six client logos behind an
 * edge-fade mask (1419:9215), scrolling as animation A2.
 *
 * `name` is translatable because the alt text must localise; the logo file
 * itself is shared across locales.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table): void {
            $table->id();

            $table->string('logo_path', 500);
            $table->string('website_url', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('client_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('name', 150);
            $table->string('logo_alt', 300)->nullable();
            $table->timestamps();

            $table->unique(['client_id', 'locale'], 'client_translations_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_translations');
        Schema::dropIfExists('clients');
    }
};
