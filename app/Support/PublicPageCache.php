<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\ContactSubmission;
use App\Models\LeadMagnetDelivery;
use App\Models\NewsletterSubscription;
use App\Models\NotFoundVisit;
use App\Models\User;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

final class PublicPageCache
{
    private const REVISION = 'public-pages.revision';

    public static function store(): Repository
    {
        return Cache::store(config('cache.public_page_store'));
    }

    public static function revision(): string
    {
        return self::store()->get(self::REVISION, 'initial');
    }

    public static function invalidate(): void
    {
        self::store()->forever(self::REVISION, (string) Str::uuid());
    }

    public static function registerInvalidation(): void
    {
        Event::listen(
            ['eloquent.saved: App\\Models\\*', 'eloquent.deleted: App\\Models\\*', 'eloquent.restored: App\\Models\\*'],
            static function (string $event, array $payload): void {
                $model = $payload[0] ?? null;
                if (! config('cache.public_pages') || ! $model instanceof Model
                    || $model instanceof ContactSubmission || $model instanceof LeadMagnetDelivery
                    || $model instanceof NewsletterSubscription || $model instanceof NotFoundVisit || $model instanceof User) {
                    return;
                }

                $connection = $model->getConnection();
                if ($connection->transactionLevel() > 0) {
                    $connection->afterCommit(self::invalidate(...));
                } else {
                    self::invalidate();
                }
            },
        );

        // Bulk admin edits and pivot syncs can bypass model events.
        Event::listen(RequestHandled::class, static function (RequestHandled $event): void {
            $request = $event->request;
            if (config('cache.public_pages') && ! $request->isMethodSafe() && $request->is('admin', 'admin/*', 'livewire/*')
                && $event->response->getStatusCode() < 500) {
                self::invalidate();
            }
        });
    }
}
