<?php

declare(strict_types=1);

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\TestimonialResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTestimonial extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = TestimonialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
