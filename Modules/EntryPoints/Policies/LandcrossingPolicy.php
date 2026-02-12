<?php

namespace Modules\EntryPoints\Policies;

use Modules\Core\Entities\User;
use Modules\EntryPoints\Entities\Landcrossing;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandcrossingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function view(User $user, Landcrossing $landcrossing): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function update(User $user, Landcrossing $landcrossing): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function delete(User $user, Landcrossing $landcrossing): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function restore(User $user, Landcrossing $landcrossing): bool
    {
        return $user->can('manage_land_crossings');
    }

    public function forceDelete(User $user, Landcrossing $landcrossing): bool
    {
        return $user->can('manage_land_crossings');
    }
}
