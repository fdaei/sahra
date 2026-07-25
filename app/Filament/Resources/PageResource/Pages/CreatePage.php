<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePage extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = PageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
