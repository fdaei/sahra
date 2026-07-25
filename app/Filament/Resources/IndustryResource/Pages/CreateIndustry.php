<?php

declare(strict_types=1);

namespace App\Filament\Resources\IndustryResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\IndustryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateIndustry extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = IndustryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
