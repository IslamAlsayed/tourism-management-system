<?php

namespace Modules\TourGuides\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\TourGuides\Entities\TourGuideTypeCity;

class TourGuideTypeCityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tour guide type cities.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can view the tour guide type city.
     */
    public function view(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can create tour guide type cities.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can update the tour guide type city.
     */
    public function update(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can delete the tour guide type city.
     */
    public function delete(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can restore the tour guide type city.
     */
    public function restore(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }

    /**
     * Determine whether the user can permanently delete the tour guide type city.
     */
    public function forceDelete(User $user, TourGuideTypeCity $typeCity): bool
    {
        return $user->can('manage_tour_guide_type_cities');
    }
}
