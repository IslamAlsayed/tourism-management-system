<?php

namespace Modules\TouristServices\Policies;

use Modules\Core\Entities\User;
use Modules\TouristServices\Entities\TouristService;

class TouristServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function view(User $user, TouristService $service): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function update(User $user, TouristService $service): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function delete(User $user, TouristService $service): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function restore(User $user, TouristService $service): bool
    {
        return $user->can('manage_tourist_services');
    }

    public function forceDelete(User $user, TouristService $service): bool
    {
        return $user->hasRole('superadmin');
    }
}
