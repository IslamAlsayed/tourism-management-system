<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Modules\Core\Entities\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any settings.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can view the setting.
     */
    public function view(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can create settings.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can update the setting.
     */
    public function update(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can delete the setting.
     */
    public function delete(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can restore the setting.
     */
    public function restore(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    /**
     * Determine whether the user can permanently delete the setting.
     */
    public function forceDelete(User $user, Setting $setting): bool
    {
        return $user->can('superadmin');
    }
}
