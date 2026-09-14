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
        Schema::table('services', function (Blueprint $table): void {
            $table->boolean('show_on_work_page')
                ->default(true)
                ->after('show_on_services_page');

            $table->index('show_on_work_page');
        });

        // Capability-map-only services should not become Work filters by
        // default when this migration is applied to an existing database.
        DB::table('services')
            ->where('show_on_services_page', false)
            ->whereNotNull('home_orbit_group')
            ->update(['show_on_work_page' => false]);
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropIndex(['show_on_work_page']);
            $table->dropColumn('show_on_work_page');
        });
    }
};
