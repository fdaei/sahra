<?php

declare(strict_types=1);

use App\Filament\Pages\ManageBackups;
use App\Models\User;
use App\Services\Backup\SqliteBackup;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

it('creates a consistent SQLite snapshot and includes both upload directories', function (): void {
    $dir = sys_get_temp_dir().'/sahra-test-'.bin2hex(random_bytes(8));
    mkdir($dir, 0700);
    mkdir($dir.'/public');
    mkdir($dir.'/private');
    file_put_contents($dir.'/public/image.txt', 'public file');
    file_put_contents($dir.'/private/document.txt', 'private file');
    touch($dir.'/source.sqlite');
    config(['database.connections.backup_test' => ['driver' => 'sqlite', 'database' => $dir.'/source.sqlite', 'prefix' => ''],
        'database.default' => 'backup_test', 'filesystems.disks.public.root' => $dir.'/public', 'filesystems.disks.local.root' => $dir.'/private']);
    DB::purge('backup_test');
    DB::statement('CREATE TABLE sample (content TEXT)');
    DB::insert('INSERT INTO sample (content) VALUES (?)', ['saved content']);
    $archive = null;
    try {
        $archive = app(SqliteBackup::class)->create();
        $zip = new ZipArchive;
        expect($zip->open($archive))->toBeTrue();
        expect($zip->getFromName('uploads/public/image.txt'))->toBe('public file')
            ->and($zip->getFromName('uploads/local/document.txt'))->toBe('private file');
        file_put_contents($dir.'/snapshot.sqlite', $zip->getFromName('database/database.sqlite'));
        $zip->close();
        $snapshot = new PDO('sqlite:'.$dir.'/snapshot.sqlite');
        expect($snapshot->query('SELECT content FROM sample')->fetchColumn())->toBe('saved content');
    } finally {
        DB::disconnect('backup_test');
        config(['database.default' => 'sqlite']);
        if ($archive !== null) unlink($archive);
        File::deleteDirectory($dir);
    }
});

it('rejects unsupported databases instead of producing an incomplete backup', function (): void {
    config(['database.default' => 'backup_memory', 'database.connections.backup_memory' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']]);
    try {
        expect(fn () => app(SqliteBackup::class)->create())->toThrow(RuntimeException::class);
    } finally {
        DB::disconnect('backup_memory');
        config(['database.default' => 'sqlite']);
    }
});

it('only allows administrators to access the backup page', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $editor = User::factory()->create()->assignRole('editor');
    $this->actingAs($editor)->get(ManageBackups::getUrl())->assertForbidden();
});

it('shows the backup page to administrators', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $this->actingAs($admin)->get(ManageBackups::getUrl())->assertOk();
});

it('adds security headers to public responses', function (): void {
    $this->get('/robots.txt')->assertOk()->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});


it('allows an administrator to download a generated backup from the panel', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $archive = tempnam(sys_get_temp_dir(), 'sahra-test-');
    file_put_contents($archive, 'backup contents');
    $this->mock(SqliteBackup::class)->shouldReceive('create')->once()->andReturn($archive);
    try {
        Livewire::actingAs($admin)->test(ManageBackups::class)->callAction('download')->assertFileDownloaded();
    } finally {
        if (is_file($archive)) unlink($archive);
    }
});
