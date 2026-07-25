<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->string('location', 20)->unique()->comment('App\Enums\MenuLocation');
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('menu_id')
                ->constrained()
                ->cascadeOnDelete();

            // Self-referencing: footer column headings are parents of their links.
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menu_items')
                ->cascadeOnDelete();

            // Either a named route (locale-aware) or an external/absolute URL.
            $table->string('route_name', 100)->nullable();
            $table->json('route_params')->nullable();
            $table->string('url', 500)->nullable();

            $table->string('target', 10)->default('_self');
            $table->boolean('is_cta')->default(false)->comment("Renders as the header's Let's Talk button");
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['menu_id', 'parent_id', 'sort_order'], 'menu_items_tree_index');
            $table->index(['is_active']);
        });

        Schema::create('menu_item_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('menu_item_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('locale', 5);
            $table->string('label', 150);
            $table->timestamps();

            $table->unique(['menu_item_id', 'locale'], 'menu_item_translations_unique');
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_item_translations');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
