<?php

namespace Modules\TourGuides\Policies;

use Modules\TourGuides\Entities\TourGuide;
use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourGuidePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function view(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function update(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function delete(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function restore(User $user, TourGuide $guide): bool
    {
        return $user->can('manage_tour_guides');
    }

    public function forceDelete(User $user, TourGuide $guide): bool
    {
        return $user->hasRole('superadmin');
    }
}
