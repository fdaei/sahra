<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\ContentTransformer;
use App\Services\SeoBuilder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Home page. Figma 1419:9192 (desktop) / 1419:9191 (mobile).
 *
 * Fifteen sections per docs/FIGMA-AUDIT.md §5. Editorial copy comes from the
 * `home` Page's sections; the card lists come from their own entities so they
 * can be reused elsewhere (services also render on /services, posts on
 * /insights, and so on).
 */
final class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $page = Page::query()
            ->key('home')
            ->published()
            ->withContent()
            ->first();

        return Inertia::render('Home', [
            // Editorial blocks: hero, lead magnet, packages, final CTA, and the
            // eyebrow/title/subtitle of every other section.
            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            // Services cloud — Figma 1419:9279
            'services' => Service::query()
                ->forDisplay()
                ->onHome()
                ->get()
                ->map(fn (Service $s): array => ContentTransformer::service($s))
                ->all(),

            // Projects showcase — Figma 1419:9216 (five rows + image)
            'projects' => Project::query()
                ->forListing()
                ->featured()
                ->limit(5)
                ->get()
                ->map(fn (Project $p): array => ContentTransformer::projectSummary($p))
                ->all(),

            // Trust proof — Figma 1419:9205
            'clients' => Client::query()
                ->forDisplay()
                ->get()
                ->map(fn (Client $c): array => ContentTransformer::client($c))
                ->all(),

            // Reviews marquee — Figma 1419:9243
            'testimonials' => Testimonial::query()
                ->forDisplay()
                ->get()
                ->map(fn (Testimonial $t): array => ContentTransformer::testimonial($t))
                ->all(),

            // Insights — one large + two small (Figma 1419:9258)
            'posts' => Post::query()
                ->forListing()
                ->limit(3)
                ->get()
                ->map(fn (Post $p): array => ContentTransformer::postSummary($p))
                ->all(),

            // FAQ accordion — Figma 1419:9272
            'faqs' => Faq::query()
                ->forDisplay()
                ->get()
                ->map(fn (Faq $f): array => ContentTransformer::faq($f))
                ->all(),

            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }
}
