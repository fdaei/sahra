<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['page_translations', 'post_translations', 'project_translations'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->boolean('seo_noindex')->default(false);
                $table->boolean('seo_nofollow')->default(false);
            });
        }
    }

    public function down(): void
    {
        foreach (['page_translations', 'post_translations', 'project_translations'] as $table) {
            Schema::table($table, fn (Blueprint $table) => $table->dropColumn(['seo_noindex', 'seo_nofollow']));
        }
    }
};
