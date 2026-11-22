<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

final class AdvancedRobotsFields
{
    public static function section(string $locale): Section
    {
        return Section::make('Search preview controls')->collapsed()->schema([
            Toggle::make("translations.{$locale}.seo_nosnippet")
                ->label('Do not show text or video snippets')
                ->helperText('Adds nosnippet. Image thumbnails may still appear.')->default(false),
            Toggle::make("translations.{$locale}.seo_noimageindex")
                ->label('Ask search engines not to index images on this page')
                ->helperText('Adds noimageindex; it does not hide the page itself.')->default(false),
            Select::make("translations.{$locale}.seo_max_image_preview")
                ->label('Maximum image preview size')
                ->options(['none' => __('No preview'), 'standard' => __('Standard'), 'large' => __('Large')])
                ->in(['none', 'standard', 'large'])->nullable()
                ->helperText('Leave empty to use the site default.'),
            TextInput::make("translations.{$locale}.seo_max_snippet")
                ->label('Maximum snippet length')
                ->numeric()->integer()->minValue(-1)->maxValue(2147483647)
                ->helperText('Maximum characters. Leave empty for no explicit limit; -1 means unlimited. Ignored when nosnippet is enabled.'),
            TextInput::make("translations.{$locale}.seo_max_video_preview")
                ->label('Maximum video preview length')
                ->numeric()->integer()->minValue(-1)->maxValue(2147483647)
                ->helperText('Maximum seconds. Leave empty for no explicit limit; -1 means unlimited. Ignored when nosnippet is enabled.'),
        ]);
    }
}
