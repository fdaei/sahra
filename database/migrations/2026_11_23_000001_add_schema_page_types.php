<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['pages', 'posts', 'projects'] as $table) {
            if (! Schema::hasColumn($table, 'seo_page_schema_type')) {
                Schema::table($table, fn (Blueprint $blueprint) => $blueprint->string('seo_page_schema_type', 50)->nullable());
            }
        }
        Schema::table('posts', fn (Blueprint $table) => $table->string('seo_schema_type', 50)->nullable()->change());
        foreach (['post_translations', 'page_translations'] as $translations) {
            foreach (['schema_faq_items', 'schema_howto_steps'] as $column) {
                if (! Schema::hasColumn($translations, $column)) {
                    Schema::table($translations, fn (Blueprint $table) => $table->json($column)->nullable());
                }
            }
            if (! Schema::hasColumn($translations, 'schema_howto_title')) {
                Schema::table($translations, fn (Blueprint $table) => $table->string('schema_howto_title', 200)->nullable());
            }
        }
    }

    public function down(): void
    {
        // Existing extended article values may not fit the former 20-character column.
        foreach (['pages', 'posts', 'projects'] as $table) {
            Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropColumn('seo_page_schema_type'));
        }
        foreach (['post_translations', 'page_translations'] as $translations) {
            Schema::table($translations, fn (Blueprint $table) => $table->dropColumn(['schema_faq_items', 'schema_howto_title', 'schema_howto_steps']));
        }
    }
};
