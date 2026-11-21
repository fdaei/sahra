<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Media library: every image, video, audio file and document on the public
 * disk, with per-locale SEO metadata (title, alt, caption, description) and
 * a schema.org type for JSON-LD.
 *
 * Also adds the alt texts project images were missing (banner, before,
 * after) and grants the new `media` permissions to the existing roles, so
 * production does not need the seeder re-run.
 */
return new class extends Migration
{
    private const ACTIONS = ['view_any', 'view', 'create', 'update', 'update_any', 'delete', 'delete_any', 'restore'];

    public function up(): void
    {
        Schema::create('media', function (Blueprint $table): void {
            $table->id();
            $table->string('path', 500)->unique();
            $table->string('name');
            $table->string('mime', 100);
            $table->string('type', 20)->index(); // image | video | audio | document
            $table->unsignedBigInteger('size')->default(0);
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('duration')->nullable(); // seconds, for video/audio
            $table->string('poster_path', 500)->nullable();  // video thumbnail
            $table->string('schema_type', 40)->nullable();   // null = derived from type
            $table->string('credit')->nullable();             // author / copyright holder
            $table->boolean('schema_enabled')->default(true);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('media_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title', 300)->nullable();      // SEO title / schema name
            $table->string('alt', 300)->nullable();
            $table->string('caption', 500)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['media_id', 'locale']);
        });

        Schema::table('project_translations', function (Blueprint $table): void {
            $table->string('banner_alt', 300)->nullable()->after('cover_alt');
            $table->string('before_alt', 300)->nullable()->after('banner_alt');
            $table->string('after_alt', 300)->nullable()->after('before_alt');
        });

        $this->grantPermissions();
    }

    public function down(): void
    {
        Schema::table('project_translations', function (Blueprint $table): void {
            $table->dropColumn(['banner_alt', 'before_alt', 'after_alt']);
        });
        Schema::dropIfExists('media_translations');
        Schema::dropIfExists('media');
    }

    private function grantPermissions(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('roles')) {
            return;
        }

        $now = now();
        foreach (self::ACTIONS as $action) {
            DB::table('permissions')->insertOrIgnore(['name' => "{$action}_media", 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now]);
        }

        $permissionIds = DB::table('permissions')->where('name', 'like', '%\_media')->pluck('id', 'name');
        foreach (['admin', 'editor'] as $roleName) {
            $roleId = DB::table('roles')->where('name', $roleName)->where('guard_name', 'web')->value('id');
            if ($roleId === null) {
                continue;
            }
            foreach ($permissionIds as $name => $permissionId) {
                if ($roleName === 'editor' && $name === 'delete_any_media') {
                    continue; // editors never get bulk deletion
                }
                DB::table('role_has_permissions')->insertOrIgnore(['permission_id' => $permissionId, 'role_id' => $roleId]);
            }
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
