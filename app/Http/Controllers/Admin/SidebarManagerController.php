<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SidebarMenuOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SidebarManagerController extends Controller
{
    /**
     * Display the sidebar manager interface
     */
    public function index()
    {
        try {
            // Load sidebar configuration from config file
            $sidebarConfig = config('sidebar.menu', []);

            // If no configuration found, use fallback
            if (empty($sidebarConfig)) {
                $sidebarConfig = [
                    [
                        'title' => ['ar' => 'لوحة التحكم', 'en' => 'Dashboard'],
                        'icon' => 'ki-filled ki-element-11',
                        'route' => 'dashboard',
                        'permission' => null,
                    ],
                    [
                        'title' => ['ar' => 'إدارة المستخدمين', 'en' => 'User Management'],
                        'icon' => 'ki-filled ki-profile-user',
                        'permission' => 'manage_users',
                        'children' => [
                            [
                                'title' => ['ar' => 'جميع المستخدمين', 'en' => 'All Users'],
                                'icon' => 'ki-filled ki-people',
                                'route' => 'users.index',
                            ],
                            [
                                'title' => ['ar' => 'إضافة مستخدم جديد', 'en' => 'Add New User'],
                                'icon' => 'ki-filled ki-plus',
                                'route' => 'users.create',
                            ]
                        ]
                    ],
                    [
                        'title' => ['ar' => 'إدارة المواقع', 'en' => 'Location Management'],
                        'icon' => 'ki-filled ki-geolocation',
                        'permission' => null,
                        'children' => [
                            [
                                'title' => ['ar' => 'البلدان', 'en' => 'Countries'],
                                'icon' => 'ki-filled ki-flag',
                                'route' => 'countries.index',
                            ],
                            [
                                'title' => ['ar' => 'المدن', 'en' => 'Cities'],
                                'icon' => 'ki-filled ki-home-2',
                                'route' => 'cities.index',
                            ]
                        ]
                    ]
                ];
            }

            $menuItems = $this->convertConfigToMenuItems($sidebarConfig);

            return view('admin.sidebar-manager.index', compact('menuItems'));

        } catch (\Exception $e) {
            Log::error('Sidebar Manager Error: ' . $e->getMessage());

            // Fallback with simple menu items
            $menuItems = [
                [
                    'key' => 'dashboard',
                    'icon' => 'ki-filled ki-element-11',
                    'title' => ['ar' => 'لوحة التحكم', 'en' => 'Dashboard'],
                    'route' => 'dashboard',
                    'level' => 0,
                    'children' => []
                ],
                [
                    'key' => 'user_management',
                    'icon' => 'ki-filled ki-profile-user',
                    'title' => ['ar' => 'إدارة المستخدمين', 'en' => 'User Management'],
                    'route' => '',
                    'level' => 0,
                    'children' => []
                ]
            ];

            return view('admin.sidebar-manager.index', compact('menuItems'));
        }
    }

    /**
     * Update menu order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'menu_data' => 'required|array',
            'menu_data.*.key' => 'required|string',
            'menu_data.*.order' => 'required|integer'
        ]);

        try {
            SidebarMenuOrder::updateOrder($request->menu_data);

            // Clear any cached menu data
            Cache::forget('sidebar_menu_ordered');

            return response()->json([
                'success' => true,
                'message' => __('messages.sidebar_order_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.sidebar_order_update_error', ['error' => $e->getMessage()])
            ], 500);
        }
    }

    /**
     * Toggle menu item visibility
     */
    public function toggleVisibility(Request $request)
    {
        $request->validate([
            'menu_key' => 'required|string',
            'is_visible' => 'required|boolean'
        ]);

        try {
            $menuOrder = SidebarMenuOrder::where('menu_key', $request->menu_key)->first();

            if ($menuOrder) {
                $menuOrder->update(['is_visible' => $request->is_visible]);
            } else {
                SidebarMenuOrder::create([
                    'menu_key' => $request->menu_key,
                    'is_visible' => $request->is_visible,
                    'order' => 999
                ]);
            }

            Cache::forget('sidebar_menu_ordered');

            return response()->json([
                'success' => true,
                'message' => $request->is_visible ? __('messages.sidebar_item_shown') : __('messages.sidebar_item_hidden')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.error_occurred') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset to default order
     */
    public function resetToDefault()
    {
        try {
            truncateWithReset(SidebarMenuOrder::class);
            Cache::forget('sidebar_menu_ordered');

            return response()->json([
                'success' => true,
                'message' => __('messages.sidebar_reset_default')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.sidebar_reset_error', ['error' => $e->getMessage()])
            ], 500);
        }
    }

    /**
     * Export current menu configuration
     */
    public function exportConfig()
    {
        try {
            $orderedMenu = SidebarMenuOrder::getOrderedMenu();
            $sidebarConfig = Config::get('sidebar.menu', []);

            $exportData = [
                'original_config' => $sidebarConfig,
                'current_order' => $orderedMenu,
                'exported_at' => now()->toISOString()
            ];

            return response()->json($exportData)
                ->header('Content-Disposition', 'attachment; filename="sidebar-config-' . date('Y-m-d-H-i-s') . '.json"');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.sidebar_export_error', ['error' => $e->getMessage()])
            ], 500);
        }
    }

    /**
     * Convert config array to manageable menu items
     */
    private function convertConfigToMenuItems($configItems, $parentKey = null, $level = 0)
    {
        $menuItems = [];

        foreach ($configItems as $index => $item) {
            $menuKey = $this->generateMenuKey($item, $parentKey, $index);

            $menuItem = [
                'key' => $menuKey,
                'title' => $item['title'] ?? [],
                'icon' => $item['icon'] ?? '',
                'route' => $item['route'] ?? '',
                'permission' => $item['permission'] ?? null,
                'level' => $level,
                'parent_key' => $parentKey,
                'original_index' => $index,
                'children' => []
            ];

            // Handle children
            if (isset($item['children']) && is_array($item['children'])) {
                $menuItem['children'] = $this->convertConfigToMenuItems(
                    $item['children'],
                    $menuKey,
                    $level + 1
                );
            }

            $menuItems[] = $menuItem;
        }

        return $menuItems;
    }

    /**
     * Generate unique menu key
     */
    private function generateMenuKey($item, $parentKey = null, $index = 0)
    {
        $title = $item['title']['en'] ?? $item['title']['ar'] ?? 'item_' . $index;
        $key = strtolower(str_replace([' ', '&', '-'], '_', $title));

        if ($parentKey) {
            return $parentKey . '.' . $key;
        }

        return $key;
    }
}
