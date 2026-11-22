<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', fn (Blueprint $table) => $table->string('seo_schema_type', 20)->default('Article'));
    }

    public function down(): void
    {
        Schema::table('posts', fn (Blueprint $table) => $table->dropColumn('seo_schema_type'));
    }
};
