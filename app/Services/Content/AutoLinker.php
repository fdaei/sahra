<?php

declare(strict_types=1);

namespace App\Services\Content;

use DOMElement;
use DOMText;

/**
 * Auto internal linking at render time. Matching is case-insensitive and
 * tolerant of Persian spelling variants: Arabic ي/ك vs Persian ی/ک, ZWNJ vs
 * space vs nothing, and diacritics. Never links inside headings, existing
 * links, code/pre, buttons or scripts, and never links a page to itself.
 */
final class AutoLinker
{
    private const SKIP_ANCESTORS = ['a', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'code', 'pre', 'script', 'style', 'button', 'textarea', 'figcaption', 'svg', 'math', 'iframe', 'noscript', 'select', 'option'];

    /**
     * @param  list<array{keyword: string, url: string, max: int}>  $rules  longest keyword first
     * @return int links inserted
     */
    public static function apply(HtmlFragment $fragment, array $rules, ?string $selfUrl, int $maxTotal): int
    {
        $self = self::normalizeUrl($selfUrl);
        $rules = array_values(array_filter($rules, fn (array $r): bool => trim($r['keyword']) !== '' && self::normalizeUrl($r['url']) !== $self));

        if ($rules === [] || $maxTotal <= 0) {
            return 0;
        }

        $skip = implode(' or ', array_map(fn (string $t): string => "ancestor::{$t}", self::SKIP_ANCESTORS));
        $total = 0;

        foreach ($rules as $rule) {
            $pattern = self::pattern($rule['keyword']);
            $count = 0;

            // Re-query per rule: earlier rules split text nodes and add <a>s to skip.
            // A queue, so the remainder after a link is scanned again for this rule.
            $queue = iterator_to_array($fragment->xpath->query("//text()[not({$skip})]"));

            while ($queue !== [] && $count < $rule['max'] && $total < $maxTotal) {
                $node = array_shift($queue);
                $parent = $node->parentNode;

                if (! $node instanceof DOMText || ! $parent instanceof DOMElement
                    || ! preg_match($pattern, $node->data, $m, PREG_OFFSET_CAPTURE)) {
                    continue;
                }

                [$match, $offset] = $m[0];
                $before = substr($node->data, 0, $offset);
                $after = substr($node->data, $offset + strlen($match));

                if ($before !== '') {
                    $parent->insertBefore($fragment->doc->createTextNode($before), $node);
                }
                $parent->insertBefore(self::link($fragment, $match, $rule['url']), $node);
                if ($after !== '') {
                    array_unshift($queue, $parent->insertBefore($fragment->doc->createTextNode($after), $node));
                }
                $parent->removeChild($node);

                $count++;
                $total++;
            }
        }

        return $total;
    }

    private static function link(HtmlFragment $fragment, string $text, string $url): DOMElement
    {
        $link = $fragment->doc->createElement('a');
        $link->appendChild($fragment->doc->createTextNode($text));
        $link->setAttribute('href', $url);
        $link->setAttribute('class', 'auto-link');

        if (preg_match('#^https?://#i', $url) && ! str_starts_with($url, rtrim((string) config('app.url'), '/'))) {
            $link->setAttribute('rel', 'noopener');
        }

        return $link;
    }

    /** Build a Unicode regex that matches the keyword across Persian spelling variants. */
    public static function pattern(string $keyword): string
    {
        $keyword = trim((string) preg_replace('/[\s\x{200C}]+/u', ' ', $keyword));
        $keyword = (string) preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $keyword);
        $gap = '[\x{200C}\x{064B}-\x{065F}\x{0670}]*';

        $parts = [];
        foreach (mb_str_split($keyword) as $char) {
            $parts[] = match ($char) {
                ' ' => '[\s\x{200C}]?',
                'ی', 'ي', 'ى' => '[یيى]',
                'ک', 'ك' => '[کك]',
                default => preg_quote($char, '/'),
            };
        }

        return '/(?<![\p{L}\p{N}])'.implode($gap, $parts).'(?![\p{L}\p{N}])/iu';
    }

    private static function normalizeUrl(?string $url): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        $path = (string) (parse_url($url, PHP_URL_PATH) ?? '');

        return rtrim(rawurldecode($path), '/') ?: '/';
    }
}
