<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->string('home_orbit_group', 20)->nullable()->after('show_on_home');
            $table->string('external_url', 500)->nullable()->after('home_orbit_group');
            $table->boolean('show_on_services_page')->default(true)->after('show_on_home');
            $table->index(['show_on_home', 'home_orbit_group'], 'services_home_orbit_index');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropIndex('services_home_orbit_index');
            $table->dropColumn(['home_orbit_group', 'external_url', 'show_on_services_page']);
        });
    }
};
