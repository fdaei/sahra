<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * User management is admin-only, with one extra guard: nobody can delete
 * their own account from the panel, which would lock them out mid-session.
 */
final class UserPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'user';
    }

    public function delete(User $user, Model $model): bool
    {
        if ($user->is($model)) {
            return false;
        }

        return $user->isAdmin();
    }

    public function forceDelete(User $user, Model $model): bool
    {
        return ! $user->is($model) && $user->isAdmin();
    }
}
