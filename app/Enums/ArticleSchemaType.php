<?php

declare(strict_types=1);

namespace App\Enums;

enum ArticleSchemaType: string
{
    case Article = 'Article';
    case BlogPosting = 'BlogPosting';
    case NewsArticle = 'NewsArticle';
    case None = 'none';

    /** @return array<string, string> */
    public static function options(): array
    {
        return [
            self::Article->value => __('Article'),
            self::BlogPosting->value => __('Blog post'),
            self::NewsArticle->value => __('News article'),
            self::None->value => __('Disable article schema'),
        ];
    }
}
