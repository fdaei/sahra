<?php

declare(strict_types=1);
use App\Enums\PublicationStatus;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

// Development only. Never accepts the application's database or an existing file.
$database = $argv[1] ?? '';
if (PHP_SAPI !== 'cli' || ! preg_match('~^/tmp/sdk-seo-[a-zA-Z0-9-]+\.sqlite$~', $database) || file_exists($database)) {
    fwrite(STDERR, "Usage: php scripts/create-seo-fixture.php /tmp/sdk-seo-UNIQUE.sqlite (new file only)\n");
    exit(1);
}
foreach (['APP_ENV' => 'testing', 'APP_DEBUG' => 'false', 'APP_URL' => 'http://127.0.0.1:8765', 'SEO_CANONICAL_ORIGIN' => '', 'APP_LOCALE' => 'en', 'DB_URL' => '', 'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $database, 'CACHE_STORE' => 'array', 'SESSION_DRIVER' => 'file', 'QUEUE_CONNECTION' => 'sync', 'MAIL_MAILER' => 'array'] as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $_SERVER[$key] = $value;
}
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== $database) {
    throw new RuntimeException('Refusing to migrate: fixture database configuration was overridden.');
}
touch($database);
Artisan::call('migrate', ['--force' => true]);
foreach (['TaxonomySeeder', 'ServiceSeeder', 'PageSeeder', 'ProjectSeeder', 'PostSeeder', 'SiteSettingsSeeder', 'ContentSeeder'] as $seeder) {
    $class = 'Database\\Seeders\\'.$seeder;
    (new $class)->run();
}
$post = Post::query()->published()->firstOrFail();
$post->setTranslations(['en' => ['slug' => 'seo-visible', 'title' => 'SEO visible article', 'content' => '<h2>Real article heading</h2><p>Complete body served by PHP.</p><p>Final article paragraph for SEO verification.</p>'], 'fa' => ['slug' => 'seo-farsi', 'title' => 'مقاله آزمایشی', 'content' => '<p>متن کامل مقاله فارسی</p>']]);
$draft = Post::create(['status' => PublicationStatus::Draft]);
$draft->setTranslations(['en' => ['slug' => 'seo-draft', 'title' => 'Secret unpublished SEO article', 'content' => '<p>Secret unpublished body</p>']]);
echo "Created isolated SEO fixture: {$database}\n";
