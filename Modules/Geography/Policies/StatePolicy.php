<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Modules\Geography\Entities\State;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any states.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can view the state.
     */
    public function view(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can create states.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can update the state.
     */
    public function update(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can delete the state.
     */
    public function delete(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can restore the state.
     */
    public function restore(User $user, State $state): bool
    {
        return $user->can('manage_states');
    }

    /**
     * Determine whether the user can permanently delete the state.
     */
    public function forceDelete(User $user, State $state): bool
    {
        return $user->can('superadmin');
    }
}
