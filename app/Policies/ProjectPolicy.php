<?php

declare(strict_types=1);

namespace App\Policies;

final class ProjectPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'project';
    }
}
