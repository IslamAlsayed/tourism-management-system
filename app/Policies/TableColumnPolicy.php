<?php

namespace App\Policies;

use App\Models\TableColumn;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Entities\User;

class TableColumnPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage_table_columns');
    }

    public function view(User $user, TableColumn $tableColumn): bool
    {
        return $user->can('manage_table_columns');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_table_columns');
    }

    public function update(User $user, TableColumn $tableColumn): bool
    {
        return $user->can('manage_table_columns');
    }

    public function delete(User $user, TableColumn $tableColumn): bool
    {
        return $user->can('manage_table_columns');
    }

    public function restore(User $user, TableColumn $tableColumn): bool
    {
        return $user->can('manage_table_columns');
    }

    public function forceDelete(User $user, TableColumn $tableColumn): bool
    {
        return $user->hasRole('superadmin');
    }
}
