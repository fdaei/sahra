<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Services\ImagePreview;
use Illuminate\Console\Command;

final class GenerateImagePreviews extends Command
{
    protected $signature = 'sahra:generate-image-previews';

    protected $description = 'Build smaller WebP previews for client logos, project covers and service images';

    public function handle(): int
    {
        if (! function_exists('imagewebp')) {
            $this->warn('GD with WebP support is unavailable. The original images will be served.');

            return self::SUCCESS;
        }

        $logos = Client::query()->where('is_active', true)->whereNotNull('logo_path')->distinct()->pluck('logo_path');
        $cards = Project::query()->published()->whereNotNull('cover_path')->distinct()->pluck('cover_path')
            ->merge(Service::query()->published()->whereNotNull('image_path')->distinct()->pluck('image_path'))
            ->unique();

        $generated = $logos->filter(fn (string $path): bool => ImagePreview::generate($path, ImagePreview::LOGO_SIZE))->count()
            + $cards->filter(fn (string $path): bool => ImagePreview::generate($path, ImagePreview::CARD_SIZE))->count();

        $this->info("Generated {$generated} image previews.");

        return self::SUCCESS;
    }
}
