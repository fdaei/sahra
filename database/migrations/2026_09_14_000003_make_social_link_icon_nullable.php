<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_links', fn (Blueprint $table) => $table->string('icon', 255)->nullable()->change());
    }

    public function down(): void
    {
        DB::table('social_links')->whereNull('icon')->update(['icon' => '']);

        Schema::table('social_links', fn (Blueprint $table) => $table->string('icon', 255)->change());
    }
};
