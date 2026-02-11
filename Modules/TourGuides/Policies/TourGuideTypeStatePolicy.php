<?php

namespace Modules\TourGuides\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideTypeState;

class TourGuideTypeStatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guide type states.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can view the tour guide type state state.
     */
    public function view(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can create tour guide type states.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can update the tour guide type state.
     */
    public function update(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can delete the tour guide type state.
     */
    public function delete(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can restore the tour guide type state.
     */
    public function restore(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    /**
     * Determine whether the user can permanently delete the tour guide type state.
     */
    public function forceDelete(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }
}
