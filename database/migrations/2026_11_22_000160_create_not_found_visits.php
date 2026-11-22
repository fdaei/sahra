<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('not_found_visits', function (Blueprint $table): void {
            $table->id();
            $table->string('path_hash', 64)->unique();
            $table->string('path', 500);
            $table->unsignedBigInteger('hits')->default(1);
            $table->timestamp('first_seen_at');
            $table->timestamp('last_seen_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('not_found_visits');
    }
};
