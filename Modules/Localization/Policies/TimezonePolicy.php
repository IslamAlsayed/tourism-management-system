<?php

namespace Modules\Localization\Policies;

use Modules\Core\Entities\User;
use Modules\Localization\Entities\Timezone;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimezonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any timezones.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can view the timezone.
     */
    public function view(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can create timezones.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can update the timezone.
     */
    public function update(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can delete the timezone.
     */
    public function delete(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can restore the timezone.
     */
    public function restore(User $user, Timezone $timezone): bool
    {
        return $user->can('manage_timezones');
    }

    /**
     * Determine whether the user can permanently delete the timezone.
     */
    public function forceDelete(User $user, Timezone $timezone): bool
    {
        return $user->can('superadmin');
    }
}
