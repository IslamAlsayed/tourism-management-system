<?php

namespace Modules\Subscriptions\Traits;

use Modules\Subscriptions\Entities\Subscription;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSubscriptions
{
    /**
     * Get all subscriptions for this tenant.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'tenant_id');
    }

    /**
     * Get active subscriptions only.
     */
    public function activeSubscriptions()
    {
        return $this->subscriptions()->active();
    }

    /**
     * Check if tenant has an active subscription for a specific module.
     */
    public function hasActiveModule(string $moduleKey): bool
    {
        return $this->subscriptions()
            ->forModule($moduleKey)
            ->active()
            ->exists();
    }

    /**
     * Check if tenant has subscribed to a module (active or not).
     */
    public function hasModule(string $moduleKey): bool
    {
        return $this->subscriptions()
            ->forModule($moduleKey)
            ->exists();
    }

    /**
     * Get subscription for a specific module.
     */
    public function getModuleSubscription(string $moduleKey): ?Subscription
    {
        return $this->subscriptions()
            ->forModule($moduleKey)
            ->first();
    }

    /**
     * Subscribe to a module.
     */
    public function subscribeTo(string $moduleKey, ?int $days = null, array $features = []): Subscription
    {
        $data = [
            'tenant_id' => $this->id,
            'module_key' => $moduleKey,
            'is_active' => true,
            'starts_at' => now(),
            'features' => $features,
        ];

        if ($days) {
            $data['ends_at'] = now()->addDays($days);
        }

        return $this->subscriptions()->updateOrCreate(
            ['module_key' => $moduleKey],
            $data
        );
    }

    /**
     * Unsubscribe from a module.
     */
    public function unsubscribeFrom(string $moduleKey): bool
    {
        return $this->subscriptions()
            ->forModule($moduleKey)
            ->delete();
    }

    /**
     * Activate a module subscription.
     */
    public function activateModule(string $moduleKey): bool
    {
        $subscription = $this->getModuleSubscription($moduleKey);

        return $subscription ? $subscription->activate() : false;
    }

    /**
     * Deactivate a module subscription.
     */
    public function deactivateModule(string $moduleKey): bool
    {
        $subscription = $this->getModuleSubscription($moduleKey);

        return $subscription ? $subscription->deactivate() : false;
    }

    /**
     * Get all active module keys for this tenant.
     */
    public function getActiveModules(): array
    {
        return $this->activeSubscriptions()
            ->pluck('module_key')
            ->toArray();
    }

    /**
     * Check if tenant has multiple active modules.
     */
    public function hasActiveModules(array $moduleKeys): bool
    {
        foreach ($moduleKeys as $moduleKey) {
            if (!$this->hasActiveModule($moduleKey)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if tenant has any of the given modules.
     */
    public function hasAnyActiveModule(array $moduleKeys): bool
    {
        foreach ($moduleKeys as $moduleKey) {
            if ($this->hasActiveModule($moduleKey)) {
                return true;
            }
        }

        return false;
    }
}
