<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\CrossingPort;

class CrossingPortPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function view(User $user, CrossingPort $crossingPort): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function update(User $user, CrossingPort $crossingPort): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function delete(User $user, CrossingPort $crossingPort): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function restore(User $user, CrossingPort $crossingPort): bool
    {
        return $user->can('manage_crossing_ports');
    }

    public function forceDelete(User $user, CrossingPort $crossingPort): bool
    {
        return $user->can('manage_crossing_ports');
    }
}
