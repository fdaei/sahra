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
            $table->string('eyebrow_color', 9)->nullable()->after('image_path');
            $table->string('title_color', 9)->nullable()->after('eyebrow_color');
            $table->string('subtitle_color', 9)->nullable()->after('title_color');
            $table->string('description_color', 9)->nullable()->after('subtitle_color');
            $table->string('content_color', 9)->nullable()->after('description_color');
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table): void {
            $table->dropColumn([
                'eyebrow_color',
                'title_color',
                'subtitle_color',
                'description_color',
                'content_color',
            ]);
        });
    }
};
