<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('lead_magnet_file_path', 500)->nullable()->after('cover_path');
            $table->string('lead_magnet_image_path', 500)->nullable()->after('lead_magnet_file_path');
        });

        Schema::table('post_translations', function (Blueprint $table): void {
            $table->string('lead_magnet_title', 250)->nullable()->after('content');
            $table->text('lead_magnet_description')->nullable()->after('lead_magnet_title');
            $table->string('lead_magnet_cta_label', 100)->nullable()->after('lead_magnet_description');
            $table->string('lead_magnet_image_alt', 300)->nullable()->after('lead_magnet_cta_label');
        });

        Schema::table('newsletter_subscriptions', function (Blueprint $table): void {
            $table->string('name', 120)->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_subscriptions', function (Blueprint $table): void {
            $table->dropColumn('name');
        });

        Schema::table('post_translations', function (Blueprint $table): void {
            $table->dropColumn([
                'lead_magnet_title',
                'lead_magnet_description',
                'lead_magnet_cta_label',
                'lead_magnet_image_alt',
            ]);
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn(['lead_magnet_file_path', 'lead_magnet_image_path']);
        });
    }
};
