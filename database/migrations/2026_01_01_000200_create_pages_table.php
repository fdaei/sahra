<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Editable pages: home, about, contact, privacy-policy, terms.
 *
 * Listing pages (work, insights, services) are driven by their own entities,
 * but still get a Page row so their heading/intro/SEO are editable — the audit
 * shows real copy in those headers (e.g. "Where Strategy Becomes Visible").
 *
 * `key` is a stable identifier the controllers resolve by, so renaming a page
 * in admin never breaks a route.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 50)->unique()->comment('home|about|contact|work|insights|services|privacy-policy|terms');

            $table->string('status', 20)->default(PublicationStatus::Published->value);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });

        Schema::create('page_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('page_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('title', 200);
            $table->string('subtitle', 300)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable()->comment('Rich text — legal pages');

            // SEO
            $table->string('seo_title', 200)->nullable();
            $table->string('seo_description', 300)->nullable();

            $table->timestamps();

            $table->unique(['page_id', 'locale'], 'page_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
};
