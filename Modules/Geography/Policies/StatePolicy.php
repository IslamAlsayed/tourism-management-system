<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\State;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_states');
    }

    public function view(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_states');
    }

    public function update(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    public function delete(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    public function restore(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    public function forceDelete(User $user, State $state): bool
    {
        return $user->hasRole('superadmin');
    }
}
