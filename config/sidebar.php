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
            'status' => 'new +2',
            'children' => [
                [
                    'title' => 'all users',
                    'icon' => 'ki-filled ki-people',
                    'route' => 'users.index',
                ],
                [
                    'title' => 'add new user',
                    'icon' => 'ki-filled ki-people',
                    'status' => 'new',
                    'route' => 'users.create',
                ],
                [
                    'title' => 'import users',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'import.data',
                    'status' => 'new',
                    'parameters' => ['model' => 'users'],
                ]
            ],
        ],

        // ================= Currencies =================
        [
            'title' => 'currency management',
            'icon' => 'ki-filled ki-dollar',
            'status' => 'new +1',
            'children' => [
                [
                    'title' => 'all currencies',
                    'icon' => 'ki-filled ki-bill',
                    'route' => 'currencies.index',
                ],
                [
                    'title' => 'add new currency',
                    'icon' => 'ki-filled ki-people',
                    'status' => 'new',
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
            'status' => 'updated +1',
            'children' => [
                [
                    'title' => 'countries',
                    'icon' => 'ki-filled ki-flag',
                    'status' => 'new +1',
                    'children' => [
                        [
                            'title' => 'all countries',
                            'route' => 'countries.index'
                        ],
                        [
                            'title' => 'add new country',
                            'icon' => 'ki-filled ki-people',
                            'status' => 'new',
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
                    'status' => 'new +1',
                    'children' => [
                        [
                            'title' => 'all states',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'add new state',
                            'icon' => 'ki-filled ki-people',
                            'status' => 'new',
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
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all cities',
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => 'import cities',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'cities'],
                            'status' => 'updated',
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
            'status' => 'updated +7',
            'children' => [
                [
                    'title' => 'imports',
                    'icon' => 'ki-filled ki-chart-line-up',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'accommodations'],
                ],
                [
                    'title' => 'hotels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hotel'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'resorts',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'resort'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'campings',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'camping'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'hostels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hostel'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'lodges',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'lodge'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'rooms types',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'rooms-types'],
                    'status' => 'updated',
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'season'],
                    'status' => 'updated',
                ]
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour guides',
            'fixed' => '+1',
            'icon' => 'ki-filled ki-coffee',
            'children' => [
                [
                    'title' => 'tour guides',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-home-2',
                    'route' => '#'
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

        // ================= Transportation =================
        [
            'title' => 'transportation',
            'fixed' => '+7',
            'icon' => 'ki-filled ki-delivery',
            'children' => [
                [
                    'title' => 'tourist transport companies',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-bus',
                    'route' => '#'
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
                    'fixed' => '+4',
                    'icon' => 'ki-filled ki-car',
                    'children' => [
                        [
                            'title' => 'tourist buses',
                            'fixed' => false,
                            'icon' => 'ki-filled ki-bus',
                            'route' => '#'
                        ],
                        [
                            'title' => 'transport vehicles',
                            'fixed' => false,
                            'icon' => 'ki-filled ki-delivery',
                            'route' => '#'
                        ],
                        [
                            'title' => 'tourist transport companies',
                            'fixed' => false,
                            'icon' => 'ki-filled ki-category',
                            'route' => '#'
                        ],
                        [
                            'title' => '4x4 vehicles',
                            'fixed' => false,
                            'icon' => 'ki-filled ki-car',
                            'route' => '#'
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
            'fixed' => '+2',
            'icon' => 'ki-filled ki-global',
            'children' => [
                [
                    'title' => 'view_languages',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-global',
                    'route' => 'languages.index'
                ],
                [
                    'title' => 'create_language',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'languages.create'
                ]
            ],
        ],

        // ================= Profile =================
        [
            'title' => 'profile management',
            'fixed' => '+1',
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
                    'fixed' => false,
                    'icon' => 'ki-filled ki-lock',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Settings =================
        [
            'title' => 'settings',
            'fixed' => '+4',
            'icon' => 'ki-filled ki-setting-2',
            'children' => [
                [
                    'title' => 'general settings',
                    'fixed' => false,
                    'route' => 'settings.general'
                ],
                [
                    'title' => 'security',
                    'fixed' => false,
                    'route' => 'settings.security'
                ],
                [
                    'title' => 'notifications',
                    'fixed' => false,
                    'route' => 'settings.notifications'
                ],
                [
                    'title' => 'backup',
                    'fixed' => false,
                    'icon' => 'ki-filled ki-cloud-download',
                    'route' => 'settings.backup'
                ],
            ],
        ],
    ],
];