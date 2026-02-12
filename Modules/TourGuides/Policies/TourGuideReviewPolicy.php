<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuideReview;
use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourGuideReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function view(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function update(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function delete(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function restore(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    public function forceDelete(User $user, TourGuideReview $review): bool
    {
        return $user->hasRole('superadmin');
    }
}
