<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuideReview;
use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourGuideReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guides.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can view the tour guide review.
     */
    public function view(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can create tour guide reviews.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can update the tour guide review.
     */
    public function update(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can delete the tour guide review.
     */
    public function delete(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can restore the tour guide review.
     */
    public function restore(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }

    /**
     * Determine whether the user can permanently delete the tour guide review.
     */
    public function forceDelete(User $user, TourGuideReview $review): bool
    {
        return $user->can('manage_tour_guide_reviews');
    }
}
