<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TourGuideReview;

class TourGuideReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TourGuideReview $tourGuideReview): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TourGuideReview $tourGuideReview): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TourGuideReview $tourGuideReview): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TourGuideReview $tourGuideReview): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TourGuideReview $tourGuideReview): bool
    {
        return $user->hasRole('superadmin');
    }
}
