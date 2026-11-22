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
            Schema::table($table, fn (Blueprint $table) => $table->string('seo_social_image_alt', 300)->nullable());
        }
    }

    public function down(): void
    {
        foreach (['page_translations', 'post_translations', 'project_translations'] as $table) {
            Schema::table($table, fn (Blueprint $table) => $table->dropColumn('seo_social_image_alt'));
        }
    }
};
