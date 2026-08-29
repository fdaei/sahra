<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table): void {
            $table->string('primary_cta_icon', 50)->nullable()->after('image_path');
            $table->string('secondary_cta_icon', 50)->nullable()->after('primary_cta_icon');
        });

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->string('icon', 50)->nullable()->after('target');
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->string('lead_magnet_cta_icon', 50)->nullable()->after('lead_magnet_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', fn (Blueprint $table) => $table->dropColumn(['primary_cta_icon', 'secondary_cta_icon']));
        Schema::table('menu_items', fn (Blueprint $table) => $table->dropColumn('icon'));
        Schema::table('posts', fn (Blueprint $table) => $table->dropColumn('lead_magnet_cta_icon'));
    }
};
