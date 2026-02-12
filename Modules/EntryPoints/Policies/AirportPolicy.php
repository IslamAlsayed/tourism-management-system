<?php

namespace Modules\EntryPoints\Policies;

use Modules\Core\Entities\User;
use Modules\EntryPoints\Entities\Airport;
use Illuminate\Auth\Access\HandlesAuthorization;

class AirportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_airports');
    }

    public function view(User $user, Airport $airport): bool
    {
        return $user->can('manage_airports');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_airports');
    }

    public function update(User $user, Airport $airport): bool
    {
        return $user->can('manage_airports');
    }

    public function delete(User $user, Airport $airport): bool
    {
        return $user->can('manage_airports');
    }

    public function restore(User $user, Airport $airport): bool
    {
        return $user->can('manage_airports');
    }

    public function forceDelete(User $user, Airport $airport): bool
    {
        return $user->can('manage_airports');
    }
}
