<?php

declare(strict_types=1);

namespace App\Policies;

final class IndustryPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'industry';
    }
}
