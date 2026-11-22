<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (project, locale).
 */
final class ProjectTranslation extends Model
{
    protected $fillable = [
        'locale',
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'challenge',
        'challenge_points',
        'results_summary',
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
        'cover_alt',
        'banner_alt',
        'before_alt',
        'after_alt',
    ];

    protected function casts(): array
    {
        return [
            'challenge_points' => 'array',
        ];
    }
}
