<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Enums\PublicationStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

/**
 * Draft / Scheduled / Published controls, shared by every publishable
 * resource so the workflow is identical everywhere.
 */
final class PublicationFields
{
    public static function section(): Section
    {
        return Section::make('Publication')
            ->icon('heroicon-o-clock')
            ->columns(2)
            ->schema([
                Select::make('status')
                    ->options(PublicationStatus::options())
                    ->default(PublicationStatus::Draft->value)
                    ->required()
                    ->live()
                    ->native(false)
                    ->helperText('Scheduled items publish automatically once their date passes.'),

                DateTimePicker::make('published_at')
                    ->label(fn (Get $get): string => $get('status') === PublicationStatus::Scheduled->value
                        ? 'Publish at'
                        : 'Published at')
                    ->seconds(false)
                    ->native(false)
                    ->required(fn (Get $get): bool => $get('status') === PublicationStatus::Scheduled->value)
                    ->minDate(fn (Get $get) => $get('status') === PublicationStatus::Scheduled->value
                        ? now()
                        : null)
                    ->default(now()),
            ]);
    }
}
