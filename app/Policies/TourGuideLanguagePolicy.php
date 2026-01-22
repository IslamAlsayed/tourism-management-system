<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TourGuideLanguage;

class TourGuideLanguagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TourGuideLanguage $tourGuideLanguage): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TourGuideLanguage $tourGuideLanguage): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TourGuideLanguage $tourGuideLanguage): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TourGuideLanguage $tourGuideLanguage): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TourGuideLanguage $tourGuideLanguage): bool
    {
        return $user->hasRole('superadmin');
    }
}
