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
                $table->boolean('seo_nosnippet')->default(false);
                $table->boolean('seo_noimageindex')->default(false);
                $table->string('seo_max_image_preview', 10)->nullable();
                $table->integer('seo_max_snippet')->nullable();
                $table->integer('seo_max_video_preview')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['page_translations', 'post_translations', 'project_translations'] as $table) {
            Schema::table($table, fn (Blueprint $table) => $table->dropColumn([
                'seo_nosnippet', 'seo_noimageindex', 'seo_max_image_preview', 'seo_max_snippet', 'seo_max_video_preview',
            ]));
        }
    }
};
