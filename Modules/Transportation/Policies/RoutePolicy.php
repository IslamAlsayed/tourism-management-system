<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Modules\Transportation\Entities\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoutePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_routes');
    }

    public function view(User $user, Route $route): bool
    {
        return $user->can('manage_routes');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_routes');
    }

    public function update(User $user, Route $route): bool
    {
        return $user->can('manage_routes');
    }

    public function delete(User $user, Route $route): bool
    {
        return $user->can('manage_routes');
    }

    public function restore(User $user, Route $route): bool
    {
        return $user->can('manage_routes');
    }

    public function forceDelete(User $user, Route $route): bool
    {
        return $user->hasRole('superadmin');
    }
}
