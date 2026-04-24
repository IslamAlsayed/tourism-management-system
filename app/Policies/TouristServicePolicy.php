<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use Modules\TouristServices\Entities\TouristService;

class TouristServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function view(User $user, TouristService $touristService): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function update(User $user, TouristService $touristService): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function delete(User $user, TouristService $touristService): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function restore(User $user, TouristService $touristService): bool
    {
        return $user->can('manage_tourist_services') || $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, TouristService $touristService): bool
    {
        return $user->hasRole('superadmin');
    }
}
