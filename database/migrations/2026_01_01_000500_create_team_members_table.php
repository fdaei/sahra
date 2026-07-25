<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * About-page team grid. Figma: 908:1576 "Small Team, Big Standards",
 * member card component 992:2644. Ten members in the current design.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table): void {
            $table->id();

            $table->string('photo_path', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('team_member_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('name', 150);
            $table->string('role', 150);
            $table->string('photo_alt', 300)->nullable();
            $table->timestamps();

            $table->unique(['team_member_id', 'locale'], 'team_member_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_member_translations');
        Schema::dropIfExists('team_members');
    }
};
