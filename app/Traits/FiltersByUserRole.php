<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait FiltersByUserRole
{
    public static function bootFiltersByUserRole(): void
    {
        if (app()->runningInConsole()) {
            return;
        }
        if (static::class == 'App\Models\User') {
            return;
        }
        static::addGlobalScope('filterByUserRole', function (Builder $builder) {
            $user = Auth::user();
            if (!$user || ($user && $user->is_admin)) {
                return;
            }
            $builder->where(static::getActiveColumn(), 1);
        });
    }

    public function scopeFilterByUserRole(Builder $query, $user = null): Builder
    {
        $user ??= Auth::user();
        if (!$user || !property_exists($user, 'is_admin')) {
            return $query;
        }
        if (!$user->is_admin) {
            $query->where(static::getActiveColumn(), 1);
        }
        return $query;
    }

    /**
     * Get the column name used for active status filtering
     * Override this method in your model if you use a different column name
     */
    protected static function getActiveColumn()
    {
        return 'is_active';
    }

    /**
     * Scope to get only active records
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(static::getActiveColumn(), 1);
    }

    /**
     * Scope to get only inactive records
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where(static::getActiveColumn(), 0);
    }

    /**
     * Scope to get all records regardless of active status (for admins)
     */
    public function scopeWithInactive(Builder $query): Builder
    {
        return $query->withoutGlobalScope('filterByUserRole');
    }
}