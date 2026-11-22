<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\CanonicalUrl;
use App\Support\SeoCanonical;
use App\Support\SeoVisibility;
use App\Support\SiteSettings;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PostFeedController extends Controller
{
    public function __invoke(string $locale): Response
    {
        if (! array_key_exists($locale, config('locales.supported'))) {
            throw new NotFoundHttpException;
        }
        app()->setLocale($locale);
        $items = [];
        $posts = Post::query()->published()->hasTranslatedValue('slug', $locale)
            ->with('translations')->orderByRaw('COALESCE(published_at, created_at) DESC')->orderByDesc('id')->lazy(100);
        foreach ($posts as $post) {
            if (SeoVisibility::noindex($post, $locale) || ! SeoCanonical::isSelfCanonical($post, $locale)) {
                continue;
            }
            $excerpt = (string) ($post->getTranslation('excerpt', $locale, false) ?: $post->getTranslation('content', $locale, false));
            $items[] = [
                'title' => self::text((string) $post->getTranslation('title', $locale, false)),
                'link' => CanonicalUrl::for($post->url($locale)),
                'description' => Str::limit(self::text($excerpt), 500),
                'guid' => 'urn:sha256:'.hash('sha256', CanonicalUrl::origin().'|post|'.$post->getKey().'|'.$locale),
                'published' => ($post->published_at ?? $post->created_at)?->toRfc2822String(),
            ];
            if (count($items) === 50) {
                break;
            }
        }
        $siteName = self::text((string) SiteSettings::get('site_name', $locale, 'Sahra')) ?: 'Sahra';
        $description = self::text((string) SiteSettings::get('seo_default_description', $locale, '')) ?: $siteName;
        $xml = view('feeds.posts', [
            'siteName' => $siteName,
            'description' => $description,
            'home' => CanonicalUrl::route('insights.index', ['locale' => $locale]),
            'feed' => CanonicalUrl::route('feed.locale', ['locale' => $locale]),
            'language' => config("locales.supported.{$locale}.html_lang"),
            'items' => $items,
        ])->render();
        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8']);
    }

    private static function text(string $value): string
    {
        $value = preg_replace('~<(script|style)\\b[^>]*>.*?</\\1>~is', ' ', $value) ?? $value;
        $value = preg_replace('~</(?:p|div|h[1-6]|li|blockquote)>|<br\\s*/?>~i', ' ', $value) ?? $value;
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = str_ireplace('[[lead_magnet]]', '', $value);
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        $value = preg_replace('/[^\\x{9}\\x{A}\\x{D}\\x{20}-\\x{D7FF}\\x{E000}-\\x{FFFD}\\x{10000}-\\x{10FFFF}]/u', '', $value) ?? '';
        return trim(preg_replace('/\\s+/u', ' ', $value) ?? $value);
    }
}
