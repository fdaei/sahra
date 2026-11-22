<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Models\Page;
use App\Services\Seo\PostSeoAnalysis;
use App\Support\CanonicalUrl;
use App\Support\SeoCanonical;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;

final class ContentSeoFields
{
    /** @param 'page'|'project' $type @return array<int, \Filament\Forms\Components\Component> */
    public static function make(string $locale, string $type): array
    {
        return [
            TextInput::make("translations.{$locale}.seo_focus_keyphrase")
                ->label('Focus keyphrase')->maxLength(200)->live(onBlur: true)
                ->helperText('Used only for editorial checks; it is not published as a meta keywords tag.'),
            Placeholder::make("seo_analysis_{$locale}")
                ->label('SEO checks')
                ->content(function (Get $get) use ($locale, $type): HtmlString {
                    $translation = $get("translations.{$locale}");
                    $translation = is_array($translation) ? $translation : [];
                    if ($type === 'page') {
                        $translation['excerpt'] = $translation['description'] ?? '';
                        $url = SeoCanonical::defaultUrl(new Page(['key' => (string) $get('key')]), $locale) ?? '';
                    } else {
                        $slug = trim((string) ($translation['slug'] ?? ''));
                        $url = $slug === '' ? '' : CanonicalUrl::route('work.show', ['locale' => $locale, 'project' => $slug]);
                    }
                    $analysis = app(PostSeoAnalysis::class);
                    $checks = $analysis->analyze($translation, null, false);
                    $preview = $analysis->preview($translation, $locale, $url);
                    return new HtmlString(view('filament.components.post-seo-analysis', compact('checks', 'preview'))->render());
                }),
        ];
    }
}
