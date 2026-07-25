<?php

declare(strict_types=1);

namespace App\Policies;

final class RedirectPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'redirect';
    }
}
