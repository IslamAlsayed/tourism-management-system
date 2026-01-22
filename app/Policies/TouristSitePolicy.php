<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TouristSite;

class TouristSitePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TouristSite $touristSite): bool
    {
        return $user->hasRole('superadmin');
    }
}
