<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TourGuideTypeState;

class TourGuideTypeStatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TourGuideTypeState $tourGuideTypeState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TourGuideTypeState $tourGuideTypeState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TourGuideTypeState $tourGuideTypeState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TourGuideTypeState $tourGuideTypeState): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TourGuideTypeState $tourGuideTypeState): bool
    {
        return $user->hasRole('superadmin');
    }
}
