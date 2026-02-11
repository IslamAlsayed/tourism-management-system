<?php

namespace Modules\Accommodations\Policies;

use Modules\Core\Entities\User;
use Modules\Accommodations\Entities\Type;

class TypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_types');
    }

    public function view(User $user, Type $type): bool
    {
        return $user->can('manage_types');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_types');
    }

    public function update(User $user, Type $type): bool
    {
        return $user->can('manage_types');
    }

    public function delete(User $user, Type $type): bool
    {
        return $user->can('manage_types');
    }

    public function restore(User $user, Type $type): bool
    {
        return $user->can('manage_types');
    }

    public function forceDelete(User $user, Type $type): bool
    {
        return $user->can('manage_types');
    }
}
