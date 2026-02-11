<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuideType;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class TourGuideTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guide types.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can view the tour guide type.
     */
    public function view(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can create tour guide types.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can update the tour guide type.
     */
    public function update(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can delete the tour guide type.
     */
    public function delete(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can restore the tour guide type.
     */
    public function restore(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    /**
     * Determine whether the user can permanently delete the tour guide type.
     */
    public function forceDelete(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }
}
