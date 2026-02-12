<?php

namespace Modules\Tourists\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;
use Modules\Tourists\Entities\TouristService;

class TouristServicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_services');
    }

    public function view(User $user, TouristService $service): bool
    {
        return $user->can('manage_services');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_services');
    }

    public function update(User $user, TouristService $service): bool
    {
        return $user->can('manage_services');
    }

    public function delete(User $user, TouristService $service): bool
    {
        return $user->can('manage_services');
    }

    public function restore(User $user, TouristService $service): bool
    {
        return $user->can('manage_services');
    }

    public function forceDelete(User $user, TouristService $service): bool
    {
        return $user->hasRole('superadmin');
    }
}
