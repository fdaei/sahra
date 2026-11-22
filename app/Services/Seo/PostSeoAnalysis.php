<?php

declare(strict_types=1);

namespace App\Services\Seo;

use DOMDocument;
use DOMXPath;
use App\Support\CanonicalUrl;
use App\Support\SeoCanonical;
use App\Support\SiteSettings;

/** Editorial checks, not a ranking prediction. Input is always unsaved form state. */
final class PostSeoAnalysis
{
    /**
     * @param  array<string, mixed>  $translation
     * @return list<array{level: 'good'|'warning'|'info', message: string}>
     */
    public function analyze(array $translation, ?bool $hasCover, bool $checkBody = true): array
    {
        $title = trim((string) ($translation['seo_title'] ?? '')) ?: trim((string) ($translation['title'] ?? ''));
        $description = trim((string) ($translation['seo_description'] ?? '')) ?: trim((string) ($translation['excerpt'] ?? ''));
        $description = trim(strip_tags($description));
        $html = (string) ($translation['content'] ?? '');
        $phrase = trim((string) ($translation['seo_focus_keyphrase'] ?? ''));
        $withoutScripts = preg_replace('~<(script|style)\b[^>]*>.*?</\1>~is', '', $html) ?? $html;
        $spacedHtml = preg_replace('~</(?:p|div|h[1-6]|li|blockquote)>|<br\s*/?>~i', ' ', $withoutScripts) ?? $withoutScripts;
        $text = html_entity_decode(strip_tags($spacedHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\[\[lead_magnet\]\]/i', ' ', $text) ?? $text;
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? $text);

        $checks = [];
        $titleLength = mb_strlen($title);
        $checks[] = $titleLength === 0
            ? $this->check('warning', 'Add a title for the search result.')
            : ($titleLength > 60 ? $this->check('warning', 'The search title has :count characters; long titles may be shortened.', ['count' => $titleLength]) : $this->check('good', 'Search title is present (:count characters).', ['count' => $titleLength]));
        $descriptionLength = mb_strlen($description);
        $checks[] = $descriptionLength === 0
            ? $this->check('warning', 'Add an SEO description or a summary for this language.')
            : ($descriptionLength > 160 ? $this->check('warning', 'The search description has :count characters; long descriptions may be shortened.', ['count' => $descriptionLength]) : $this->check('good', 'Search description is present (:count characters).', ['count' => $descriptionLength]));
        if ($hasCover !== null) {
            $checks[] = $hasCover ? $this->check('good', 'A cover image is selected.') : $this->check('info', 'Consider adding a cover image for sharing.');
            if ($hasCover && blank($translation['cover_alt'] ?? null)) {
                $checks[] = $this->check('info', 'Add cover alternative text here or in the media library.');
            }
        }
        if ($checkBody && $text === '') {
            $checks[] = $this->check('warning', 'Add article body content for this language.');
        } elseif ($checkBody) {
            $document = new DOMDocument;
            $document->loadHTML('<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>'.$html.'</body></html>', LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($document);
            $checks[] = $xpath->query('//h2|//h3')->length > 0
                ? $this->check('good', 'The article has subheadings.')
                : $this->check('info', 'Consider adding subheadings where they help readers.');
            $checks[] = $xpath->query('//a[@href and normalize-space(@href) != ""]')->length > 0
                ? $this->check('good', 'The article contains links.')
                : $this->check('info', 'Consider adding relevant links for readers.');
        }
        if ($phrase === '') {
            $checks[] = $this->check('info', 'Add a focus keyphrase to check its use in this language.');
        } else {
            foreach (['title' => $title, 'description' => $description, ...($checkBody ? ['body' => $text] : [])] as $part => $content) {
                $found = str_contains($this->normalize($content), $this->normalize($phrase));
                $checks[] = match ($part) {
                    'title' => $found ? $this->check('good', 'Focus keyphrase appears in the search title.') : $this->check('info', 'Focus keyphrase was not found in the search title.'),
                    'description' => $found ? $this->check('good', 'Focus keyphrase appears in the search description.') : $this->check('info', 'Focus keyphrase was not found in the search description.'),
                    default => $found ? $this->check('good', 'Focus keyphrase appears in the article body.') : $this->check('info', 'Focus keyphrase was not found in the article body.'),
                };
            }
        }
        if (! empty($translation['seo_noindex'])) {
            $checks[] = $this->check('info', 'This language is set to noindex.');
        }
        return $checks;
    }

    /** @param array<string, mixed> $translation @return array{title: string, description: string, url: string} */
    public function preview(array $translation, string $locale, ?string $defaultUrl = null): array
    {
        $title = trim((string) ($translation['seo_title'] ?? '')) ?: trim((string) ($translation['title'] ?? ''));
        $description = trim((string) ($translation['seo_description'] ?? '')) ?: trim((string) ($translation['excerpt'] ?? ''));
        $canonical = trim((string) ($translation['seo_canonical_url'] ?? ''));
        $slug = trim((string) ($translation['slug'] ?? ''));
        $url = SeoCanonical::valid($canonical) ? $canonical : ($defaultUrl ?? ($slug !== ''
            ? CanonicalUrl::route('insights.show', ['locale' => $locale, 'post' => $slug])
            : ''));
        return [
            'title' => $title ?: (string) SiteSettings::get('seo_default_title', $locale, 'Sahra'),
            'description' => trim(strip_tags($description ?: (string) SiteSettings::get('seo_default_description', $locale, ''))),
            'url' => $url,
        ];
    }

    /** @param array<string, string|int> $replace @return array{level: 'good'|'warning'|'info', message: string} */
    private function check(string $level, string $message, array $replace = []): array
    {
        return ['level' => $level, 'message' => __($message, $replace)];
    }

    private function normalize(string $value): string
    {
        $value = mb_strtolower(strtr($value, ['ي' => 'ی', 'ك' => 'ک', "\u{200c}" => ' ']), 'UTF-8');
        $value = preg_replace('/[\x{064B}-\x{065F}\x{0670}\x{0640}]/u', '', $value) ?? $value;
        return trim(preg_replace('/\s+/u', ' ', $value) ?? $value);
    }
}
