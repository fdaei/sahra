<?php

declare(strict_types=1);

namespace App\Policies;

final class PostCategoryPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'post_category';
    }
}
