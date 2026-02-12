<?php

namespace Modules\Transportation\Policies;

use Modules\Core\Entities\User;
use Modules\Transportation\Entities\Jeep;
use Illuminate\Auth\Access\HandlesAuthorization;

class JeepPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_jeeps');
    }

    public function view(User $user, Jeep $jeep): bool
    {
        return $user->can('manage_jeeps');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_jeeps');
    }

    public function update(User $user, Jeep $jeep): bool
    {
        return $user->can('manage_jeeps');
    }

    public function delete(User $user, Jeep $jeep): bool
    {
        return $user->can('manage_jeeps');
    }

    public function restore(User $user, Jeep $jeep): bool
    {
        return $user->can('manage_jeeps');
    }

    public function forceDelete(User $user, Jeep $jeep): bool
    {
        return $user->hasRole('superadmin');
    }
}
