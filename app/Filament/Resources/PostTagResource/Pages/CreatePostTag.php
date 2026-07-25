<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostTagResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostTagResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePostTag extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = PostTagResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
