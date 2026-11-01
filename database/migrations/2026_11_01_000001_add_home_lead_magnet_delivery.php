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
            $table->string('lead_magnet_file_path', 500)->nullable()->after('image_path');
            $table->boolean('lead_magnet_allow_download')->default(true)->after('lead_magnet_file_path');
            $table->boolean('lead_magnet_send_email')->default(false)->after('lead_magnet_allow_download');
        });

        Schema::table('lead_magnet_deliveries', function (Blueprint $table): void {
            $table->foreignId('post_id')->nullable()->change();
            $table->foreignId('page_section_id')->nullable()->after('post_id')->constrained()->cascadeOnDelete();
            $table->index(['page_section_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('lead_magnet_deliveries', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('page_section_id');
            $table->foreignId('post_id')->nullable(false)->change();
        });

        Schema::table('page_sections', function (Blueprint $table): void {
            $table->dropColumn([
                'lead_magnet_file_path',
                'lead_magnet_allow_download',
                'lead_magnet_send_email',
            ]);
        });
    }
};
