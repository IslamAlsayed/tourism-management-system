<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\Subregion;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubregionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_subregions');
    }

    public function view(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_subregions');
    }

    public function update(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    public function delete(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    public function restore(User $user, Subregion $subregion): bool
    {
        return $user->can('manage_subregions');
    }

    public function forceDelete(User $user, Subregion $subregion): bool
    {
        return $user->hasRole('superadmin');
    }
}
