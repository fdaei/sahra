<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Publishes posts and projects whose scheduled publish_at has passed.
| Run via: php artisan schedule:work  (local)  /  cron (production)
|
| The sitemap has no equivalent entry here — SitemapController builds it from
| the database on every request (see routes/web.php), so there's nothing to
| pre-generate.
*/
Schedule::command('sahra:publish-scheduled')->everyFiveMinutes();
