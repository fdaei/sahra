<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (parent, locale) — enforced by a composite unique
 * index in the migration.
 */
final class PageTranslation extends Model
{
    protected $fillable = [
        'locale',
        'title',
        'subtitle',
        'description',
        'content',
        'seo_title',
        'seo_description',
        'seo_focus_keyphrase',
        'seo_canonical_url',
        'seo_noindex',
        'seo_nofollow',
        'seo_nosnippet',
        'seo_noimageindex',
        'seo_max_image_preview',
        'seo_max_snippet',
        'seo_max_video_preview',
        'seo_social_title',
        'seo_social_description',
        'seo_social_image',
        'seo_social_image_alt',
        'seo_twitter_title',
        'seo_twitter_description',
        'seo_twitter_image',
        'seo_twitter_image_alt',
        'seo_twitter_card',
    ];

}
