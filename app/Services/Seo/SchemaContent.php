<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Post;
use App\Models\Page;

final class SchemaContent
{
    /** @return array{faqs: array<int, array{question: string, answer: string}>, howtoTitle: string, steps: array<int, array{name: string, text: string}>} */
    public static function forContent(Post|Page $post): array
    {
        $pairs = static function (mixed $value, string $first, string $second): array {
            if (! is_array($value)) {
                return [];
            }
            $result = [];
            foreach ($value as $item) {
                if (! is_array($item) || ! is_string($item[$first] ?? null) || ! is_string($item[$second] ?? null)) {
                    continue;
                }
                $a = trim(strip_tags($item[$first]));
                $b = trim(strip_tags($item[$second]));
                if ($a !== '' && $b !== '') {
                    $result[] = [$first => $a, $second => $b];
                }
            }
            return $result;
        };
        $steps = $pairs($post->getTranslation('schema_howto_steps'), 'name', 'text');
        $title = trim(strip_tags((string) $post->getTranslation('schema_howto_title')));

        return [
            'faqs' => $pairs($post->getTranslation('schema_faq_items'), 'question', 'answer'),
            'howtoTitle' => $steps === [] ? '' : ($title ?: (string) $post->getTranslation('title')),
            'steps' => $steps,
        ];
    }
}
