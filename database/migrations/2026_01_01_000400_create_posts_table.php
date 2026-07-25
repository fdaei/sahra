<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Blog. Figma: listing 1353:7935, detail 1352:7391.
 *
 * Categories double as the filter chips on the listing (Figma "Filters"
 * 1363:7500 — All / Branding / Marketing Design / Content Production /
 * Social Media support).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('post_category_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('post_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->timestamps();

            $table->unique(['post_category_id', 'locale'], 'post_category_translations_unique');
            $table->unique(['locale', 'slug'], 'post_category_translations_slug_unique');
            $table->index('locale');
        });

        Schema::create('post_tags', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
        });

        Schema::create('post_tag_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('post_tag_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->timestamps();

            $table->unique(['post_tag_id', 'locale'], 'post_tag_translations_unique');
            $table->unique(['locale', 'slug'], 'post_tag_translations_slug_unique');
        });

        Schema::create('posts', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('post_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Author is a panel user; keep the post if the account is removed.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('status', 20)->default(PublicationStatus::Draft->value);
            $table->timestamp('published_at')->nullable();

            $table->boolean('is_featured')->default(false)->comment('Large card, Figma 1419:9265');

            $table->string('cover_path', 500)->nullable();
            $table->unsignedSmallInteger('reading_minutes')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at'], 'posts_public_index');
            $table->index(['is_featured', 'status', 'published_at']);
            $table->index('post_category_id');
        });

        Schema::create('post_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('post_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('title', 250);
            $table->string('slug', 250);
            $table->string('subtitle', 300)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            $table->string('seo_title', 200)->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->string('cover_alt', 300)->nullable();

            $table->timestamps();

            $table->unique(['post_id', 'locale'], 'post_translations_unique');
            $table->unique(['locale', 'slug'], 'post_translations_slug_unique');
            $table->index('locale');
        });

        Schema::create('post_post_tag', function (Blueprint $table): void {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_tag_id')->constrained()->cascadeOnDelete();

            $table->primary(['post_id', 'post_tag_id']);
            $table->index('post_tag_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_post_tag');
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_tag_translations');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_category_translations');
        Schema::dropIfExists('post_categories');
    }
};
