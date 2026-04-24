<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use Modules\TouristSites\Entities\TouristSite;

class TouristSitePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function view(User $user, TouristSite $touristSite): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function update(User $user, TouristSite $touristSite): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function delete(User $user, TouristSite $touristSite): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function restore(User $user, TouristSite $touristSite): bool
    {
        return $user->can('manage_tourist_sites') || $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole('superadmin');
    }
}
