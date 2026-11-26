<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\ContentTransformer;
use App\Services\MediaTransformer;
use App\Services\SeoBuilder;
use App\Support\Breadcrumbs;
use App\Support\IconUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Blog listing (Figma 1353:7935) and article detail (1352:7391).
 */
final class PostController extends Controller
{
    private const PER_PAGE = 9;

    public function index(Request $request): View
    {
        $page = Page::query()
            ->key('insights')
            ->published()
            ->withContent()
            ->firstOrFail();

        $categoryFilter = $request->string('category')->toString();
        $search = $request->string('q')->toString();
        $pageNumber = filter_var($request->query('page', 1), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => intdiv(PHP_INT_MAX, self::PER_PAGE)],
        ]);
        abort_if($pageNumber === false, 404);

        $filters = array_filter(['category' => $categoryFilter, 'q' => $search], fn (string $value): bool => $value !== '');

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

        if ($filters === []) {
            $featured = Post::query()->forListing()->featured()->first();

            if ($featured !== null) {
                $query->whereKeyNot($featured->getKey());
                if ($pageNumber !== 1) {
                    $featured = null;
                }
            }
        }

        $posts = $query->paginate(self::PER_PAGE, page: $pageNumber)->appends($filters);
        abort_if($pageNumber > $posts->lastPage(), 404);

        return view('app', [
            'template' => 'public.pages.insights.index',
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
                'prevPageUrl' => $pageNumber === 2
                    ? route('insights.index', $filters, absolute: false)
                    : $posts->previousPageUrl(),
            ],

            // Flat list; `parent` (a slug) lets the page show the
            // subcategories of the selected branch.
            'categories' => PostCategory::query()
                ->ordered()->withTranslations()->with('parent.translations')->get()
                ->map(fn (PostCategory $c): array => [
                    'slug' => (string) $c->getTranslation('slug'),
                    'name' => (string) $c->getTranslation('name'),
                    'parent' => $c->parent === null ? null : (string) $c->parent->getTranslation('slug'),
                ])
                ->filter(fn (array $c): bool => $c['slug'] !== '')
                ->values()
                ->all(),

            'filters' => [
                'category' => $categoryFilter ?: null,
                'q' => $search ?: null,
            ],

            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            'seo' => $this->listingSeo($page, $request, $categoryFilter, $search, $pageNumber),
        ]);
    }

    /**
     * Listing SEO; a category filter deepens the breadcrumb to
     * Home › Insights › [parent ›] category.
     *
     * @return array<string, mixed>
     */
    private function listingSeo(Page $page, Request $request, string $categoryFilter, string $search, int $pageNumber): array
    {
        $seo = SeoBuilder::forPage($page, $request->url(), noindex: $categoryFilter !== '' || $search !== '');

        if ($pageNumber > 1 && ! $seo['noindex']) {
            // An alternate must have enough public articles in that language
            // after reserving its featured article for page one.
            $localesWithPage = Post::query()->published()
                ->join('post_translations', 'post_translations.post_id', '=', 'posts.id')
                ->whereIn('post_translations.locale', $seo['indexableLocales'])
                ->whereNotNull('post_translations.slug')
                ->where('post_translations.slug', '<>', '')
                ->groupBy('post_translations.locale')
                ->havingRaw('COUNT(*) - MAX(CASE WHEN posts.is_featured THEN 1 ELSE 0 END) > ?', [
                    ($pageNumber - 1) * self::PER_PAGE,
                ])
                ->pluck('post_translations.locale')->all();

            $seo['alternatePage'] = $pageNumber;
            $seo['indexableLocales'] = array_values(array_intersect($seo['indexableLocales'], $localesWithPage));
        }

        if ($categoryFilter === '') {
            return $seo;
        }

        $locale = app()->getLocale();
        $category = PostCategory::query()
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->where('slug', $categoryFilter))
            ->withTranslations()
            ->first();

        if ($category === null) {
            return $seo;
        }

        return Breadcrumbs::attach($seo, [
            Breadcrumbs::home(),
            Breadcrumbs::route((string) $page->getTranslation('title'), 'insights.index'),
            ...Breadcrumbs::category($category),
        ]);
    }

    public function show(string $locale, Post $post): View
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

        return view('app', [
            'template' => 'public.pages.insights.show',
            'post' => ContentTransformer::postDetail($post),
            'comments' => $post->comments()->where('status', 'approved')->orderBy('created_at')->get(['id', 'name', 'body', 'created_at'])
                ->map(fn ($comment): array => ['id' => $comment->id, 'name' => $comment->name, 'body' => $comment->body, 'date' => $comment->created_at->toDateString()]),
            'commentUrl' => route('insights.comments.store', ['locale' => $locale, 'post' => $post->slugForLocale($locale)], absolute: false),
            'commentSuccess' => (bool) session('comment_success'),

            'leadMagnet' => $this->leadMagnetFor($post, $homeSections['lead_magnet'] ?? null),
            'finalCta' => $homeSections['final_cta'] ?? null,

            // Home › Insights › [parent ›] category › article
            'seo' => Breadcrumbs::attach(SeoBuilder::forPost($post), [
                Breadcrumbs::home(),
                Breadcrumbs::route(__('common.breadcrumb_insights'), 'insights.index'),
                ...($post->category === null ? [] : Breadcrumbs::category($post->category)),
                Breadcrumbs::crumb((string) $post->getTranslation('title'), $post->url(absolute: false)),
            ]),
        ]);
    }

    /**
     * The visual defaults come from Home, while copy, artwork, and the private
     * download belong to the individual article.
     *
     * @param  array<string, mixed>|null  $fallback
     * @return array<string, mixed>|null
     */
    private function leadMagnetFor(Post $post, ?array $fallback): ?array
    {
        $path = $post->lead_magnet_file_path;

        if (
            blank($path)
            || ! Storage::disk('local')->exists($path)
            || (! $post->lead_magnet_allow_download && ! $post->lead_magnet_send_email)
        ) {
            return null;
        }

        $slug = $post->slugForLocale(app()->getLocale());

        return [
            'title' => (string) ($post->getTranslation('lead_magnet_title') ?: ($fallback['title'] ?? '')),
            'description' => (string) ($post->getTranslation('lead_magnet_description') ?: ($fallback['description'] ?? '')),
            'primaryCta' => [
                'label' => (string) ($post->getTranslation('lead_magnet_cta_label') ?: ($fallback['primaryCta']['label'] ?? __('forms.newsletter.submit'))),
                'url' => '',
                'icon' => IconUrl::resolve($post->lead_magnet_cta_icon)
                    ?? ($fallback['primaryCta']['icon'] ?? null),
                'hoverIcon' => IconUrl::resolve($post->lead_magnet_cta_hover_icon)
                    ?? ($fallback['primaryCta']['hoverIcon'] ?? null),
            ],
            'image' => $post->lead_magnet_image_path
                ? MediaTransformer::make(
                    $post->lead_magnet_image_path,
                    $post->getTranslation('lead_magnet_image_alt'),
                    'post.cover',
                )
                : ($fallback['image'] ?? null),
            'colors' => $fallback['colors'] ?? [],
            'submitUrl' => route('insights.lead-magnet.store', ['post' => $slug], absolute: false),
            'downloadUrl' => $post->lead_magnet_allow_download
                ? route('insights.lead-magnet.download', ['post' => $slug], absolute: false)
                : null,
            'delivery' => [
                'download' => (bool) $post->lead_magnet_allow_download,
                'email' => (bool) $post->lead_magnet_send_email,
            ],
        ];
    }
}
