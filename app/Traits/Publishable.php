<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Draft / Scheduled / Published lifecycle.
 *
 * A row is publicly visible only when status = published AND published_at is
 * in the past. Scheduled rows are promoted by `sahra:publish-scheduled`
 * (routes/console.php), but the `published()` scope also checks the timestamp
 * so a missed cron run can never leak future content.
 *
 * Requires the consuming table to have `status` (string) and `published_at`
 * (nullable timestamp), plus the composite index declared in its migration.
 */
trait Publishable
{
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', PublicationStatus::Published)
            ->where(function (Builder $q): void {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', PublicationStatus::Draft);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query
            ->where('status', PublicationStatus::Scheduled)
            ->whereNotNull('published_at')
            ->where('published_at', '>', now());
    }

    /**
     * Scheduled rows whose time has come — used by the publish command.
     */
    public function scopeDuePublication(Builder $query): Builder
    {
        return $query
            ->where('status', PublicationStatus::Scheduled)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        if ($this->status !== PublicationStatus::Published) {
            return false;
        }

        return $this->published_at === null || $this->published_at->isPast();
    }

    public function isScheduled(): bool
    {
        return $this->status === PublicationStatus::Scheduled
            && $this->published_at !== null
            && $this->published_at->isFuture();
    }

    public function publish(?Carbon $at = null): bool
    {
        $at ??= now();

        $this->status = $at->isFuture()
            ? PublicationStatus::Scheduled
            : PublicationStatus::Published;

        $this->published_at = $at;

        return $this->save();
    }

    public function unpublish(): bool
    {
        $this->status = PublicationStatus::Draft;

        return $this->save();
    }
}
