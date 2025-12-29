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
            'status' => 'done',
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
            'status' => 'done',
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
            'status' => 'done',
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
            'status' => 'done',
            'children' => [
                [
                    'title' => 'regions',
                    'icon' => 'fa-solid fa-globe',
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
                    'icon' => 'fa-solid fa-layer-group',
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
                    'icon' => 'fa-solid fa-earth-americas',
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
                    'icon' => 'fa-solid fa-map',
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
                    'icon' => 'fa-regular fa-building',
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
                    'icon' => 'fa-regular fa-id-card',
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
            'status' => 'done',
            'children' => [
                [
                    'title' => 'all accommodations',
                    'icon' => 'fa-regular fa-building',
                    'route' => 'accommodations.index',
                ],
                [
                    'title' => 'create accommodation',
                    'icon' => 'fa-regular fa-square-plus',
                    'route' => 'accommodations.create',
                ],
                [
                    'title' => 'import accommodations',
                    'icon' => 'fa-regular fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['models' => 'accommodations'],
                ],
                [
                    'title' => 'types',
                    'icon' => 'fa-regular fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all types',
                            'icon' => 'fa-regular fa-list-ul',
                            'route' => 'types.index',
                        ],
                        [
                            'title' => 'create type',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'types.create',
                        ],
                        [
                            'title' => 'import types',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'types'],
                        ],
                    ],
                ],
                // [
                //     'title' => 'cores',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all cores',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'cores.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'cores.create',
                //         ],
                //         [
                //             'title' => 'import cores',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'cores'],
                //         ],
                //     ],
                // ],
                [
                    'title' => 'rooms',
                    'icon' => 'fa-regular fa-door-closed',
                    'children' => [
                        [
                            'title' => 'all rooms',
                            'icon' => 'fa-regular fa-door-closed',
                            'route' => 'rooms.index',
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'rooms.create',
                        ],
                        [
                            'title' => 'import rooms',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'rooms'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fa-regular fa-calendar-days',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fa-regular fa-calendar-check',
                            'route' => 'seasons.index',
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-regular fa-calendar-plus',
                            'route' => 'seasons.create',
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'seasons'],
                        ],
                    ],
                ],
                // [
                //     'title' => 'pricing',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all pricing',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'pricing.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'pricing.create',
                //         ],
                //         [
                //             'title' => 'import pricing',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'pricing'],
                //         ],
                //     ],
                // ],
                // [
                //     'title' => 'availability',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all availability',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'availability.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'availability.create',
                //         ],
                //         [
                //             'title' => 'import availability',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'availability'],
                //         ],
                //     ],
                // ],
                [
                    'title' => 'meals',
                    'icon' => 'fa-regular fa-utensils',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fa-regular fa-bowl-food',
                            'route' => 'meals.index',
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'meals.create',
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'meals'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fa-regular fa-utensils',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-regular fa-bowl-food',
                            'route' => 'supplements.index',
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'supplements.create',
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'supplements'],
                        ],
                    ],
                ],
                // [
                //     'title' => 'policing',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all policing',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'policing.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'policing.create',
                //         ],
                //         [
                //             'title' => 'import policing',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'policing'],
                //         ],
                //     ],
                // ],
                // [
                //     'title' => 'amenities',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all amenities',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'amenities.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'amenities.create',
                //         ],
                //         [
                //             'title' => 'import amenities',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'amenities'],
                //         ],
                //     ],
                // ],
                // [
                //     'title' => 'media',
                //     'icon' => 'fa-regular fa-layer-group',
                //     'children' => [
                //         [
                //             'title' => 'all media',
                //             'icon' => 'fa-regular fa-list-ul',
                //             'route' => 'media.index',
                //         ],
                //         [
                //             'title' => 'create type',
                //             'icon' => 'fa-regular fa-square-plus',
                //             'route' => 'media.create',
                //         ],
                //         [
                //             'title' => 'import media',
                //             'icon' => 'fa-regular fa-file-import',
                //             'route' => 'import.data',
                //             'parameters' => ['models' => 'media'],
                //         ],
                //     ],
                // ],
            ],
        ],

        // ================= Food & Beverage =================
        [
            'title' => 'food & beverage',
            'icon' => 'fa-solid fa-mug-hot',
            'status' => 'done',
            'children' => [
                [
                    'title' => 'all restaurants',
                    'icon' => 'fa-solid fa-burger',
                    'route' => 'restaurants.index',
                ],
                [
                    'title' => 'create restaurant',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'restaurants.create',
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
                            'route' => 'meals.index',
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'restaurant'],
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
                    'title' => 'supplements',
                    'icon' => 'fa-regular fa-utensils',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-regular fa-bowl-food',
                            'route' => 'supplements.index',
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'supplements.create',
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['models' => 'supplements'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour guides',
            'icon' => 'fa-solid fa-person-hiking',
            'status' => 'done',
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
            'status' => 'done',
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
            'status' => 'done',
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
            'status' => 'done',
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