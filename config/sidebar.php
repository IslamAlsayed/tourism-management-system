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
    // ...existing code...
    // ...existing code...
    // ...existing code...
        [
            'title' => [
                'en' => 'User Management',
                'ar' => 'إدارة المستخدمين'
            ],
            'icon' => 'ki-outline ki-users',
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
                    'icon' => 'ki-solid ki-setting-3',
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
            'icon' => 'ki-filled ki-setting-2',
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
                    'icon' => 'ki-duotone ki-cheque',
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
                    'icon' => 'ki-duotone ki-cheque',
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
                    'icon' => 'ki-duotone ki-cheque',
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
                    'icon' => 'ki-duotone ki-cheque',
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
                    'icon' => 'ki-duotone ki-cheque',
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
                    'icon' => 'ki-duotone ki-cheque',
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
        [
            'title' => [
                'en' => 'Food & Beverage',
                'ar' => 'الطعام والشراب'
            ],
            'icon' => 'ki-filled ki-coffee',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Restaurants',
                        'ar' => 'المطاعم'
                    ],
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Transportation',
                'ar' => 'النقل'
            ],
            'icon' => 'ki-filled ki-delivery',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Tourist Transport Companies',
                        'ar' => 'شركات النقل السياحي'
                    ],
                    'icon' => 'ki-filled ki-bus',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Car Rental',
                        'ar' => 'تأجير السيارات'
                    ],
                    'icon' => 'ki-filled ki-car',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Limousine Transfers',
                        'ar' => 'نقل الليموزين'
                    ],
                    'icon' => 'ki-filled ki-delivery-2',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Air Transport',
                'ar' => 'النقل الجوي'
            ],
            'icon' => 'ki-filled ki-airplane',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Airports',
                        'ar' => 'المطارات'
                    ],
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#',
                ],
                [
                    'title' => [
                        'en' => 'Airlines',
                        'ar' => 'شركات الطيران'
                    ],
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Vehicles',
                'ar' => 'المركبات'
            ],
            'icon' => 'ki-filled ki-car',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Tourist Buses',
                        'ar' => 'الحافلات السياحية'
                    ],
                    'icon' => 'ki-filled ki-bus',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Transport Vehicles',
                        'ar' => 'مركبات النقل'
                    ],
                    'icon' => 'ki-filled ki-delivery',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Tourist Transport Companies',
                        'ar' => 'شركات النقل السياحي'
                    ],
                    'icon' => 'ki-filled ki-category',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => '4x4 Vehicles',
                        'ar' => 'سيارات الدفع الرباعي'
                    ],
                    'icon' => 'ki-filled ki-car',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Tourist Sites',
                'ar' => 'المواقع السياحية'
            ],
            'icon' => 'ki-filled ki-geolocation',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Sites',
                        'ar' => 'المواقع'
                    ],
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Site Entrance Fees',
                        'ar' => 'رسوم دخول المواقع'
                    ],
                    'icon' => 'ki-filled ki-dollar',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Crossings & Ports',
                'ar' => 'المعابر والمنافذ'
            ],
            'icon' => 'ki-filled ki-pointers',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Land Crossings',
                        'ar' => 'المعابر البرية'
                    ],
                    'icon' => 'ki-filled ki-pointers',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Airports',
                        'ar' => 'المطارات'
                    ],
                    'icon' => 'ki-filled ki-airplane-square',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'International Airports',
                                'ar' => 'المطارات الدولية'
                            ],
                            'icon' => 'ki-solid ki-airplane-square',
                            'route' => 'placeholder',
                        ],
                        [
                            'title' => [
                                'en' => 'Domestic Airports',
                                'ar' => 'المطارات المحلية'
                            ],
                            'icon' => 'ki-duotone ki-airplane',
                            'route' => 'placeholder',
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Seaports',
                        'ar' => 'الموانئ البحرية'
                    ],
                    'icon' => 'ki-filled ki-ship',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Train Stations',
                        'ar' => 'محطات القطار'
                    ],
                    'icon' => 'ki-filled ki-train',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Nationalities',
                'ar' => 'الجنسيات'
            ],
            'icon' => 'ki-filled ki-flag',
            'route' => 'placeholder',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'Suppliers & Providers',
                'ar' => 'الموردين والمزودين'
            ],
            'icon' => 'ki-filled ki-courier',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Agents',
                        'ar' => 'الوكلاء'
                    ],
                    'icon' => 'ki-filled ki-user-square',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Suppliers',
                        'ar' => 'الموردين'
                    ],
                    'icon' => 'ki-duotone ki-profile-circle',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Providers',
                        'ar' => 'المزودين'
                    ],
                    'icon' => 'ki-duotone ki-user-square',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Airlines',
                        'ar' => 'شركات الطيران'
                    ],
                    'icon' => 'ki-filled ki-airplane-square',
                    'children' => [
                        [
                            'title' => [
                                'en' => 'Types of Airlines',
                                'ar' => 'أنواع شركات الطيران'
                            ],
                            'icon' => 'ki-filled ki-category',
                            'route' => 'placeholder',
                        ],
                    ],
                ],
                [
                    'title' => [
                        'en' => 'Customers',
                        'ar' => 'العملاء'
                    ],
                    'icon' => 'ki-filled ki-people',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Currencies & Finance',
                'ar' => 'العملات والمالية'
            ],
            'icon' => 'ki-filled ki-dollar',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Currencies',
                        'ar' => 'العملات'
                    ],
                    'icon' => 'ki-filled ki-bank',
                    'route' => 'currencies.index',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Activities',
                'ar' => 'الأنشطة'
            ],
            'icon' => 'ki-filled ki-price-tag',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'General Activities',
                        'ar' => 'الأنشطة العامة'
                    ],
                    'icon' => 'ki-filled ki-game',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Desert Activities',
                        'ar' => 'أنشطة الصحراء'
                    ],
                    'icon' => 'ki-filled ki-sun',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Cultural Activities',
                        'ar' => 'الأنشطة الثقافية'
                    ],
                    'icon' => 'ki-filled ki-book',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Marine Activities',
                'ar' => 'الأنشطة البحرية'
            ],
            'icon' => 'ki-solid ki-paper-plane',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Water Sports',
                        'ar' => 'الرياضات المائية'
                    ],
                    'icon' => 'ki-filled ki-abstract-26',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Diving',
                        'ar' => 'الغوص'
                    ],
                    'icon' => 'ki-filled ki-arrow-down',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Swimming',
                        'ar' => 'السباحة'
                    ],
                    'icon' => 'ki-filled ki-swimmer',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Boats & Cruises',
                'ar' => 'القوارب والبواخر'
            ],
            'icon' => 'ki-filled ki-ship',
            'route' => 'placeholder',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'Entrance Fees',
                'ar' => 'رسوم الدخول'
            ],
            'icon' => 'ki-filled ki-entrance-right',
            'route' => 'placeholder',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'Services',
                'ar' => 'الخدمات'
            ],
            'icon' => 'ki-filled ki-setting-3',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Group Services',
                        'ar' => 'الخدمات الجماعية'
                    ],
                    'icon' => 'ki-filled ki-people',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Individual Services',
                        'ar' => 'الخدمات الفردية'
                    ],
                    'icon' => 'ki-filled ki-user',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Visa & Regulations',
                'ar' => 'التأشيرات والتنظيم'
            ],
            'icon' => 'ki-filled ki-document',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Visa Types',
                        'ar' => 'أنواع التأشيرات'
                    ],
                    'icon' => 'ki-filled ki-category',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Visa Requirements',
                        'ar' => 'متطلبات التأشيرة'
                    ],
                    'icon' => 'ki-filled ki-questionnaire-tablet',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Taxes',
                'ar' => 'الضرائب'
            ],
            'icon' => 'ki-filled ki-percentage',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'City Tax',
                        'ar' => 'ضريبة المدينة'
                    ],
                    'icon' => 'ki-filled ki-city',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Service Tax',
                        'ar' => 'ضريبة الخدمة'
                    ],
                    'icon' => 'ki-filled ki-setting-3',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Sales Tax',
                        'ar' => 'ضريبة المبيعات'
                    ],
                    'icon' => 'ki-filled ki-chart-pie-simple',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'APIs',
                'ar' => 'واجهات API'
            ],
            'icon' => 'ki-duotone ki-disconnect',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'WhatsApp API',
                        'ar' => 'واتساب API'
                    ],
                    'icon' => 'ki-filled ki-whatsapp',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Payment APIs',
                        'ar' => 'واجهات الدفع'
                    ],
                    'icon' => 'ki-duotone ki-two-credit-cart',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Maps APIs',
                        'ar' => 'واجهات الخرائط'
                    ],
                    'icon' => 'ki-duotone ki-map',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Quotation System',
                'ar' => 'نظام التسعير'
            ],
            'icon' => 'ki-filled ki-delivery-2',
            'route' => 'placeholder',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'Seasons',
                'ar' => 'المواسم'
            ],
            'icon' => 'ki-filled ki-calendar-remove',
            'permission' => null,
            'children' => [
                [
                    'title' => [
                        'en' => 'Off Season',
                        'ar' => 'موسم خامد'
                    ],
                    'icon' => 'ki-filled ki-calendar-remove',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Low Season',
                        'ar' => 'موسم منخفض'
                    ],
                    'icon' => 'ki-filled ki-calendar-remove',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Moderate Season',
                        'ar' => 'موسم معتدل'
                    ],
                    'icon' => 'ki-filled ki-calendar-remove',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'High Season',
                        'ar' => 'موسم عالي'
                    ],
                    'icon' => 'ki-filled ki-calendar-remove',
                    'route' => 'placeholder',
                ],
                [
                    'title' => [
                        'en' => 'Peak Season',
                        'ar' => 'موسم الذروة'
                    ],
                    'icon' => 'ki-filled ki-calendar-remove',
                    'route' => 'placeholder',
                ],
            ],
        ],
        [
            'title' => [
                'en' => 'Building Tourist Programs',
                'ar' => 'بناء البرامج السياحية'
            ],
            'icon' => 'ki-filled ki-design-frame',
            'route' => 'placeholder',
            'permission' => null,
        ],
        [
            'title' => [
                'en' => 'System Administration',
                'ar' => 'إدارة النظام'
            ],
            'icon' => 'ki-filled ki-setting-4',
            'permission' => 'admin',
            'children' => [
                [
                    'title' => [
                        'en' => 'Sidebar Manager',
                        'ar' => 'إدارة القائمة الجانبية'
                    ],
                    'icon' => 'ki-filled ki-design-frame',
                    'route' => 'admin.sidebar.index',
                ],
                [
                    'title' => [
                        'en' => 'System Settings',
                        'ar' => 'إعدادات النظام'
                    ],
                    'icon' => 'ki-filled ki-gear',
                    'route' => 'settings.index',
                ],
                [
                    'title' => [
                        'en' => 'Cache Management',
                        'ar' => 'إدارة التخزين المؤقت'
                    ],
                    'icon' => 'ki-filled ki-archive',
                    'route' => 'placeholder',
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
                'icon' => 'ki-duotone ki-user-edit',
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
