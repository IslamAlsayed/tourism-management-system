<?php

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard',
        ],

        // ================= Users =================
        [
            'title' => 'user management',
            'icon' => 'ki-outline ki-users',
            'children' => [
                [
                    'title' => 'all users',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'users.index',
                ],
                [
                    'title' => 'add new user',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'users.create',
                ],
                [
                    'title' => 'active users',
                    'icon' => 'ki-filled ki-check-circle',
                    'route' => 'users.index',
                    'params' => ['status' => 'active'],
                ],
                [
                    'title' => 'inactive users',
                    'icon' => 'ki-filled ki-cross-circle',
                    'route' => 'users.index',
                    'params' => ['status' => 'inactive'],
                ],
            ],
        ],

        // ================= Locations =================
        [
            'title' => 'location management',
            'icon' => 'ki-filled ki-geolocation',
            'children' => [
                [
                    'title' => 'countries',
                    'icon' => 'ki-filled ki-flag',
                    'children' => [
                        [
                            'title' => 'all countries',
                            'route' => 'countries.index'
                        ],
                        [
                            'title' => 'add new country',
                            'route' => 'countries.create'
                        ],
                    ],
                ],
                [
                    'title' => 'cities',
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => 'all cities',
                            'route' => 'cities.index'
                        ],
                        [
                            'title' => 'add new city',
                            'route' => 'cities.create'
                        ],
                    ],
                ],
            ],
        ],

        // ================= Currencies =================
        [
            'title' => 'currency management',
            'icon' => 'ki-filled ki-dollar',
            'children' => [
                [
                    'title' => 'all currencies',
                    'icon' => 'ki-filled ki-bill',
                    'route' => 'currencies.index'
                ],
                [
                    'title' => 'add new currency',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'currencies.create'
                ],
                // [
                //     'title' => 'exchange rates',
                //     'icon' => 'ki-filled ki-chart-line',
                //     'route' => 'currencies.rates'
                // ],
                // [
                //     'title' => 'update rates',
                //     'icon' => 'ki-filled ki-arrows-circle',
                //     'route' => 'currencies.rates.update'
                // ],
            ],
        ],

        // ================= Reports =================
        [
            'title' => 'reports & analytics',
            'icon' => 'ki-filled ki-chart-simple',
            'children' => [
                [
                    'title' => 'reports dashboard',
                    'icon' => 'ki-filled ki-element-11',
                    'route' => 'reports.index'
                ],
                [
                    'title' => 'user reports',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'reports.users'
                ],
                [
                    'title' => 'location reports',
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => 'reports.locations'
                ],
                [
                    'title' => 'detailed analytics',
                    'icon' => 'ki-filled ki-chart-line-up',
                    'route' => 'reports.analytics'
                ],
            ],
        ],

        // ================= Accommodations =================
        [
            'title' => 'accommodations',
            'icon' => 'ki-filled ki-home-2',
            'children' => [
                [
                    'title' => 'hotels',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all hotels',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add hotel',
                            'route' => '#'
                        ],
                        [
                            'title' => 'hotel categories',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'resorts',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all resorts',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add resort',
                            'route' => '#'
                        ],
                        [
                            'title' => 'resort facilities',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'tourist camps',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all camps',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add camp',
                            'route' => '#'
                        ],
                        [
                            'title' => 'camp activities',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'hostels',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all hostels',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add hostel',
                            'route' => '#'
                        ],
                        [
                            'title' => 'hostel services',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'lodges',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all lodges',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add lodge',
                            'route' => '#'
                        ],
                        [
                            'title' => 'lodge features',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'hotel apartments',
                    'icon' => 'ki-duotone ki-cheque',
                    'children' => [
                        [
                            'title' => 'all apartments',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add apartment',
                            'route' => '#'
                        ],
                        [
                            'title' => 'apartment amenities',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'rooms',
                    'icon' => 'ki-filled ki-abstract-33',
                    'children' => [
                        [
                            'title' => 'all rooms',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add room',
                            'route' => '#'
                        ],
                        [
                            'title' => 'room availability',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'room types',
                    'icon' => 'ki-filled ki-category',
                    'children' => [
                        [
                            'title' => 'all room types',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add room type',
                            'route' => '#'
                        ],
                        [
                            'title' => 'type features',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'room names',
                    'icon' => 'ki-filled ki-tag',
                    'children' => [
                        [
                            'title' => 'all room names',
                            'route' => '#'
                        ],
                        [
                            'title' => 'add room name',
                            'route' => '#'
                        ],
                        [
                            'title' => 'name templates',
                            'route' => '#'
                        ],
                    ],
                ],
            ],
        ],

        // ================= Food & Beverage =================
        [
            'title' => 'food & beverage',
            'icon' => 'ki-filled ki-coffee',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Transportation =================
        [
            'title' => 'transportation',
            'icon' => 'ki-filled ki-delivery',
            'children' => [
                [
                    'title' => 'tourist transport companies',
                    'icon' => 'ki-filled ki-bus',
                    'route' => '#'
                ],
                [
                    'title' => 'car rental',
                    'icon' => 'ki-filled ki-car',
                    'route' => '#'
                ],
                [
                    'title' => 'limousine transfers',
                    'icon' => 'ki-filled ki-delivery-2',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Air Transport =================
        [
            'title' => 'air transport',
            'icon' => 'ki-filled ki-airplane',
            'children' => [
                [
                    'title' => 'airports',
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#'
                ],
                [
                    'title' => 'airlines',
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Vehicles =================
        [
            'title' => 'vehicles',
            'icon' => 'ki-filled ki-car',
            'children' => [
                [
                    'title' => 'tourist buses',
                    'icon' => 'ki-filled ki-bus',
                    'route' => '#'
                ],
                [
                    'title' => 'transport vehicles',
                    'icon' => 'ki-filled ki-delivery',
                    'route' => '#'
                ],
                [
                    'title' => 'tourist transport companies',
                    'icon' => 'ki-filled ki-category',
                    'route' => '#'
                ],
                [
                    'title' => '4x4 vehicles',
                    'icon' => 'ki-filled ki-car',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Tourist Sites =================
        [
            'title' => 'Tourist sites',
            'icon' => 'ki-filled ki-geolocation',
            'children' => [
                [
                    'title' => 'tourist sites',
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => '#'
                ],
                [
                    'title' => 'site entrance fees',
                    'icon' => 'ki-filled ki-dollar',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Crossings & Ports =================
        [
            'title' => 'crossings & ports',
            'icon' => 'ki-filled ki-pointers',
            'children' => [
                [
                    'title' => 'land crossings',
                    'icon' => 'ki-filled ki-pointers',
                    'route' => '#'
                ],
                [
                    'title' => 'airports',
                    'icon' => 'ki-filled ki-airplane-square',
                    'children' => [
                        [
                            'title' => 'international airports',
                            'icon' => 'ki-solid ki-airplane-square',
                            'route' => '#'
                        ],
                        [
                            'title' => 'domestic airports',
                            'icon' => 'ki-duotone ki-airplane',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'seaports',
                    'icon' => 'ki-filled ki-ship',
                    'route' => '#'
                ],
            ],
        ],


        // ================= Profile =================
        [
            'title' => 'profile management',
            'icon' => 'ki-filled ki-profile-circle',
            'children' => [
                [
                    'title' => 'view profile',
                    'icon' => 'ki-filled ki-user',
                    'route' => 'profile.index'
                ],
                [
                    'title' => 'edit profile',
                    'icon' => 'ki-filled ki-pencil',
                    'route' => 'profile.edit'
                ],
                [
                    'title' => 'change password',
                    'icon' => 'ki-filled ki-lock',
                    'route' => '#'
                ], // #
            ],
        ],

        // ================= Settings =================
        [
            'title' => 'settings',
            'icon' => 'ki-filled ki-setting-2',
            'children' => [
                [
                    'title' => 'general settings',
                    'route' => 'settings.general'
                ],
                [
                    'title' => 'security',
                    'route' => 'settings.security'
                ],
                [
                    'title' => 'notifications',
                    'route' => 'settings.notifications'
                ],
                [
                    'title' => 'backup',
                    'icon' => 'ki-filled ki-cloud-download',
                    'route' => 'settings.backup'
                ],
            ],
        ],
    ],
];