<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Package cards need a little more structure than the generic title/value/body
 * used by process and KPI cards. Keeping these fields on SectionItem preserves
 * the existing section editor while making every visible package detail
 * translatable and manageable from Filament.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('section_item_translations', function (Blueprint $table): void {
            $table->string('label', 100)->nullable()->after('value');
            $table->string('suffix', 100)->nullable()->after('label');
            $table->string('badge', 100)->nullable()->after('description');
            $table->json('features')->nullable()->after('badge');
            $table->string('footer', 200)->nullable()->after('features');
        });
    }

    public function down(): void
    {
        Schema::table('section_item_translations', function (Blueprint $table): void {
            $table->dropColumn(['label', 'suffix', 'badge', 'features', 'footer']);
        });
    }
};
