<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('redirects', 'match_type')) {
            Schema::table('redirects', fn (Blueprint $table) => $table->string('match_type', 10)->default('exact'));
        }
        if (! Schema::hasColumn('redirects', 'notes')) {
            Schema::table('redirects', fn (Blueprint $table) => $table->string('notes', 500)->nullable());
        }
        if (! Schema::hasColumn('redirects', 'origin')) {
            Schema::table('redirects', fn (Blueprint $table) => $table->string('origin', 20)->default('manual'));
        }
        DB::table('redirects')->whereNull('match_type')->update(['match_type' => 'exact']);
        DB::table('redirects')->whereNull('origin')->update(['origin' => 'manual']);
        Schema::table('redirects', fn (Blueprint $table) => $table->string('destination_path', 500)->nullable()->change());
    }

    public function down(): void
    {
        Schema::table('redirects', fn (Blueprint $table) => $table->dropColumn(['match_type', 'notes', 'origin']));
    }
};
