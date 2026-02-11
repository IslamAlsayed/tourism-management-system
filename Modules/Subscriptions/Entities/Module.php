<?php

namespace Modules\Subscriptions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'requires',
        'features',
        'price_monthly',
        'price_yearly',
        'trial_days',
        'is_core',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'requires' => 'array',
        'features' => 'array',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'trial_days' => 'integer',
        'is_core' => 'boolean',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: Get only available modules
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: Get core modules
     */
    public function scopeCore($query)
    {
        return $query->where('is_core', true);
    }

    /**
     * Scope: Get paid/optional modules
     */
    public function scopePaid($query)
    {
        return $query->where('is_core', false);
    }

    /**
     * Scope: Order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Relationship: Subscriptions for this module
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'module_key', 'key');
    }

    /**
     * Check if module has dependencies
     */
    public function hasDependencies(): bool
    {
        return !empty($this->requires);
    }

    /**
     * Get required modules
     */
    public function requiredModules()
    {
        if (!$this->hasDependencies()) {
            return collect([]);
        }

        return static::whereIn('key', $this->requires)->get();
    }

    /**
     * Check if all dependencies are available
     */
    public function areDependenciesAvailable(): bool
    {
        if (!$this->hasDependencies()) {
            return true;
        }

        $availableCount = static::whereIn('key', $this->requires)
            ->where('is_available', true)
            ->count();

        return $availableCount === count($this->requires);
    }
}
