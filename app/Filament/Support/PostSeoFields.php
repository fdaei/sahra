<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Services\Seo\PostSeoAnalysis;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;

final class PostSeoFields
{
    /** @return array<int, \Filament\Forms\Components\Component> */
    public static function make(string $locale): array
    {
        return [
            TextInput::make("translations.{$locale}.seo_focus_keyphrase")
                ->label('Focus keyphrase')->maxLength(200)->live(onBlur: true)
                ->helperText('Used only for editorial checks; it is not published as a meta keywords tag.'),
            Placeholder::make("seo_analysis_{$locale}")
                ->label('SEO checks')
                ->content(function (Get $get) use ($locale): HtmlString {
                    $translation = $get("translations.{$locale}");
                    $translation = is_array($translation) ? $translation : [];
                    $analysis = app(PostSeoAnalysis::class);
                    $checks = $analysis->analyze($translation, filled($get('cover_path')));
                    $preview = $analysis->preview($translation, $locale);
                    return new HtmlString(view('filament.components.post-seo-analysis', compact('checks', 'preview'))->render());
                }),
        ];
    }
}
