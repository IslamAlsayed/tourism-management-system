<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuide;
use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourGuidePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guides.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can view the tour guide.
     */
    public function view(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can create tour guides.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can update the tour guide.
     */
    public function update(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can delete the tour guide.
     */
    public function delete(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can restore the tour guide.
     */
    public function restore(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    /**
     * Determine whether the user can permanently delete the tour guide.
     */
    public function forceDelete(User $user, TourGuide $guide): bool
    {
        return $user->can('superadmin');
    }
}
