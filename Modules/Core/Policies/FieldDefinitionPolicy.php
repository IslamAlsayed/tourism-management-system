<?php

namespace Modules\Core\Policies;

use Modules\Core\Entities\User;
use Modules\Core\Entities\FieldDefinition;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldDefinitionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function view(User $user, FieldDefinition $fieldDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, FieldDefinition $fieldDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function delete(User $user, FieldDefinition $fieldDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function restore(User $user, FieldDefinition $fieldDefinition): bool
    {
        return $user->hasRole('superadmin');
    }

    public function forceDelete(User $user, FieldDefinition $fieldDefinition): bool
    {
        return $user->hasRole('superadmin');
    }
}
