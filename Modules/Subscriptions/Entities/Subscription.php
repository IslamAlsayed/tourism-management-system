<?php

namespace Modules\Subscriptions\Entities;

use Carbon\Carbon;
use Modules\Core\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'module_key',
        'starts_at',
        'ends_at',
        'is_active',
        'features',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the tenant that owns the subscription.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Check if the subscription is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        // If no start date, consider as starting from now
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        // If no end date, subscription is unlimited
        if (!$this->ends_at) {
            return true;
        }

        return $now->lte($this->ends_at);
    }

    /**
     * Check if the subscription has expired.
     */
    public function isExpired(): bool
    {
        return $this->ends_at && now()->gt($this->ends_at);
    }

    /**
     * Get days remaining until expiration.
     */
    public function daysRemaining(): ?int
    {
        if (!$this->ends_at) {
            return null; // Unlimited
        }

        return max(0, now()->diffInDays($this->ends_at, false));
    }

    /**
     * Activate the subscription.
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the subscription.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Renew the subscription for a given number of days.
     */
    public function renew(int $days): bool
    {
        $newEndDate = $this->ends_at
            ? Carbon::parse($this->ends_at)->addDays($days)
            : now()->addDays($days);

        return $this->update(['ends_at' => $newEndDate, 'is_active' => true]);
    }

    /**
     * Scope to get only active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * Scope to get subscriptions for a specific module.
     */
    public function scopeForModule($query, string $moduleKey)
    {
        return $query->where('module_key', $moduleKey);
    }

    /**
     * Scope to get subscriptions for a specific tenant.
     */
    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
