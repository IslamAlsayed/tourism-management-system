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
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard.quote.v1.step1',
        ],
        [
            'title' => 'quotation requests v2',
            'icon' => 'ki-filled ki-element-11',
            'route' => 'dashboard.quote.v2.index',
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
                ]
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
                    'route' => 'currencies.index',
                ],
                [
                    'title' => 'import currency',
                    'icon' => 'ki-filled ki-plus',
                    'route' => 'currencies.import',
                ],
                // [
                //     'title' => 'exchange rates',
                //     'icon' => 'ki-filled ki-chart-line',
                //     'route' => 'currencies.rates'
                // ],
                // [
                //     'title' => 'updated rates',
                //     'icon' => 'ki-filled ki-arrows-circle',
                //     'route' => 'currencies.rates.updated'
                // ],
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
                            'title' => 'import country',
                            'route' => 'countries.import',
                        ],
                    ],
                ],
                [
                    'title' => 'states',
                    'icon' => 'ki-filled ki-flag',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all states',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'import state',
                            'route' => 'states.import',
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
                            'title' => 'import city',
                            'route' => 'cities.import',
                        ],
                    ],
                ],
                [
                    'title' => 'regions',
                    'icon' => 'ki-filled ki-home-2',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'route' => 'regions.index',
                        ],
                        [
                            'title' => 'import region',
                            'route' => 'regions.import',
                        ],
                    ],
                ],
                [
                    'title' => 'subregions',
                    'icon' => 'ki-filled ki-home-2',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all subregions',
                            'route' => 'subregions.index',
                        ],
                        [
                            'title' => 'import subregion',
                            'route' => 'subregions.import',
                        ],
                    ],
                ],
                [
                    'title' => 'nationalities',
                    'icon' => 'ki-filled ki-home-2',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all nationalities',
                            'route' => 'nationalities.index',
                        ],
                        [
                            'title' => 'import nationality',
                            'route' => 'nationalities.import',
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
            'status' => 'new +3',
            'children' => [
                [
                    'title' => 'imports',
                    'icon' => 'ki-filled ki-chart-line-up',
                    'route' => 'accommodations.import',
                ],
                [
                    'title' => 'hotels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hotels']
                ],
                [
                    'title' => 'resorts',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'resorts']
                ],
                [
                    'title' => 'camps',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'camps']
                ],
                [
                    'title' => 'hostels',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'hostels']
                ],
                [
                    'title' => 'lodges',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'lodges']
                ],
                [
                    'title' => 'rooms types',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'rooms-types']
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'accommodations.type',
                    'parameters' => ['type' => 'seasons']
                ]
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour guides',
            'icon' => 'ki-filled ki-coffee',
            'children' => [
                [
                    'title' => 'tour guides',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => '#'
                ],
            ],
        ],

        // ================= Food & Beverage =================
        [
            'title' => 'food & beverage',
            'icon' => 'ki-filled ki-coffee',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'ki-filled ki-home-2',
                    'route' => 'restaurants.index'
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
            'icon' => 'ki-filled ki-geolocation',
            'children' => [
                [
                    'title' => 'clients',
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

        // ================= Tourist Sites =================
        [
            'title' => 'tourist sites',
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

        // ================= Languages =================
        [
            'title' => 'languages management',
            'icon' => 'ki-filled ki-global',
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
                ],
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