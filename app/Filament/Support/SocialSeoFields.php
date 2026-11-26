<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

final class SocialSeoFields
{
    public static function section(string $locale): Section
    {
        return Section::make('Social sharing')
            ->description('Leave these fields empty to use the SEO title, description and default image.')
            ->collapsed()
            ->schema([
                TextInput::make("translations.{$locale}.seo_social_title")
                    ->label('Social title')->maxLength(200),
                Textarea::make("translations.{$locale}.seo_social_description")
                    ->label('Social description')->rows(2)->maxLength(300),
                ImageUpload::make("translations.{$locale}.seo_social_image", 'Social share image', 'seo/social'),
                TextInput::make("translations.{$locale}.seo_social_image_alt")
                    ->label('Social image alternative text')->maxLength(300)
                    ->helperText('Describe the selected share image. If empty, its media-library description or the image fallback is used.'),
                Section::make('X / Twitter overrides')
                    ->description('Leave blank to use the social sharing values above.')
                    ->collapsed()->schema([
                        TextInput::make("translations.{$locale}.seo_twitter_title")
                            ->label('X / Twitter title')->maxLength(200),
                        Textarea::make("translations.{$locale}.seo_twitter_description")
                            ->label('X / Twitter description')->rows(2)->maxLength(300),
                        ImageUpload::make("translations.{$locale}.seo_twitter_image", 'X / Twitter image', 'seo/twitter'),
                        TextInput::make("translations.{$locale}.seo_twitter_image_alt")
                            ->label('X / Twitter image alternative text')->maxLength(300),
                        Select::make("translations.{$locale}.seo_twitter_card")
                            ->label('X / Twitter card type')
                            ->options(['summary' => __('Summary'), 'summary_large_image' => __('Summary with large image')])
                            ->in(['summary', 'summary_large_image'])->nullable()
                            ->helperText('Leave empty for automatic selection. A large image card requires an image.'),
                    ]),
            ]);
    }
}
