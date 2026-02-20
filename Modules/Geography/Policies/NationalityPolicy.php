<?php

namespace Modules\Geography\Policies;

use Modules\Core\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Geography\Entities\Nationality;

class NationalityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_nationalities');
    }

    public function view(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_nationalities');
    }

    public function update(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    public function delete(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    public function restore(User $user, Nationality $nationality): bool
    {
        return $user->can('manage_nationalities');
    }

    public function forceDelete(User $user, Nationality $nationality): bool
    {
        return $user->hasRole('superadmin');
    }
}
