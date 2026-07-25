<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactSubmissionRequest;
use App\Models\Page;
use App\Models\Service;
use App\Services\ContentTransformer;
use App\Services\SeoBuilder;
use App\Services\SubmissionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Contact page. Figma 1363:8934 (desktop) / 1494:9544 (mobile).
 */
final class ContactController extends Controller
{
    public function __construct(
        private readonly SubmissionHandler $handler,
    ) {}

    public function create(Request $request): Response
    {
        $page = Page::query()
            ->key('contact')
            ->published()
            ->withContent()
            ->first();

        return Inertia::render('Contact', [
            'sections' => $page === null
                ? []
                : ContentTransformer::sectionMap($page->sections),

            'heading' => [
                'eyebrow' => (string) $page?->getTranslation('subtitle'),
                'title' => (string) $page?->getTranslation('title'),
                'description' => (string) $page?->getTranslation('description'),
            ],

            // Options for the services multi-select.
            'services' => Service::query()
                ->forDisplay()
                ->get()
                ->map(fn (Service $s): array => [
                    'id' => $s->id,
                    'title' => (string) $s->getTranslation('title'),
                ])
                ->all(),

            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }

    public function store(ContactSubmissionRequest $request): RedirectResponse
    {
        $this->handler->handleContact($request);

        return back()->with('success', __('forms.contact.success'));
    }
}
