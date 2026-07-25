<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Page;
use App\Models\Project;
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

        $industryFilter = $request->string('industry')->toString();

        $query = Project::query()->forListing();

        if ($industryFilter !== '') {
            $locale = app()->getLocale();

            $query->whereHas(
                'industry.translations',
                fn ($q) => $q->where('locale', $locale)->where('slug', $industryFilter),
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

            // Filter chips — Figma "Filters" 1363:7500
            'industries' => Industry::query()
                ->ordered()
                ->withTranslations()
                ->get()
                ->map(fn (Industry $i): array => [
                    'slug' => (string) $i->getTranslation('slug'),
                    'name' => (string) $i->getTranslation('name'),
                ])
                ->all(),

            'activeIndustry' => $industryFilter ?: null,

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

        return Inertia::render('Work/Show', [
            'project' => ContentTransformer::projectDetail($project),
            'seo' => SeoBuilder::forProject($project),
        ]);
    }
}
