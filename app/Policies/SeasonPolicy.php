<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Season;

class SeasonPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Season $season): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Season $season): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Season $season): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Season $season): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Season $season): bool
    {
        return $user->hasRole('superadmin');
    }
}
