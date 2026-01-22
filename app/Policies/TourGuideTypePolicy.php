<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TourGuideType;

class TourGuideTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TourGuideType $tourGuideType): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TourGuideType $tourGuideType): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TourGuideType $tourGuideType): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TourGuideType $tourGuideType): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TourGuideType $tourGuideType): bool
    {
        return $user->hasRole('superadmin');
    }
}
