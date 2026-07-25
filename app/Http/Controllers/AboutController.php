<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\TeamMember;
use App\Services\ContentTransformer;
use App\Services\SeoBuilder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * About page. Figma 908:1576 (desktop) / 1557:12225 (mobile).
 *
 * Sections: about hero, story, how-we-think (4 principles), team grid.
 */
final class AboutController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $page = Page::query()
            ->key('about')
            ->published()
            ->withContent()
            ->first();

        return Inertia::render('About', [
            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            'team' => TeamMember::query()
                ->forDisplay()
                ->get()
                ->map(fn (TeamMember $m): array => ContentTransformer::teamMember($m))
                ->all(),

            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }
}
