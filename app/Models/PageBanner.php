<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    protected $fillable = [
        'route_name',
        'title',
        'image_path',
        'is_active',
        'apply_to',
        'module_name',
        'banner_type',
        'bg_color',
        'text_content',
        'text_color',
        'font_family',
        'font_size',
    ];

    /**
     * Get the active banner for the current route or module
     */
    public static function getCurrentBanner()
    {
        $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
        $moduleName = explode('.', $currentRoute)[1] ?? null;

        // 1. Try to find a banner for this exact route
        $banner = self::where('is_active', true)
            ->where('apply_to', 'route')
            ->where('route_name', $currentRoute)
            ->first();

        // 2. Fallback to a module-wide banner if no route banner exists
        if (!$banner && $moduleName) {
            // Capitalize first letter to match module names
            $moduleName = ucfirst($moduleName);
            $banner = self::where('is_active', true)
                ->where('apply_to', 'module')
                ->where('module_name', $moduleName)
                ->first();
        }

        return $banner;
    }
}
