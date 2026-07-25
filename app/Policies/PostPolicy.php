<?php

declare(strict_types=1);

namespace App\Policies;

final class PostPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'post';
    }
}
