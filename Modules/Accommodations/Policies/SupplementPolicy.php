<?php

namespace Modules\Accommodations\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Supplement;

class SupplementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_supplements');
    }

    public function view(User $user, Supplement $supplement): bool
    {
        return $user->can('manage_supplements');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_supplements');
    }

    public function update(User $user, Supplement $supplement): bool
    {
        return $user->can('manage_supplements');
    }

    public function delete(User $user, Supplement $supplement): bool
    {
        return $user->can('manage_supplements');
    }

    public function restore(User $user, Supplement $supplement): bool
    {
        return $user->can('manage_supplements');
    }

    public function forceDelete(User $user, Supplement $supplement): bool
    {
        return $user->can('manage_supplements');
    }
}
