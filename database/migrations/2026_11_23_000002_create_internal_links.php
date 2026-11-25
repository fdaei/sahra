<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('internal_links')) {
            Schema::create('internal_links', function (Blueprint $table): void {
                $table->id();
                $table->string('locale', 5)->index();
                $table->string('keyword', 190);
                $table->string('url', 500);
                $table->unsignedTinyInteger('max_per_page')->default(1);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->unique(['locale', 'keyword']);
            });
        }
        foreach (['id', 'locale', 'keyword', 'url', 'max_per_page', 'is_active', 'created_at', 'updated_at'] as $column) {
            if (! Schema::hasColumn('internal_links', $column)) {
                throw new RuntimeException('Existing internal_links table is incompatible: missing '.$column);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_links');
    }
};
