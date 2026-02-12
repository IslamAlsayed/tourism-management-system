<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Timezone;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimezonePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_timezones');
    }

    public function view(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_timezones');
    }

    public function update(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    public function delete(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    public function restore(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    public function forceDelete(User $user, Timezone $timezone): bool
    {
        return $user->hasRole('superadmin');
    }
}
