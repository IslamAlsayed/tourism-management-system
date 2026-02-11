<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\RichText;

class RichTextPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, RichText $richText): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, RichText $richText): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, RichText $richText): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, RichText $richText): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, RichText $richText): bool
    {
        return $user->hasRole('superadmin');
    }
}
