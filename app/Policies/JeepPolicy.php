<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Jeep;

class JeepPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Jeep $jeep): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Jeep $jeep): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Jeep $jeep): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Jeep $jeep): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Jeep $jeep): bool
    {
        return $user->hasRole('superadmin');
    }
}
