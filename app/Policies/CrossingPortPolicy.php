<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CrossingPort;

class CrossingPortPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, CrossingPort $crossingPort): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, CrossingPort $crossingPort): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, CrossingPort $crossingPort): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, CrossingPort $crossingPort): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, CrossingPort $crossingPort): bool
    {
        return $user->hasRole('superadmin');
    }
}
