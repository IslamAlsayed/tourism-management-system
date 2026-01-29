<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TravelPass;

class TravelPassPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TravelPass $travelPass): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TravelPass $travelPass): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TravelPass $travelPass): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TravelPass $travelPass): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TravelPass $travelPass): bool
    {
        return $user->hasRole('superadmin');
    }
}
