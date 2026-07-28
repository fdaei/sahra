<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Services\ContentTransformer;
use App\Services\SeoBuilder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Projects listing (Figma 1362:7198) and case-study detail (1323:7541).
 */
final class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $page = Page::query()
            ->key('work')
            ->published()
            ->withContent()
            ->first();

        // Figma 542:871 lists the four *services* — Branding, Marketing
        // Design, Content Production, Social Media support — not industries.
        // The industry stays on the card as its category badge.
        $serviceFilter = $request->string('service')->toString();

        $query = Project::query()->forListing();

        if ($serviceFilter !== '') {
            $locale = app()->getLocale();

            $query->whereHas(
                'services.translations',
                fn ($q) => $q->where('locale', $locale)->where('slug', $serviceFilter),
            );
        }

        return Inertia::render('Work/Index', [
            'heading' => [
                'eyebrow' => (string) $page?->getTranslation('subtitle'),
                'title' => (string) $page?->getTranslation('title'),
                'description' => (string) $page?->getTranslation('description'),
            ],

            'projects' => $query
                ->get()
                ->map(fn (Project $p): array => ContentTransformer::projectSummary($p))
                ->all(),

            // Filter list — Figma "Filters" 542:858
            'filters' => Service::query()
                ->forDisplay()
                ->get()
                ->map(fn (Service $s): array => [
                    'slug' => (string) $s->getTranslation('slug'),
                    'name' => (string) $s->getTranslation('title'),
                ])
                ->all(),

            'activeFilter' => $serviceFilter ?: null,

            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }

    public function show(string $locale, Project $project): Response
    {
        // Route-model binding already filtered to published + active locale.
        $project->loadMissing([
            'industry.translations',
            'services.translations',
            'images.translations',
            'sections.translations',
            'sections.items.translations',
        ]);

        // The case study closes on the shared final CTA card (Figma 1419:9333,
        // present in 639:1617). It has no page of its own, so it reuses the
        // one authored on the Work page.
        $workPage = Page::query()->key('work')->published()->withContent()->first();

        return Inertia::render('Work/Show', [
            'project' => ContentTransformer::projectDetail($project),

            'finalCta' => $workPage === null
                ? null
                : (ContentTransformer::sectionMap($workPage->sections)['final_cta'] ?? null),

            'seo' => SeoBuilder::forProject($project),
        ]);
    }
}
