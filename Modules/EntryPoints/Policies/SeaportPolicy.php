<?php

namespace Modules\EntryPoints\Policies;

use Modules\Core\Entities\User;
use Modules\EntryPoints\Entities\Seaport;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeaportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_seaports');
    }

    public function view(User $user, Seaport $seaport): bool
    {
        return $user->can('manage_seaports');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_seaports');
    }

    public function update(User $user, Seaport $seaport): bool
    {
        return $user->can('manage_seaports');
    }

    public function delete(User $user, Seaport $seaport): bool
    {
        return $user->can('manage_seaports');
    }

    public function restore(User $user, Seaport $seaport): bool
    {
        return $user->can('manage_seaports');
    }

    public function forceDelete(User $user, Seaport $seaport): bool
    {
        return $user->can('manage_seaports');
    }
}
