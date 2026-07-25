<?php

declare(strict_types=1);

namespace App\Policies;

final class PagePolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'page';
    }
}
