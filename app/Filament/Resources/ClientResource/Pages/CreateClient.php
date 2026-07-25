<?php

declare(strict_types=1);

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\ClientResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateClient extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = ClientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
