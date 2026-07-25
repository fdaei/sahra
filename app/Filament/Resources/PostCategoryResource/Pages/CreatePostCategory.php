<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostCategoryResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostCategoryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePostCategory extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = PostCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
