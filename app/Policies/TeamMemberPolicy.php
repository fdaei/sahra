<?php

declare(strict_types=1);

namespace App\Policies;

final class TeamMemberPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'team_member';
    }
}
