<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuideType;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class TourGuideTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function view(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function update(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function delete(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function restore(User $user, TourGuideType $type): bool
    {
        return $user->can('manage_tour_guide_types');
    }

    public function forceDelete(User $user, TourGuideType $type): bool
    {
        return $user->hasRole('superadmin');
    }
}
