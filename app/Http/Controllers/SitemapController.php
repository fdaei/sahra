<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Services\MediaTransformer;
use App\Support\CanonicalUrl;
use App\Support\SeoVisibility;
use App\Support\SeoCanonical;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * XML sitemaps.
 *
 * /sitemap.xml            index listing one child per locale
 * /sitemap-{locale}.xml   every public URL in that locale, with hreflang
 *                         alternates so search engines pair the translations
 */
final class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemaps = [];
        foreach (array_keys(config('locales.supported')) as $locale) {
            $sitemaps[] = ['url' => CanonicalUrl::route('sitemap.locale', ['locale' => $locale])];
            if (! $this->usesShards($locale)) {
                continue;
            }
            foreach (['post', 'project'] as $kind) {
                foreach ($this->shardNumbers($locale, $kind) as $shard) {
                    $sitemaps[] = ['url' => CanonicalUrl::route('sitemap.shard', compact('locale', 'kind', 'shard'))];
                }
            }
        }

        $xml = view('sitemap.index', [
            'sitemaps' => $sitemaps,
        ])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function locale(string $locale): Response
    {
        if (! array_key_exists($locale, config('locales.supported'))) {
            throw new NotFoundHttpException;
        }

        app()->setLocale($locale);

        $urls = [];
        $pages = Page::query()->published()->with('translations')->get()->keyBy('key');
        $keys = ['home' => 'home', 'work.index' => 'work', 'services' => 'services', 'about' => 'about', 'insights.index' => 'insights', 'contact' => 'contact', 'legal.privacy' => 'privacy-policy', 'legal.terms' => 'terms'];

        // Static routes
        foreach ([
            'home' => 1.0,
            'work.index' => 0.9,
            'services' => 0.9,
            'about' => 0.8,
            'insights.index' => 0.8,
            'contact' => 0.7,
            'legal.privacy' => 0.3,
            'legal.terms' => 0.3,
        ] as $name => $priority) {
            $page = $pages->get($keys[$name]);
            if ($page === null || SeoVisibility::noindex($page, $locale) || ! SeoCanonical::isSelfCanonical($page, $locale)) {
                continue;
            }
            $urls[] = [
                'loc' => CanonicalUrl::route($name, ['locale' => $locale]),
                'priority' => $priority,
                'changefreq' => 'weekly',
                'alternates' => $this->alternatesForRoute($name, $page),
            ];
        }

        if (! $this->usesShards($locale)) {
            foreach (['project', 'post'] as $kind) {
                array_push($urls, ...$this->contentUrls($locale, $kind));
            }
        }

        $xml = view('sitemap.locale', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function shard(string $locale, string $kind, string $shard): Response
    {
        if (! array_key_exists($locale, config('locales.supported')) || ! in_array($kind, ['post', 'project'], true)) {
            throw new NotFoundHttpException;
        }
        $number = filter_var($shard, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $size = $this->chunkSize($kind);
        if ($number === false || $number - 1 > intdiv(PHP_INT_MAX - $size, $size)) {
            throw new NotFoundHttpException;
        }
        app()->setLocale($locale);
        $urls = $this->contentUrls($locale, $kind, $number);

        return response(view('sitemap.locale', ['urls' => $urls])->render(), 200, ['Content-Type' => 'application/xml']);
    }

    private function chunkSize(?string $kind = null): int
    {
        $size = max(1, min(1000, (int) config('seo.sitemap_chunk_size', 1000)));
        // Each project may contain up to 1,000 image entries; bound XML size.
        return $kind === 'project' ? min(5, $size) : $size;
    }

    private function usesShards(string $locale): bool
    {
        // Counting before filtering noindex/canonical may split early, never too late.
        $projects = $this->contentQuery($locale, 'project')->count();
        return $projects > $this->chunkSize('project')
            || $this->contentQuery($locale, 'post')->count() + $projects + 8 > $this->chunkSize();
    }

    private function contentQuery(string $locale, string $kind): Builder
    {
        $model = $kind === 'post' ? Post::class : Project::class;
        return $model::query()->published()->hasTranslatedValue('slug', $locale);
    }

    /** @return list<int> */
    private function shardNumbers(string $locale, string $kind): array
    {
        $numbers = [];
        $this->contentQuery($locale, $kind)->select('id')->orderBy('id')->chunkById(1000, function ($rows) use (&$numbers, $kind): void {
            foreach ($rows as $row) {
                $numbers[intdiv((int) $row->id - 1, $this->chunkSize($kind)) + 1] = true;
            }
        });
        return array_keys($numbers);
    }

    /** @return list<array<string, mixed>> */
    private function contentUrls(string $locale, string $kind, ?int $shard = null): array
    {
        $query = $this->contentQuery($locale, $kind)->with('translations')->orderBy('id');
        if ($kind === 'project') {
            $query->with(['images' => fn ($images) => $images->orderBy('sort_order')->orderBy('id')->limit(1000)]);
        }
        if ($shard !== null) {
            $size = $this->chunkSize($kind);
            $first = ($shard - 1) * $size + 1;
            $query->whereBetween('id', [$first, $first + $size - 1]);
        }
        $route = $kind === 'post' ? 'insights.show' : 'work.show';
        $parameter = $kind === 'post' ? 'post' : 'project';
        return $query->get()
            ->filter(fn (Post|Project $model): bool => ! SeoVisibility::noindex($model, $locale) && SeoCanonical::isSelfCanonical($model, $locale))
            ->map(fn (Post|Project $model): array => [
                'loc' => CanonicalUrl::for($model->url($locale)),
                'priority' => $kind === 'post' ? 0.6 : 0.7,
                'changefreq' => 'monthly',
                'alternates' => $this->alternatesForModel($model, $route, $parameter),
                'images' => $this->imagesFor($model, $locale),
            ])->values()->all();
    }

    /** @return list<string> */
    private function imagesFor(Post|Project $model, string $locale): array
    {
        if (SeoVisibility::noimageindex($model, $locale)) {
            return [];
        }
        $candidates = $model instanceof Post
            ? [[$model->cover_path, 'post.hero']]
            : [
                [$model->banner_path ?: $model->cover_path, $model->banner_path ? 'project.banner' : 'project.cover'],
                [$model->before_image_path, 'project.beforeafter'],
                [$model->after_image_path, 'project.beforeafter'],
                ...$model->images->map(fn ($image): array => [$image->path, 'project.showcase'])->all(),
            ];
        $urls = [];
        $add = function (mixed $path, string $context) use (&$urls): bool {
            if (! is_string($path) || trim($path) === '') {
                return false;
            }
            if (preg_match('~^https?://~i', $path)) {
                if (! filter_var($path, FILTER_VALIDATE_URL)) {
                    return false;
                }
            } else {
                try {
                    if (! Storage::disk('public')->exists($path)) {
                        return false;
                    }
                } catch (\Throwable) {
                    return false;
                }
            }
            $url = MediaTransformer::primaryUrl($path, $context);
            if (! preg_match('~^https?://~i', $url)) {
                $segments = array_map(fn (string $segment): string => rawurlencode(rawurldecode($segment)), explode('/', ltrim($url, '/')));
                $url = CanonicalUrl::origin().'/'.implode('/', $segments);
            }
            $urls[$url] = true;
            return count($urls) >= 1000;
        };
        foreach ($candidates as [$path, $context]) {
            if ($add($path, $context)) {
                return array_keys($urls);
            }
        }
        // The initial bounded eager load may contain missing or duplicate files.
        // Continue in batches so those rows do not hide valid later images.
        if ($model instanceof Project && $model->images->count() === 1000) {
            $last = $model->images->last();
            $remaining = $model->images()->reorder()
                ->where(function (Builder $query) use ($last): void {
                    $query->where('sort_order', '>', $last->sort_order)
                        ->orWhere(fn (Builder $same): Builder => $same->where('sort_order', $last->sort_order)->where('id', '>', $last->id));
                })
                ->orderBy('sort_order')->orderBy('id')->lazy(500);
            foreach ($remaining as $image) {
                if ($add($image->path, 'project.showcase')) {
                    break;
                }
            }
        }
        return array_keys($urls);
    }

    /**
     * @return array<int, array{hreflang: string, href: string}>
     */
    private function alternatesForRoute(string $name, Page $page): array
    {
        return collect(config('locales.supported'))
            ->filter(fn (array $config, string $code): bool => ! SeoVisibility::noindex($page, $code) && SeoCanonical::isSelfCanonical($page, $code))
            ->map(fn (array $config, string $code): array => [
                'hreflang' => $config['html_lang'],
                'href' => CanonicalUrl::route($name, ['locale' => $code]),
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{hreflang: string, href: string}>
     */
    private function alternatesForModel(
        Project|Post $model,
        string $routeName,
        string $parameter,
    ): array {
        return collect(config('locales.supported'))
            ->filter(fn (array $config, string $code): bool => filled($model->translations->firstWhere('locale', $code)?->slug) && ! SeoVisibility::noindex($model, $code) && SeoCanonical::isSelfCanonical($model, $code))
            ->map(fn (array $config, string $code): array => [
                'hreflang' => $config['html_lang'],
                'href' => CanonicalUrl::route($routeName, [
                    'locale' => $code,
                    $parameter => $model->slugForLocale($code),
                ]),
            ])
            ->values()
            ->all();
    }
}
