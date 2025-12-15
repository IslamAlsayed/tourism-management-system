<?php

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'fa-solid fa-gauge',
            'route' => 'dashboard',
        ],
        // [
        //     'title' => 'quotation requests v1',
        //     'fixed' => false,
        //     'icon' => 'ki-filled ki-element-11',
        //     'route' => 'dashboard.quote.v1.step1',
        // ],
        // [
        //     'title' => 'quotation requests v2',
        //     'fixed' => false,
        //     'icon' => 'ki-filled ki-element-11',
        //     'route' => 'dashboard.quote.v2.index',
        // ],

        // ================= Users =================
        [
            'title' => 'user management',
            'icon' => 'fa-solid fa-users-gear',
            'children' => [
                [
                    'title' => 'all users',
                    'icon' => 'fa-solid fa-users',
                    'route' => 'users.index',
                ],
                [
                    'title' => 'create user',
                    'icon' => 'fa-solid fa-user-plus',
                    'route' => 'users.create',
                ],
                [
                    'title' => 'import users',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'users'],
                ]
            ],
        ],

        // ================= Clients =================
        [
            'title' => 'client management',
            'icon' => 'fa-solid fa-user-group',
            'children' => [
                [
                    'title' => 'all clients',
                    'icon' => 'fa-solid fa-user-group',
                    'route' => 'clients.index',
                ],
                [
                    'title' => 'create client',
                    'icon' => 'fa-solid fa-user-plus',
                    'route' => 'clients.create',
                ],
                [
                    'title' => 'import clients',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'clients'],
                ]
            ],
        ],

        // ================= Currencies =================
        [
            'title' => 'currency management',
            'icon' => 'fa-solid fa-dollar-sign',
            'children' => [
                [
                    'title' => 'all currencies',
                    'icon' => 'fa-solid fa-coins',
                    'route' => 'currencies.index',
                ],
                [
                    'title' => 'create currency',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'currencies.create',
                ],
                [
                    'title' => 'import currencies',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'currencies'],
                ],
            ],
        ],

        // ================= Locations =================
        [
            'title' => 'location management',
            'icon' => 'fa-solid fa-location-dot',
            'children' => [
                [
                    'title' => 'regions',
                    'icon' => 'fa-solid fa-map',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'route' => 'regions.index',
                        ],
                        [
                            'title' => 'create region',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'regions.create',
                        ],
                        [
                            'title' => 'import regions',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'regions'],
                        ],
                    ],
                ],
                [
                    'title' => 'subregions',
                    'icon' => 'fa-solid fa-map',
                    'children' => [
                        [
                            'title' => 'all subregions',
                            'route' => 'subregions.index',
                        ],
                        [
                            'title' => 'create subregion',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'subregions.create',
                        ],
                        [
                            'title' => 'import subregions',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'subregions'],
                        ],
                    ],
                ],
                [
                    'title' => 'countries',
                    'icon' => 'fa-solid fa-flag',
                    'children' => [
                        [
                            'title' => 'all countries',
                            'route' => 'countries.index'
                        ],
                        [
                            'title' => 'create country',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'countries.create',
                        ],
                        [
                            'title' => 'import countries',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'countries'],
                        ],
                    ],
                ],
                [
                    'title' => 'states',
                    'icon' => 'fa-solid fa-flag',
                    'children' => [
                        [
                            'title' => 'all states',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'create state',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'states.create',
                        ],
                        [
                            'title' => 'import states',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'states'],
                        ],
                    ],
                ],
                [
                    'title' => 'cities',
                    'icon' => 'fa-solid fa-city',
                    'children' => [
                        [
                            'title' => 'all cities',
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => 'create city',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'cities.create',
                        ],
                        [
                            'title' => 'import cities',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'cities'],
                        ],
                    ],
                ],

                [
                    'title' => 'nationalities',
                    'icon' => 'fa-solid fa-id-card',
                    'children' => [
                        [
                            'title' => 'all nationalities',
                            'route' => 'nationalities.index',
                        ],
                        [
                            'title' => 'create nationality',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'nationalities.create',
                        ],
                        [
                            'title' => 'import nationalities',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'nationalities'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Accommodations =================
        [
            'title' => 'accommodations',
            'icon' => 'fa-solid fa-hotel',
            'children' => [
                [
                    'title' => 'all accommodations',
                    'icon' => 'fa-solid fa-list-ul',
                    'route' => 'accommodations.index',
                ],
                [
                    'title' => 'create accommodation',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'accommodations.create',
                ],
                [
                    'title' => 'import accommodations',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'accommodations'],
                ],
                [
                    'title' => 'types',
                    'icon' => 'fa-solid fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all types',
                            'icon' => 'fa-solid fa-list-ul',
                            'route' => 'types.index',
                        ],
                        [
                            'title' => 'create type',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'types.create',
                        ],
                        [
                            'title' => 'import types',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'types'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fa-solid fa-calendar-days',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fa-solid fa-calendar-check',
                            'route' => 'seasons.index',
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-solid fa-calendar-plus',
                            'route' => 'seasons.create',
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'seasons'],
                        ],
                    ],
                ],
                [
                    'title' => 'rooms',
                    'icon' => 'fa-solid fa-door-closed',
                    'children' => [
                        [
                            'title' => 'all rooms',
                            'icon' => 'fa-solid fa-door-closed',
                            'route' => 'rooms.index',
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'rooms.create',
                        ],
                        [
                            'title' => 'import rooms',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'rooms'],
                        ],
                    ],
                ],
                [
                    'title' => 'meals',
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fa-solid fa-bowl-food',
                            'route' => 'meals.index',
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'meals.create',
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'meals'],
                        ],
                    ],
                ],
                [
                    'title' => 'rates',
                    'icon' => 'fa-solid fa-dollar-sign',
                    'children' => [
                        [
                            'title' => 'all rates',
                            'icon' => 'fa-solid fa-chart-line',
                            'route' => 'accommodations-rates.index',
                        ],
                        [
                            'title' => 'create room rate',
                            'icon' => 'fa-solid fa-bed',
                            'route' => 'accommodations-rates.create-room',
                        ],
                        [
                            'title' => 'create meal rate',
                            'icon' => 'fa-solid fa-utensils',
                            'route' => 'accommodations-rates.create-meal',
                        ],
                        [
                            'title' => 'import rates',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'accommodations-rates'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-solid fa-bowl-food',
                            'route' => 'accommodations-supplements.index',
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'accommodations-supplements.create',
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'supplements'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Food & Beverage =================
        [
            'title' => 'food & beverage',
            'icon' => 'fa-solid fa-mug-hot',
            'children' => [
                [
                    'title' => 'all restaurants',
                    'icon' => 'fa-solid fa-burger',
                    'route' => 'restaurants.index'
                ],
                [
                    'title' => 'create restaurant',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'restaurants.create'
                ],
                [
                    'title' => 'import restaurants',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'restaurants'],
                ],
                [
                    'title' => 'meals',
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fa-solid fa-bowl-food',
                            'route' => '#',
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => '#',
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => '#',
                            'parameters' => ['models' => 'meals'],
                        ],
                    ],
                ],
                [
                    'title' => 'meals rates',
                    'icon' => 'fa-solid fa-dollar-sign',
                    'children' => [
                        [
                            'title' => 'all meals rates',
                            'icon' => 'fa-solid fa-chart-line',
                            'route' => '#',
                        ],
                        [
                            'title' => 'create meal rate',
                            'icon' => 'fa-solid fa-utensils',
                            'route' => '#',
                        ],
                        [
                            'title' => 'import meals rates',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => '#',
                            'parameters' => ['models' => 'meals-rates'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour guides',
            'icon' => 'fa-solid fa-person-hiking',
            'children' => [
                [
                    'title' => 'tour guides',
                    'icon' => 'fa-solid fa-person-hiking',
                    'children' => [
                        [
                            'title' => 'all guides',
                            'icon' => 'fa-solid fa-people-group',
                            'route' => 'tour-guides.index'
                        ],
                        [
                            'title' => 'create guide',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides.create'
                        ],
                        [
                            'title' => 'import guides',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'tour-guides'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides types',
                    'icon' => 'fa-solid fa-tags',
                    'children' => [
                        [
                            'title' => 'all guides types',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'tour-guides-types.index'
                        ],
                        [
                            'title' => 'create guide type',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides-types.create'
                        ],
                        [
                            'title' => 'import guides types',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'tour-guides-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides reviews',
                    'icon' => 'fa-solid fa-star',
                    'status' => 'updating',
                    'children' => [
                        [
                            'title' => 'all guides reviews',
                            'icon' => 'fa-solid fa-clipboard-list',
                            'route' => 'tour-guides-reviews.index'
                        ],
                        [
                            'title' => 'create guide review',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides-reviews.create'
                        ],
                        [
                            'title' => 'import guides reviews',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'tour-guides-reviews'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Transportation =================
        [
            'title' => 'transportation',
            'fixed' => 'soon',
            'icon' => 'fa-solid fa-truck-fast',
            'children' => [
                [
                    'title' => 'companies',
                    'icon' => 'fa-solid fa-building',
                    'route' => 'transportation-companies.index'
                ],
                [
                    'title' => 'departments',
                    'icon' => 'fa-solid fa-sitemap',
                    'route' => 'transportation-departments.index'
                ],
                [
                    'title' => 'car rental',
                    'fixed' => false,
                    'icon' => 'fa-solid fa-car',
                    'route' => '#'
                ],
                [
                    'title' => 'limousine transfers',
                    'fixed' => false,
                    'icon' => 'fa-solid fa-taxi',
                    'route' => '#'
                ],
                [
                    'title' => 'vehicles',
                    'icon' => 'fa-solid fa-warehouse',
                    'children' => [
                        [
                            'title' => 'bus types',
                            'icon' => 'fa-solid fa-bus',
                            'route' => 'transportation-bus-types.index'
                        ],
                        [
                            'title' => 'company bus types',
                            'icon' => 'fa-solid fa-bus-simple',
                            'route' => 'transportation-company-bus-types.index'
                        ],
                        [
                            'title' => '4x4 vehicles',
                            'icon' => 'fa-solid fa-car-side',
                            'route' => 'transportation-vehicles.index'
                        ],
                    ],
                ],
            ],
        ],

        // ================= Air Transport =================
        [
            'title' => 'airlines',
            'icon' => 'fa-solid fa-plane',
            'children' => [
                [
                    'title' => 'airlines',
                    'icon' => 'fa-solid fa-plane',
                    'route' => 'airlines.index'
                ],
                [
                    'title' => 'create airline',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'airlines.create'
                ],
                [
                    'title' => 'import airlines',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'airlines'],
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
            'title' => 'tourist sites',
            'icon' => 'fa-solid fa-map-location-dot',
            'children' => [
                [
                    'title' => 'all tourist sites',
                    'icon' => 'fa-solid fa-map-location-dot',
                    'route' => 'tourist-sites.index'
                ],
                [
                    'title' => 'create tourist site',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'tourist-sites.create'
                ],
                [
                    'title' => 'import tourist sites',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'tourist-sites'],
                ],
            ],
        ],

        // ================= Crossings & Ports =================
        [
            'title' => 'crossings & ports',
            'icon' => 'fa-solid fa-map-signs',
            'children' => [
                [
                    'title' => 'all crossings ports',
                    'icon' => 'fa-solid fa-anchor',
                    'route' => 'crossings-ports.index'
                ],
                [
                    'title' => 'create crossing port',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'crossings-ports.create'
                ],
                [
                    'title' => 'import crossings ports',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'crossings-ports'],
                ],
                [
                    'title' => 'airports',
                    'icon' => 'fa-solid fa-plane-departure',
                    'children' => [
                        [
                            'title' => 'international airports',
                            'icon' => 'fa-solid fa-earth-europe',
                            'route' => 'crossings-ports.type',
                            'parameters' => ['type' => 'international-airports'],
                        ],
                        [
                            'title' => 'domestic airports',
                            'icon' => 'fa-solid fa-plane-arrival',
                            'route' => 'crossings-ports.type',
                            'parameters' => ['type' => 'domestic-airports'],
                        ],
                    ],
                ],
                [
                    'title' => 'seaports',
                    'icon' => 'fa-solid fa-ship',
                    'route' => 'crossings-ports.type',
                    'parameters' => ['type' => 'seaports'],
                ],
            ],
        ],

        // ================= Reports =================
        [
            'title' => 'reports & analytics',
            'icon' => 'fa-solid fa-chart-pie',
            'children' => [
                [
                    'title' => 'reports dashboard',
                    'icon' => 'fa-solid fa-gauge-high',
                    'route' => 'reports.index'
                ],
                [
                    'title' => 'user reports',
                    'icon' => 'fa-solid fa-users',
                    'route' => 'reports.users'
                ],
                [
                    'title' => 'location reports',
                    'icon' => 'fa-solid fa-map',
                    'route' => 'reports.locations'
                ],
                [
                    'title' => 'detailed analytics',
                    'icon' => 'fa-solid fa-chart-line',
                    'route' => 'reports.analytics'
                ],
            ],
        ],

        // ================= Activity Log =================
        [
            'title' => 'activity log',
            'icon' => 'fa-solid fa-clipboard-list',
            'route' => 'activity-log.index',
        ],

        // ================= Notifications =================
        [
            'title' => 'notifications',
            'icon' => 'fa-solid fa-bell',
            'route' => 'notifications.index',
        ],

        // ================= Languages =================
        [
            'title' => 'languages',
            'icon' => 'fa-solid fa-language',
            'children' => [
                [
                    'title' => 'all languages',
                    'icon' => 'fa-solid fa-language',
                    'route' => 'languages.index'
                ],
                [
                    'title' => 'create language',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'languages.create'
                ]
            ],
        ],

        // ================= System Languages =================
        [
            'title' => 'system languages',
            'icon' => 'fa-solid fa-language',
            'children' => [
                [
                    'title' => 'all languages',
                    'icon' => 'fa-solid fa-language',
                    'route' => 'system-languages.index'
                ],
                [
                    'title' => 'create language',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'system-languages.create'
                ]
            ],
        ],

        // ================= Profile =================
        [
            'title' => 'profile management',
            'icon' => 'fa-solid fa-id-badge',
            'children' => [
                [
                    'title' => 'view profile',
                    'icon' => 'fa-solid fa-user',
                    'route' => 'profile.index'
                ],
                [
                    'title' => 'edit profile',
                    'icon' => 'fa-solid fa-user-pen',
                    'route' => 'profile.edit'
                ],
                [
                    'title' => 'change password',
                    'icon' => 'fa-solid fa-lock',
                    'route' => 'profile.change_password'
                ],
            ],
        ],

        // ================= Media Files =================
        [
            'title' => 'media files',
            'icon' => 'fa-solid fa-photo-film',
            'children' => [
                [
                    'title' => 'all media files',
                    'icon' => 'fa-solid fa-images',
                    'route' => 'media-files.index',
                ],
                [
                    'title' => 'upload files',
                    'icon' => 'fa-solid fa-cloud-arrow-up',
                    'route' => 'media-files.create',
                ],
            ],
        ],

        // ================= Settings =================
        [
            'title' => 'settings',
            'icon' => 'fa-solid fa-gear',
            'children' => [
                [
                    'title' => 'general',
                    'route' => 'settings.general'
                ],
                [
                    'title' => 'security',
                    'route' => 'settings.security'
                ],
                // [
                //     'title' => 'notifications',
                //     'route' => 'settings.notifications'
                // ],
                [
                    'title' => 'backup',
                    'icon' => 'fa-solid fa-cloud-arrow-down',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.backup'
                ],
                [
                    'title' => 'booking',
                    'icon' => 'fa-solid fa-calendar-days',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.booking'
                ],
                [
                    'title' => 'integration',
                    'icon' => 'fa-solid fa-share-nodes',
                    'route' => 'settings.integration'
                ],
                [
                    'title' => 'system',
                    'icon' => 'fa-solid fa-gears',
                    'route' => 'settings.system'
                ],
            ],
        ],
    ],
];