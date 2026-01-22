<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MediaFile;

class MediaFilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, MediaFile $mediaFile): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, MediaFile $mediaFile): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, MediaFile $mediaFile): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, MediaFile $mediaFile): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, MediaFile $mediaFile): bool
    {
        return $user->hasRole('superadmin');
    }
}
