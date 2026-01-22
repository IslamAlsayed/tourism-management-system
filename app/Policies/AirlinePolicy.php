<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Airline;

class AirlinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Airline $airline): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Airline $airline): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Airline $airline): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Airline $airline): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Airline $airline): bool
    {
        return $user->hasRole('superadmin');
    }
}
