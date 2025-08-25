<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Sidebar extends Component
{
    public $menuItems;
    public $currentRoute;

    public function __construct()
    {
        $this->menuItems = config('sidebar.menu');
        $this->currentRoute = Route::currentRouteName();
    }

    public function render()
    {
        return view('components.sidebar');
    }

    public function isActiveRoute($route, $params = [])
    {
        if (is_array($route)) {
            return in_array($this->currentRoute, $route);
        }

        return $this->currentRoute === $route;
    }

    public function hasActiveChild($children)
    {
        foreach ($children as $child) {
            if (isset($child['route']) && $this->isActiveRoute($child['route'])) {
                return true;
            }
            if (isset($child['children']) && $this->hasActiveChild($child['children'])) {
                return true;
            }
        }
        return false;
    }

    public function checkPermission($permission)
    {
        if (!$permission) {
            return true;
        }

        // هنا يمكنك إضافة منطق التحقق من الصلاحيات
        // return auth()->user()->can($permission);
        return true; // مؤقتاً نرجع true لجميع الصلاحيات
    }
}
