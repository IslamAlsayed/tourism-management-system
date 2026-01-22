<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Setting;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->hasRole('superadmin');
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $user->hasRole('superadmin');
    }

    public function restore(User $user, Setting $setting): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, Setting $setting): bool
    {
        return $user->hasRole('superadmin');
    }
}
