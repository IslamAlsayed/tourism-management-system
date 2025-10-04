<?php

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard',
        ],
        [
            'title' => 'quotation requests v1',
            'fixed' => false,
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard.quote.v1.step1',
        ],
        [
            'title' => 'quotation requests v2',
            'fixed' => false,
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard.quote.v2.index',
        ],

        // ================= Users =================
        [
            'title' => 'user management',
            'icon' => 'ki-outline ki-users',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'all users',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'users.index',
                ],
                [
                    'title' => 'create user',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'users.create',
                ],
                [
                    'title' => 'import users',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'users'],
                ]
            ],
        ],

        // ================= Currencies =================
        [
            'title' => 'currency management',
            'icon' => 'ki-filled ki-dollar',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'all currencies',
                    'icon' => 'ki-filled ki-bill',
                    'route' => 'currencies.index',
                ],
                [
                    'title' => 'create currency',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'currencies.create',
                ],
                [
                    'title' => 'import currencies',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'currencies'],
                ],
            ],
        ],

        // ================= Locations =================
        [
            'title' => 'location management',
            'icon' => 'ki-filled ki-geolocation',
            'status' => 'done',
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
                            'title' => 'create country',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'countries.create',
                        ],
                        [
                            'title' => 'import countries',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'countries'],
                        ],
                    ],
                ],
                [
                    'title' => 'states',
                    'icon' => 'ki-filled ki-flag',
                    'children' => [
                        [
                            'title' => 'all states',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'create state',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'states.create',
                        ],
                        [
                            'title' => 'import states',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'states'],
                        ],
                    ],
                ],
                [
                    'title' => 'cities',
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => 'all cities',
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => 'create city',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'cities.create',
                        ],
                        [
                            'title' => 'import cities',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'cities'],
                        ],
                    ],
                ],
                [
                    'title' => 'regions',
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'route' => 'regions.index',
                        ],
                        [
                            'title' => 'create region',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'regions.create',
                        ],
                        [
                            'title' => 'import regions',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'regions'],
                        ],
                    ],
                ],
                [
                    'title' => 'subregions',
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => 'all subregions',
                            'route' => 'subregions.index',
                        ],
                        [
                            'title' => 'create subregion',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'subregions.create',
                        ],
                        [
                            'title' => 'import subregions',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'subregions'],
                        ],
                    ],
                ],
                [
                    'title' => 'nationalities',
                    'icon' => 'ki-filled ki-home-2',
                    'children' => [
                        [
                            'title' => 'all nationalities',
                            'route' => 'nationalities.index',
                        ],
                        [
                            'title' => 'create nationality',
                            'icon' => 'ki-filled ki-people',
                            'route' => 'nationalities.create',
                        ],
                        [
                            'title' => 'import nationalities',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'nationalities'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Reports =================
        [
            'title' => 'reports & analytics',
            'icon' => 'ki-filled ki-chart-simple',
            'status' => 'done',
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
            'status' => 'updating...',
            'children' => [
                [
                    'title' => 'imports',
                    'icon' => 'ki-filled ki-chart-line-up',
                    'status' => 'updating...',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'accommodations'],
                ],
                [
                    'title' => 'hotels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hotel'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'resorts',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'resort'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'campings',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'camping'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'hostels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hostel'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'lodges',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'lodge'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'rooms types',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'rooms-types'],
                    'status' => 'updating...',
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'season'],
                    'status' => 'updating...',
                ]
            ],
        ],

        // ================= Food & Beverage =================
        [
            'title' => 'food & beverage',
            'icon' => 'ki-filled ki-coffee',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'all restaurants',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'restaurants.index'
                ],
                [
                    'title' => 'import restaurants',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'restaurants'],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour guides',
            'status' => 'done',
            'icon' => 'ki-filled ki-coffee',
            'children' => [
                [
                    'title' => 'tour guides',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'tour-guides.index'
                ],
                [
                    'title' => 'guides types',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'tour-guides-types.index'
                ],
                [
                    'title' => 'guides reviews',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'tour-guides-reviews.index'
                ],
            ],
        ],

        // ================= Transportation =================
        [
            'title' => 'transportation',
            'fixed' => '+2',
            'icon' => 'ki-filled ki-delivery',
            'children' => [
                [
                    'title' => 'companies',
                    'icon' => 'ki-filled ki-bus',
                    'status' => 'done',
                    'route' => 'transportation-companies.index'
                ],
                [
                    'title' => 'departments',
                    'icon' => 'ki-filled ki-bus',
                    'status' => 'done',
                    'route' => 'transportation-departments.index'
                ],
                [
                    'title' => 'car rental',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-car',
                    'route' => '#'
                ],
                [
                    'title' => 'limousine transfers',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-delivery-2',
                    'route' => '#'
                ],
                [
                    'title' => 'vehicles',
                    'icon' => 'ki-filled ki-car',
                    'status' => 'done',
                    'children' => [
                        [
                            'title' => 'bus types',
                            'icon' => 'ki-filled ki-bus',
                            'status' => 'done',
                            'route' => 'transportation-bus-types.index'
                        ],
                        [
                            'title' => 'company bus types',
                            'icon' => 'ki-filled ki-bus',
                            'status' => 'done',
                            'route' => 'transportation-company-bus-types.index'
                        ],
                        [
                            'title' => '4x4 vehicles',
                            'icon' => 'ki-filled ki-car',
                            'route' => 'transportation-vehicles.index'
                        ],
                    ],
                ],
            ],
        ],

        // ================= Air Transport =================
        [
            'title' => 'air transport',
            'fixed' => '+2',
            'icon' => 'ki-filled ki-airplane',
            'children' => [
                [
                    'title' => 'airports',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#'
                ],
                [
                    'title' => 'airlines',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-airplane',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Vehicles =================
        // [
        //     'title' => 'vehicles',
        //     'icon' => 'ki-filled ki-car',
        //     'children' => [
        //         [
        //             'title' => 'tourist buses',
        //             'icon' => 'ki-filled ki-bus',
        //             'route' => '#'
        //         ],
        //         [
        //             'title' => 'transport vehicles',
        //             'icon' => 'ki-filled ki-delivery',
        //             'route' => '#'
        //         ],
        //         [
        //             'title' => 'tourist transport companies',
        //             'icon' => 'ki-filled ki-category',
        //             'route' => '#'
        //         ],
        //         [
        //             'title' => '4x4 vehicles',
        //             'icon' => 'ki-filled ki-car',
        //             'route' => '#'
        //         ],
        //     ],
        // ],

        // ================= Tourist Sites =================
        [
            'title' => 'clients',
            'fixed' => '+2',
            'icon' => 'ki-filled ki-geolocation',
            'children' => [
                [
                    'title' => 'clients',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => '#'
                ],
                [
                    'title' => 'site entrance fees',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-dollar',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Tourist Sites =================
        [
            'title' => 'tourist sites',
            'fixed' => '+2',
            'icon' => 'ki-filled ki-geolocation',
            'children' => [
                [
                    'title' => 'tourist sites',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-geolocation',
                    'route' => '#'
                ],
                [
                    'title' => 'site entrance fees',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-dollar',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Crossings & Ports =================
        [
            'title' => 'crossings & ports',
            'fixed' => '+4',
            'icon' => 'ki-filled ki-pointers',
            'children' => [
                [
                    'title' => 'land crossings',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-pointers',
                    'route' => '#'
                ],
                [
                    'title' => 'airports',
                    'fixed' => '+2',
                    'icon' => 'ki-filled ki-airplane-square',
                    'children' => [
                        [
                            'title' => 'international airports',
                            'fixed' => false,
                            'icon' => 'ki-solid ki-airplane-square',
                            'route' => '#'
                        ],
                        [
                            'title' => 'domestic airports',
                            'fixed' => false,
                            'icon' => 'ki-duotone ki-airplane',
                            'route' => '#'
                        ],
                    ],
                ],
                [
                    'title' => 'seaports',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-ship',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Languages =================
        [
            'title' => 'languages management',
            'icon' => 'fas fa-globe',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'view_languages',
                    'icon' => 'ki-filled ki-global',
                    'route' => 'languages.index'
                ],
                [
                    'title' => 'create_language',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'languages.create'
                ]
            ],
        ],

        // ================= Profile =================
        [
            'title' => 'profile management',
            'icon' => 'ki-filled ki-profile-circle',
            'status' => 'done',
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
                    'route' => 'profile.change_password'
                ],
            ],
        ],

        // ================= Settings =================
        [
            'title' => 'settings',
            'icon' => 'ki-filled ki-setting-2',
            'status' => 'done',
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