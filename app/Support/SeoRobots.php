<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;

final class SeoRobots
{
    public static function render(Page|Post|Project|null $model, bool $noindex, bool $nofollow): string
    {
        $directives = [$noindex ? 'noindex' : 'index', $nofollow ? 'nofollow' : 'follow'];
        $nosnippet = (bool) $model?->getTranslation('seo_nosnippet');
        if ($nosnippet) {
            $directives[] = 'nosnippet';
        }
        if ((bool) $model?->getTranslation('seo_noimageindex')) {
            $directives[] = 'noimageindex';
        }
        $image = $model?->getTranslation('seo_max_image_preview');
        if (in_array($image, ['none', 'standard', 'large'], true)) {
            $directives[] = 'max-image-preview:'.$image;
        } elseif (! $noindex) {
            // Preserve the previous site-wide default when no override is selected.
            $directives[] = 'max-image-preview:large';
        }
        if (! $nosnippet) {
            foreach (['seo_max_snippet' => 'max-snippet', 'seo_max_video_preview' => 'max-video-preview'] as $field => $directive) {
                $value = $model?->getTranslation($field);
                if ($value !== null && $value !== '') {
                    $number = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => -1, 'max_range' => 2147483647]]);
                    if ($number !== false) {
                        $directives[] = $directive.':'.$number;
                    }
                }
            }
        }
        return implode(', ', $directives);
    }
}
