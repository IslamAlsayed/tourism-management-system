<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Modules\Core\Entities\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_settings');
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_settings');
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    public function restore(User $user, Setting $setting): bool
    {
        return $user->can('manage_settings');
    }

    public function forceDelete(User $user, Setting $setting): bool
    {
        return $user->hasRole('superadmin');
    }
}
