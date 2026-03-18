<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class SidebarMenuOrder extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'menu_key',
        'order',
        'parent_key',
        'level',
        'is_visible',
        'custom_data',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'custom_data' => 'array',
        'order' => 'integer',
        'level' => 'integer',
    ];

    public static function getOrderedMenu()
    {
        return self::orderBy('order')->get()->map(function ($item) {
            return [
                'menu_key' => $item->menu_key,
                'order' => $item->order,
                'parent_key' => $item->parent_key,
                'level' => $item->level,
                'is_visible' => $item->is_visible,
                'custom_data' => $item->custom_data,
            ];
        })->toArray();
    }

    public static function saveConfig($configStructure)
    {
        self::truncate();
        foreach ($configStructure as $item) {
            self::create($item);
        }
        return true;
    }
}
