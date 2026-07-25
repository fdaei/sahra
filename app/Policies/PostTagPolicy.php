<?php

declare(strict_types=1);

namespace App\Policies;

final class PostTagPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'post_tag';
    }
}
