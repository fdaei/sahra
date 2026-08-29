<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;

final class SvgIconUpload
{
    public static function make(string $name, ?string $label = null): FileUpload
    {
        return FileUpload::make($name)
            ->label($label ?? 'SVG icon')
            ->disk('public')
            ->directory('icons')
            ->acceptedFileTypes(['image/svg+xml'])
            ->maxSize(256)
            ->downloadable()
            ->openable()
            ->helperText('Upload an SVG file (maximum 256 KB).');
    }
}
