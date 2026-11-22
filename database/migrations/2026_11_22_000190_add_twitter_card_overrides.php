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
                $table->string('seo_twitter_title', 200)->nullable();
                $table->string('seo_twitter_description', 300)->nullable();
                $table->string('seo_twitter_image', 500)->nullable();
                $table->string('seo_twitter_image_alt', 300)->nullable();
                $table->string('seo_twitter_card', 32)->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['page_translations', 'post_translations', 'project_translations'] as $table) {
            Schema::table($table, fn (Blueprint $table) => $table->dropColumn([
                'seo_twitter_title', 'seo_twitter_description', 'seo_twitter_image', 'seo_twitter_image_alt', 'seo_twitter_card',
            ]));
        }
    }
};
