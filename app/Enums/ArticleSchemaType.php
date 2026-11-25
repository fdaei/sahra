<?php

declare(strict_types=1);

namespace App\Enums;

enum ArticleSchemaType: string
{
    case Article = 'Article';
    case BlogPosting = 'BlogPosting';
    case NewsArticle = 'NewsArticle';
    case SocialMediaPosting = 'SocialMediaPosting';
    case AdvertiserContentArticle = 'AdvertiserContentArticle';
    case SatiricalArticle = 'SatiricalArticle';
    case ScholarlyArticle = 'ScholarlyArticle';
    case TechArticle = 'TechArticle';
    case Report = 'Report';
    case None = 'none';

    /** @return array<string, string> */
    public static function options(): array
    {
        return [
            self::Article->value => __('Article'),
            self::BlogPosting->value => __('Blog post'),
            self::NewsArticle->value => __('News article'),
            self::SocialMediaPosting->value => __('Social media post'),
            self::AdvertiserContentArticle->value => __('Advertiser content article'),
            self::SatiricalArticle->value => __('Satirical article'),
            self::ScholarlyArticle->value => __('Scholarly article'),
            self::TechArticle->value => __('Technical article'),
            self::Report->value => __('Report'),
            self::None->value => __('Disable article schema'),
        ];
    }
}
