<?php

namespace App\Policies;

use App\Models\RichText;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class RichTextPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function view(User $user, RichText $richText): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function update(User $user, RichText $richText): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function delete(User $user, RichText $richText): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function restore(User $user, RichText $richText): bool
    {
        return $user->can('manage_rich_texts');
    }

    public function forceDelete(User $user, RichText $richText): bool
    {
        return $user->hasRole('superadmin');
    }
}
