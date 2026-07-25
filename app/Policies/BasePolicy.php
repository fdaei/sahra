<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * Shared permission logic for every admin-managed entity.
 *
 * Permissions follow the `{action}_{resource}` convention seeded by
 * RolePermissionSeeder, e.g. `view_project`, `create_post`, `delete_service`.
 *
 * Roles:
 *   admin  — every permission, including users, settings and force-delete
 *   editor — content CRUD, no destructive or configuration access
 */
abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Permission suffix, e.g. 'project' -> view_project.
     */
    abstract protected function resource(): string;

    public function viewAny(User $user): bool
    {
        return $user->can("view_any_{$this->resource()}");
    }

    public function view(User $user, Model $model): bool
    {
        return $user->can("view_{$this->resource()}");
    }

    public function create(User $user): bool
    {
        return $user->can("create_{$this->resource()}");
    }

    public function update(User $user, Model $model): bool
    {
        return $user->can("update_{$this->resource()}");
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->can("delete_{$this->resource()}");
    }

    public function deleteAny(User $user): bool
    {
        return $user->can("delete_any_{$this->resource()}");
    }

    public function restore(User $user, Model $model): bool
    {
        return $user->can("restore_{$this->resource()}");
    }

    /**
     * Permanent deletion is admin-only regardless of granted permissions.
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function reorder(User $user): bool
    {
        return $user->can("update_any_{$this->resource()}");
    }
}
