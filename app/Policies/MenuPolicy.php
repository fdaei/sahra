<?php

declare(strict_types=1);

namespace App\Policies;

final class MenuPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'menu';
    }
}
