<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Region;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_regions');
    }

    public function view(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_regions');
    }

    public function update(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    public function delete(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    public function restore(User $user, Region $region): bool
    {
        return $user->can('manage_regions');
    }

    public function forceDelete(User $user, Region $region): bool
    {
        return $user->hasRole('superadmin');
    }
}
