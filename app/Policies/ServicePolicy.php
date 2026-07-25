<?php

declare(strict_types=1);

namespace App\Policies;

final class ServicePolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'service';
    }
}
