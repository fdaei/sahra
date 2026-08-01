<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\ContentTransformer;
use App\Services\SeoBuilder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Blog listing (Figma 1353:7935) and article detail (1352:7391).
 */
final class PostController extends Controller
{
    private const PER_PAGE = 9;

    public function index(Request $request): Response
    {
        $page = Page::query()
            ->key('insights')
            ->published()
            ->withContent()
            ->first();

        $categoryFilter = $request->string('category')->toString();
        $search = $request->string('q')->toString();

        $query = Post::query()->forListing();

        if ($categoryFilter !== '') {
            $query->inCategory($categoryFilter);
        }

        if ($search !== '') {
            $locale = app()->getLocale();

            $query->whereHas('translations', function ($q) use ($locale, $search): void {
                $q->where('locale', $locale)
                    ->where(function ($inner) use ($search): void {
                        $inner->where('title', 'like', "%{$search}%")
                            ->orWhere('excerpt', 'like', "%{$search}%");
                    });
            });
        }

        // The featured card (Figma 1419:9265) is only shown on an unfiltered
        // first page — otherwise it would duplicate a grid result.
        $featured = null;

        if ($categoryFilter === '' && $search === '' && $request->integer('page', 1) === 1) {
            $featured = Post::query()->forListing()->featured()->first();

            if ($featured !== null) {
                $query->whereKeyNot($featured->getKey());
            }
        }

        $posts = $query->paginate(self::PER_PAGE)->withQueryString();

        return Inertia::render('Insights/Index', [
            'heading' => [
                'eyebrow' => (string) $page?->getTranslation('subtitle'),
                'title' => (string) $page?->getTranslation('title'),
                'description' => (string) $page?->getTranslation('description'),
            ],

            'featured' => $featured === null
                ? null
                : ContentTransformer::postSummary($featured),

            'posts' => [
                'data' => collect($posts->items())
                    ->map(fn (Post $p): array => ContentTransformer::postSummary($p))
                    ->all(),
                'currentPage' => $posts->currentPage(),
                'lastPage' => $posts->lastPage(),
                'total' => $posts->total(),
                'nextPageUrl' => $posts->nextPageUrl(),
                'prevPageUrl' => $posts->previousPageUrl(),
            ],

            'categories' => PostCategory::query()
                ->ordered()
                ->withTranslations()
                ->get()
                ->map(fn (PostCategory $c): array => [
                    'slug' => (string) $c->getTranslation('slug'),
                    'name' => (string) $c->getTranslation('name'),
                ])
                ->all(),

            'filters' => [
                'category' => $categoryFilter ?: null,
                'q' => $search ?: null,
            ],

            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }

    public function show(string $locale, Post $post): Response
    {
        $post->loadMissing([
            'category.translations',
            'tags.translations',
            'author',
        ]);

        // The article runs the lead-magnet strip mid-body (Figma 604:1464).
        // It has no page of its own, so it reuses the one authored on Home.
        $home = Page::query()->key('home')->published()->withContent()->first();
        $homeSections = $home === null
            ? []
            : ContentTransformer::sectionMap($home->sections);

        return Inertia::render('Insights/Show', [
            'post' => ContentTransformer::postDetail($post),

            'leadMagnet' => $homeSections['lead_magnet'] ?? null,
            'finalCta' => $homeSections['final_cta'] ?? null,

            'seo' => SeoBuilder::forPost($post),
        ]);
    }
}
