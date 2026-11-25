<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('not_found_visits', 'is_bot')) {
            Schema::table('not_found_visits', fn (Blueprint $table) => $table->boolean('is_bot')->default(false));
        }
        if (! Schema::hasColumn('not_found_visits', 'referrer_host')) {
            Schema::table('not_found_visits', fn (Blueprint $table) => $table->string('referrer_host', 253)->nullable());
        }
    }

    public function down(): void
    {
        Schema::table('not_found_visits', fn (Blueprint $table) => $table->dropColumn(['is_bot', 'referrer_host']));
    }
};
