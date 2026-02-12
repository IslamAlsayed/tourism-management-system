<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Transportation\Entities\RouteAssignment;

class RouteAssignmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function view(User $user, RouteAssignment $routeAssignment): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function update(User $user, RouteAssignment $routeAssignment): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function delete(User $user, RouteAssignment $routeAssignment): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function restore(User $user, RouteAssignment $routeAssignment): bool
    {
        return $user->can('manage_route_assignments');
    }

    public function forceDelete(User $user, RouteAssignment $routeAssignment): bool
    {
        return $user->hasRole('superadmin');
    }
}
