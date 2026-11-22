<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_translations', fn (Blueprint $table) => $table->string('seo_focus_keyphrase', 200)->nullable());
    }

    public function down(): void
    {
        Schema::table('post_translations', fn (Blueprint $table) => $table->dropColumn('seo_focus_keyphrase'));
    }
};
