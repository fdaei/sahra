<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Key/value site settings.
 *
 * Deliberately the ONE place where translations live in a JSON column rather
 * than a translation table. Rationale (permitted exception, documented per
 * spec item on JSON blobs):
 *   - settings are a heterogeneous key/value bag, not a uniform entity;
 *   - a `setting_translations` table would need a polymorphic value column
 *     anyway, giving no type safety over JSON;
 *   - the whole table is cached as one array (App\Support\SiteSettings), so
 *     there is no per-locale query to optimise.
 * Every real content entity uses proper translation tables.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('group')->default('general')->index();

            // Scalar for non-translatable values, {"en":…,"fa":…,"ar":…} otherwise.
            $table->json('value')->nullable();

            $table->boolean('is_translatable')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
