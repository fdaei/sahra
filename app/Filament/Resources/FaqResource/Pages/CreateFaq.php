<?php

declare(strict_types=1);

namespace App\Filament\Resources\FaqResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\FaqResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateFaq extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = FaqResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
