<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\Notification;

class NotificationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Notification $notification): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Notification $notification): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Notification $notification): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Notification $notification): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, Notification $notification): bool
    {
        return $user->hasRole('superadmin');
    }
}
