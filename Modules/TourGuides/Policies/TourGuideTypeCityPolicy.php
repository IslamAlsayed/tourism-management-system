<?php

namespace Modules\TourGuides\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideTypeCity;

class TourGuideTypeCityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function view(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function update(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function delete(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function restore(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    public function forceDelete(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->hasRole('superadmin');
    }
}
