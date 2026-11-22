<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;

final class SeoVisibility
{
    public static function noindex(Page|Post|Project|null $model, ?string $locale = null): bool
    {
        return $model !== null && (bool) $model->getTranslation('seo_noindex', $locale);
    }

    public static function nofollow(Page|Post|Project|null $model, ?string $locale = null): bool
    {
        return $model !== null && (bool) $model->getTranslation('seo_nofollow', $locale);
    }

    public static function noimageindex(Page|Post|Project|null $model, ?string $locale = null): bool
    {
        return $model !== null && (bool) $model->getTranslation('seo_noimageindex', $locale);
    }

    /** @return list<string> */
    public static function indexableLocales(Page|Post|Project|null $model): array
    {
        return array_values(array_filter(
            array_keys(config('locales.supported')),
            fn (string $locale): bool => ! self::noindex($model, $locale)
                && ($model === null || SeoCanonical::isSelfCanonical($model, $locale)),
        ));
    }
}
