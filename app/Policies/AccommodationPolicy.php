<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Accommodation;

class AccommodationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Accommodation $accommodation): bool
    {
        return $user->hasRole('superadmin');
    }
}
