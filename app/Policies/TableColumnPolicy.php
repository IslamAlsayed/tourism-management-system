<?php

namespace App\Policies;

use Modules\Core\Entities\User;
use App\Models\TableColumn;

class TableColumnPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function forceDelete(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole('superadmin');
    }
}
