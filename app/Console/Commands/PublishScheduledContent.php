<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\PublicationStatus;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Promotes Scheduled records whose publish time has passed.
 *
 * Scheduled every five minutes (routes/console.php). The public `published()`
 * scope also checks published_at <= now(), so a missed run delays a post but
 * can never leak future content.
 */
final class PublishScheduledContent extends Command
{
    protected $signature = 'sahra:publish-scheduled';

    protected $description = 'Publish scheduled pages, projects, services and posts whose time has come';

    public function handle(): int
    {
        $total = 0;

        foreach ([Page::class, Project::class, Service::class, Post::class] as $model) {
            $due = $model::query()->duePublication()->get();

            if ($due->isEmpty()) {
                continue;
            }

            DB::transaction(function () use ($due, &$total): void {
                foreach ($due as $record) {
                    $record->update(['status' => PublicationStatus::Published]);
                    $total++;
                }
            });

            $this->info(class_basename($model).': published '.$due->count());
        }

        if ($total === 0) {
            $this->line('Nothing due.');
        }

        return self::SUCCESS;
    }
}
