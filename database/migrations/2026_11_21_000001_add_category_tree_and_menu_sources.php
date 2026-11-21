<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Category tree: a category may sit under another one. Deleting a parent
 * lifts its children to the top level rather than deleting them.
 *
 * menu_items.children_source lets a menu item (e.g. header "Insights") build
 * its dropdown from the category tree instead of hand-made child items.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_categories', function (Blueprint $table): void {
            $table->foreignId('parent_id')->nullable()->after('id')
                ->constrained('post_categories')->nullOnDelete();
        });

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->string('children_source', 40)->nullable()->after('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', fn (Blueprint $table) => $table->dropColumn('children_source'));
        Schema::table('post_categories', fn (Blueprint $table) => $table->dropConstrainedForeignId('parent_id'));
    }
};
