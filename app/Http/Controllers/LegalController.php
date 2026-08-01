<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\SeoBuilder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Privacy Policy (Figma 1031:2101) and Terms (1309:4891).
 * Both render the same rich-text template from a Page's `content`.
 */
final class LegalController extends Controller
{
    public function privacy(Request $request): Response
    {
        return $this->render('privacy-policy', $request);
    }

    public function terms(Request $request): Response
    {
        return $this->render('terms', $request);
    }

    private function render(string $key, Request $request): Response
    {
        $page = Page::query()
            ->key($key)
            ->published()
            ->withContent()
            ->first();

        if ($page === null) {
            throw new NotFoundHttpException;
        }

        return Inertia::render('Legal', [
            'title' => (string) $page->getTranslation('title'),
            // Figma 1031:2201 — the intro paragraph beside the title. Seeded
            // on every legal page but previously never handed to the view.
            'subtitle' => (string) $page->getTranslation('subtitle'),
            'content' => (string) $page->getTranslation('content'),
            'updatedAt' => $page->updated_at?->toIso8601String(),
            'seo' => SeoBuilder::forPage($page, $request->url()),
        ]);
    }
}
