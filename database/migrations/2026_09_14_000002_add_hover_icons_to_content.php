<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_links', function (Blueprint $table): void {
            $table->string('hover_icon', 255)->nullable()->after('icon');
        });

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->string('hover_icon', 255)->nullable()->after('icon');
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->string('hover_icon', 255)->nullable()->after('icon');
        });

        Schema::table('section_items', function (Blueprint $table): void {
            $table->string('hover_icon', 255)->nullable()->after('icon');
        });

        Schema::table('page_sections', function (Blueprint $table): void {
            $table->string('primary_cta_hover_icon', 255)->nullable()->after('primary_cta_icon');
            $table->string('secondary_cta_hover_icon', 255)->nullable()->after('secondary_cta_icon');
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->string('lead_magnet_cta_hover_icon', 255)
                ->nullable()
                ->after('lead_magnet_cta_icon');
        });
    }

    public function down(): void
    {
        Schema::table('social_links', fn (Blueprint $table) => $table->dropColumn('hover_icon'));
        Schema::table('menu_items', fn (Blueprint $table) => $table->dropColumn('hover_icon'));
        Schema::table('services', fn (Blueprint $table) => $table->dropColumn('hover_icon'));
        Schema::table('section_items', fn (Blueprint $table) => $table->dropColumn('hover_icon'));
        Schema::table('page_sections', fn (Blueprint $table) => $table->dropColumn([
            'primary_cta_hover_icon',
            'secondary_cta_hover_icon',
        ]));
        Schema::table('posts', fn (Blueprint $table) => $table->dropColumn('lead_magnet_cta_hover_icon'));
    }
};
