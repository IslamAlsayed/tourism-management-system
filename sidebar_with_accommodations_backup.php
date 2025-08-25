<?php

return [
    'menu' => [
        [
            'title' => [
                'en' => 'Dashboard',
                'ar' => 'الرئيسية'
            ],
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'User Management',
                'ar' => 'إدارة المستخدمين'
            ],
            'icon' => 'ki-filled ki-profile-user',
            'permission' => 'manage_users',
            'children' => [
                [
                    'title' => [
                        'en' => 'All Users',
                        'ar' => 'جميع المستخدمين'
                    ],
                    'icon' => 'ki-filled ki-people',
                    'route' => 'users.index',
                ],
                [
                    'title' => [
                        'en' => 'Add New User',
                        'ar' => 'إضافة مستخدم جديد'
                    ],
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'users.create',
                ],
                [
                    'title' => [
                        'en' => 'Active Users',
                        'ar' => 'المستخدمين النشطين'
                    ],
                    'icon' => 'ki-filled ki-check-circle',
                    'route' => 'users.index',
                    'params' => ['status' => 'active'],
                ],
                [
                    'title' => [
                        'en' => 'Inactive Users',
                        'ar' => 'المستخدمين المعطلين'
                    ],
                    'icon' => 'ki-filled ki-cross-circle',
                    'route' => 'users.index',
                    'params' => ['status' => 'inactive'],
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Location Management',
                'ar' => 'إدارة المواقع'
            ],
            'icon' => 'ki-filled ki-geolocation',
            'permission' => 'manage_locations',
            'children' => [
                [
                    'title' => [
                        'en' => 'Countries',
                        'ar' => 'البلدان'
                    ],
                    'icon' => 'ki-filled ki-flag',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Countries',
                                'ar' => 'جميع البلدان'
                            ],
                            'route' => 'countries.index',
                        ],
                        [
                            'title' => [
                                'en' => 'Add New Country',
                                'ar' => 'إضافة بلد جديد'
                            ],
                            'route' => 'countries.create',
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Cities',
                        'ar' => 'المدن'
                    ],
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Cities',
                                'ar' => 'جميع المدن'
                            ],
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => [
                                'en' => 'Add New City',
                                'ar' => 'إضافة مدينة جديدة'
                            ],
                            'route' => 'cities.create',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Currency Management',
                'ar' => 'إدارة العملات'
            ],
            'icon' => 'ki-filled ki-dollar',
            'permission' => 'manage_currencies',
            'children' => [
                [
                    'title' => [
                        'en' => 'All Currencies',
                        'ar' => 'جميع العملات'
                    ],
                    'icon' => 'ki-filled ki-bill',
                    'route' => 'currencies.index',
                ],
                [
                    'title' => [
                        'en' => 'Add New Currency',
                        'ar' => 'إضافة عملة جديدة'
                    ],
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'currencies.create',
                ],
                [
                    'title' => [
                        'en' => 'Exchange Rates',
                        'ar' => 'أسعار الصرف'
                    ],
                    'icon' => 'ki-filled ki-chart-line',
                    'route' => 'currencies.rates',
                ],
                [
                    'title' => [
                        'en' => 'Update Rates',
                        'ar' => 'تحديث الأسعار'
                    ],
                    'icon' => 'ki-filled ki-arrows-circle',
                    'route' => 'currencies.rates.update',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Profile Management',
                'ar' => 'إدارة الملف الشخصي'
            ],
            'icon' => 'ki-filled ki-profile-circle',
            'children' => [
                [
                    'title' => [
                        'en' => 'View Profile',
                        'ar' => 'عرض الملف الشخصي'
                    ],
                    'icon' => 'ki-filled ki-user',
                    'route' => 'profile.index',
                ],
                [
                    'title' => [
                        'en' => 'Edit Profile',
                        'ar' => 'تعديل الملف الشخصي'
                    ],
                    'icon' => 'ki-filled ki-pencil',
                    'route' => 'profile.edit',
                ],
                [
                    'title' => [
                        'en' => 'Settings',
                        'ar' => 'الإعدادات'
                    ],
                    'icon' => 'ki-filled ki-setting-2',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'General Settings',
                                'ar' => 'إعدادات عامة'
                            ],
                            'route' => 'profile.settings.final',
                        ],
                        [
                            'title' => [
                                'en' => 'Security',
                                'ar' => 'الأمان'
                            ],
                            'route' => 'profile.settings.security',
                        ],
                        [
                            'title' => [
                                'en' => 'Notifications',
                                'ar' => 'الإشعارات'
                            ],
                            'route' => 'profile.settings.notifications',
                        ],
                        [
                            'title' => [
                                'en' => 'Test Page 1',
                                'ar' => 'صفحة تجريبية 1'
                            ],
                            'route' => 'profile.settings.test',
                        ],
                        [
                            'title' => [
                                'en' => 'Test Page 2',
                                'ar' => 'صفحة تجريبية 2'
                            ],
                            'route' => 'profile.settings.new',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Reports & Analytics',
                'ar' => 'التقارير والإحصائيات'
            ],
            'icon' => 'ki-filled ki-chart-simple',
            'permission' => 'view_reports',
            'children' => [
                [
                    'title' => [
                        'en' => 'Reports Dashboard',
                        'ar' => 'لوحة التقارير'
                    ],
                    'icon' => 'ki-filled ki-element-11',
                    'route' => 'reports.index',
                ],
                [
                    'title' => [
                        'en' => 'User Reports',
                        'ar' => 'تقارير المستخدمين'
                    ],
                    'icon' => 'ki-filled ki-people',
                    'route' => 'reports.users',
                ],
                [
                    'title' => [
                        'en' => 'Location Reports',
                        'ar' => 'تقارير المواقع'
                    ],
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => 'reports.locations',
                ],
                [
                    'title' => [
                        'en' => 'Detailed Analytics',
                        'ar' => 'الإحصائيات التفصيلية'
                    ],
                    'icon' => 'ki-filled ki-chart-line-up',
                    'route' => 'reports.analytics',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'System Settings',
                'ar' => 'إعدادات النظام'
            ],
            'icon' => 'ki-filled ki-gear',
            'permission' => 'manage_system',
            'children' => [
                [
                    'title' => [
                        'en' => 'General Settings',
                        'ar' => 'الإعدادات العامة'
                    ],
                    'icon' => 'ki-filled ki-setting-2',
                    'route' => 'settings.general',
                ],
                [
                    'title' => [
                        'en' => 'Security Settings',
                        'ar' => 'إعدادات الأمان'
                    ],
                    'icon' => 'ki-filled ki-shield-tick',
                    'route' => 'settings.security',
                ],
                [
                    'title' => [
                        'en' => 'Notification Settings',
                        'ar' => 'إعدادات الإشعارات'
                    ],
                    'icon' => 'ki-filled ki-notification-bing',
                    'route' => 'settings.notifications',
                ],
                [
                    'title' => [
                        'en' => 'Backup',
                        'ar' => 'النسخ الاحتياطي'
                    ],
                    'icon' => 'ki-filled ki-cloud-download',
                    'route' => 'settings.backup',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Accommodations',
                'ar' => 'الإقامة'
            ],
            'icon' => 'ki-filled ki-home-2',
            'permission' => 'manage_accommodations',
            'children' => [
                [
                    'title' => [
                        'en' => 'Hotels',
                        'ar' => 'الفنادق'
                    ],
                    'icon' => 'ki-filled ki-abstract-26',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Hotels',
                                'ar' => 'جميع الفنادق'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Hotel',
                                'ar' => 'إضافة فندق'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Hotel Categories',
                                'ar' => 'فئات الفنادق'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Resorts',
                        'ar' => 'المنتجعات'
                    ],
                    'icon' => 'ki-filled ki-picture',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Resorts',
                                'ar' => 'جميع المنتجعات'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Resort',
                                'ar' => 'إضافة منتجع'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Resort Facilities',
                                'ar' => 'مرافق المنتجعات'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Tourist Camps',
                        'ar' => 'المخيمات السياحية'
                    ],
                    'icon' => 'ki-filled ki-delivery-geolocation',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Camps',
                                'ar' => 'جميع المخيمات'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Camp',
                                'ar' => 'إضافة مخيم'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Camp Activities',
                                'ar' => 'أنشطة المخيمات'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Hostels',
                        'ar' => 'النزل'
                    ],
                    'icon' => 'ki-filled ki-abstract-14',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Hostels',
                                'ar' => 'جميع النزل'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Hostel',
                                'ar' => 'إضافة نزل'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Hostel Services',
                                'ar' => 'خدمات النزل'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Lodges',
                        'ar' => 'أكواخ'
                    ],
                    'icon' => 'ki-filled ki-abstract-44',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Lodges',
                                'ar' => 'جميع الأكواخ'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Lodge',
                                'ar' => 'إضافة كوخ'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Lodge Features',
                                'ar' => 'مميزات الأكواخ'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Hotel Apartments',
                        'ar' => 'الشقق الفندقية'
                    ],
                    'icon' => 'ki-filled ki-abstract-39',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Apartments',
                                'ar' => 'جميع الشقق'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Apartment',
                                'ar' => 'إضافة شقة'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Apartment Amenities',
                                'ar' => 'مرافق الشقق'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Rooms',
                        'ar' => 'الغرف'
                    ],
                    'icon' => 'ki-filled ki-abstract-33',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Rooms',
                                'ar' => 'جميع الغرف'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Room',
                                'ar' => 'إضافة غرفة'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Room Availability',
                                'ar' => 'توفر الغرف'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Room Types',
                        'ar' => 'أنواع الغرف'
                    ],
                    'icon' => 'ki-filled ki-category',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Room Types',
                                'ar' => 'جميع أنواع الغرف'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Room Type',
                                'ar' => 'إضافة نوع غرفة'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Type Features',
                                'ar' => 'مميزات الأنواع'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Room Names',
                        'ar' => 'أسماء الغرف'
                    ],
                    'icon' => 'ki-filled ki-tag',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'All Room Names',
                                'ar' => 'جميع أسماء الغرف'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Add Room Name',
                                'ar' => 'إضافة اسم غرفة'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                        [
                            'title' => [
                                'en' => 'Name Templates',
                                'ar' => 'قوالب الأسماء'
                            ],
                            'route' => '#', // placeholder until page is created
                        ],
                    ],
                ],
            ],
        ],
    ],
    
    'quick_actions' => [
        'title' => [
            'en' => 'Quick Tools',
            'ar' => 'أدوات سريعة'
        ],
        'items' => [
            [
                'title' => [
                    'en' => 'Update Profile',
                    'ar' => 'تحديث البروفايل'
                ],
                'icon' => 'ki-filled ki-profile-user',
                'route' => 'profile.edit',
            ],
            [
                'title' => [
                    'en' => 'Logout',
                    'ar' => 'تسجيل الخروج'
                ],
                'icon' => 'ki-filled ki-entrance-left',
                'action' => 'logout',
                'class' => 'text-red-600 hover:bg-red-50',
            ],
        ],
    ],
];
