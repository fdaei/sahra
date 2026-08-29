<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_links', fn (Blueprint $table) => $table->string('icon', 255)->change());
        Schema::table('section_items', fn (Blueprint $table) => $table->string('icon', 255)->nullable()->change());
        Schema::table('services', fn (Blueprint $table) => $table->string('icon', 255)->nullable()->change());
        Schema::table('page_sections', function (Blueprint $table): void {
            $table->string('primary_cta_icon', 255)->nullable()->change();
            $table->string('secondary_cta_icon', 255)->nullable()->change();
        });
        Schema::table('menu_items', fn (Blueprint $table) => $table->string('icon', 255)->nullable()->change());
        Schema::table('posts', fn (Blueprint $table) => $table->string('lead_magnet_cta_icon', 255)->nullable()->change());
    }

    public function down(): void
    {
        Schema::table('social_links', fn (Blueprint $table) => $table->string('icon', 50)->change());
        Schema::table('section_items', fn (Blueprint $table) => $table->string('icon', 50)->nullable()->change());
        Schema::table('services', fn (Blueprint $table) => $table->string('icon', 50)->nullable()->change());
        Schema::table('page_sections', function (Blueprint $table): void {
            $table->string('primary_cta_icon', 50)->nullable()->change();
            $table->string('secondary_cta_icon', 50)->nullable()->change();
        });
        Schema::table('menu_items', fn (Blueprint $table) => $table->string('icon', 50)->nullable()->change());
        Schema::table('posts', fn (Blueprint $table) => $table->string('lead_magnet_cta_icon', 50)->nullable()->change());
    }
};
