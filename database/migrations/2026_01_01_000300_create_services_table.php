<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The four services. Figma: 1323:7189 (Services page), 1419:9279 (Home cloud).
 *
 * NOTE — no public detail route exists (confirmed: the design presents all
 * services as alternating sections on one page). Services are still
 * independently manageable: sortable, publishable, translatable, and reusable
 * on both the Services page and the Home services cloud. `slug` exists as a
 * stable anchor target (/services#branding) and filter key, NOT as a route.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();

            $table->string('status', 20)->default(PublicationStatus::Published->value);
            $table->timestamp('published_at')->nullable();

            $table->unsignedSmallInteger('sort_order')->default(0);

            // Shown as a chip in the Home "services cloud" (1419:9295).
            $table->boolean('show_on_home')->default(true);

            $table->string('icon', 50)->nullable();
            $table->string('image_path', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at', 'sort_order'], 'services_public_index');
            $table->index('show_on_home');
        });

        Schema::create('service_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('title', 200);
            $table->string('slug', 200)->comment('Anchor + filter key, not a route');
            $table->text('description')->nullable();

            // Figma shows a bullet list per service (e.g. "Logo design").
            $table->json('features')->nullable()->comment('array<string>');

            $table->string('image_alt', 300)->nullable();

            $table->timestamps();

            $table->unique(['service_id', 'locale'], 'service_translations_unique');
            $table->unique(['locale', 'slug'], 'service_translations_slug_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_translations');
        Schema::dropIfExists('services');
    }
};
