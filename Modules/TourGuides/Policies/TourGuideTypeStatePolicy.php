<?php

namespace Modules\TourGuides\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideTypeState;

class TourGuideTypeStatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function view(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function update(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function delete(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function restore(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->can('manage_tour_guide_type_states');
    }

    public function forceDelete(User $user, TourGuideTypeState $typeState): bool
    {
        return $user->hasRole('superadmin');
    }
}
