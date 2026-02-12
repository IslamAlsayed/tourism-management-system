<?php

namespace App\Policies;

use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_notifications');
    }

    public function view(User $user, Notification $notification): bool
    {
        return $user->can('manage_notifications');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_notifications');
    }

    public function update(User $user, Notification $notification): bool
    {
        return $user->can('manage_notifications');
    }

    public function delete(User $user, Notification $notification): bool
    {
        return $user->can('manage_notifications');
    }

    public function restore(User $user, Notification $notification): bool
    {
        return $user->can('manage_notifications');
    }

    public function forceDelete(User $user, Notification $notification): bool
    {
        return $user->hasRole('superadmin');
    }
}
