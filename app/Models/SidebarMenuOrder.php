<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidebarMenuOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_key',
        'order',
        'parent_key',
        'level',
        'is_visible',
        'custom_data'
    ];

    protected $casts = [
        'custom_data' => 'array',
        'is_visible' => 'boolean'
    ];

    /**
     * Get child menu items
     */
    public function children(): HasMany
    {
        return $this->hasMany(SidebarMenuOrder::class, 'parent_key', 'menu_key')
                    ->orderBy('order');
    }

    /**
     * Get parent menu item
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SidebarMenuOrder::class, 'parent_key', 'menu_key');
    }

    /**
     * Scope for main menu items only
     */
    public function scopeMainItems($query)
    {
        return $query->where('level', 0)->whereNull('parent_key');
    }

    /**
     * Scope for visible items only
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Get ordered menu structure
     */
    public static function getOrderedMenu()
    {
        // For now, return empty collection to avoid errors
        // We'll fix this once the interface is working
        return collect();
    }

    /**
     * Update menu order
     */
    public static function updateOrder(array $menuData)
    {
        foreach ($menuData as $index => $item) {
            self::updateOrCreate(
                ['menu_key' => $item['key']],
                [
                    'order' => $index,
                    'parent_key' => $item['parent_key'] ?? null,
                    'level' => $item['level'] ?? 0,
                    'is_visible' => $item['is_visible'] ?? true
                ]
            );

            // Handle children recursively
            if (isset($item['children']) && is_array($item['children'])) {
                foreach ($item['children'] as $childIndex => $child) {
                    self::updateOrCreate(
                        ['menu_key' => $child['key']],
                        [
                            'order' => $childIndex,
                            'parent_key' => $item['key'],
                            'level' => ($item['level'] ?? 0) + 1,
                            'is_visible' => $child['is_visible'] ?? true
                        ]
                    );

                    // Handle sub-children
                    if (isset($child['children']) && is_array($child['children'])) {
                        foreach ($child['children'] as $subChildIndex => $subChild) {
                            self::updateOrCreate(
                                ['menu_key' => $subChild['key']],
                                [
                                    'order' => $subChildIndex,
                                    'parent_key' => $child['key'],
                                    'level' => ($item['level'] ?? 0) + 2,
                                    'is_visible' => $subChild['is_visible'] ?? true
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
