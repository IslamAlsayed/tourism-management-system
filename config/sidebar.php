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
                    'parameters' => ['model' => 'user', 'models' => 'users', 'view' => 'users'],
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
                    'parameters' => ['model' => 'client', 'models' => 'clients', 'view' => 'clients'],
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
                    'parameters' => ['model' => 'currency', 'models' => 'currencies', 'view' => 'currencies'],
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
                            'parameters' => ['model' => 'region', 'models' => 'regions', 'view' => 'regions'],
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
                            'parameters' => ['model' => 'subregion', 'models' => 'subregions', 'view' => 'subregions'],
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
                            'parameters' => ['model' => 'country', 'models' => 'countries', 'view' => 'countries'],
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
                            'parameters' => ['model' => 'state', 'models' => 'states', 'view' => 'states'],
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
                            'parameters' => ['model' => 'city', 'models' => 'cities', 'view' => 'cities'],
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
                            'parameters' => ['model' => 'nationality', 'models' => 'nationalities', 'view' => 'nationalities'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Accommodations =================
        [
            'title' => 'accommodations management',
            'icon' => 'fa-solid fa-hotel',
            'children' => [
                [
                    'title' => 'accommodations',
                    'icon' => 'fa-solid fa-utensils',
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
                            'parameters' => ['model' => 'accommodation', 'models' => 'accommodations', 'view' => 'accommodations'],
                        ],
                    ],
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
                            'parameters' => ['model' => 'type', 'models' => 'types', 'view' => 'types'],
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
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'rooms.create',
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import rooms',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'room', 'models' => 'rooms', 'view' => 'rooms'],
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
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-regular fa-calendar-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'season', 'models' => 'seasons', 'view' => 'seasons'],
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
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'meal', 'models' => 'meals', 'view' => 'meals'],
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
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'supplement', 'models' => 'supplements', 'view' => 'supplements'],
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

        // ================= Transportation =================
        [
            'title' => 'transportation management',
            'icon' => 'fa-solid fa-hotel',
            'children' => [
                [
                    'title' => 'transportation',
                    'icon' => 'fa-regular fa-building',
                    'children' => [
                        [
                            'title' => 'all companies',
                            'icon' => 'fa-regular fa-building',
                            'route' => 'transportation.companies.index',
                        ],
                        [
                            'title' => 'create company',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'transportation.companies.create',
                        ],
                        [
                            'title' => 'import companies',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationCompany', 'models' => 'transportation-companies', 'view' => 'transportation.companies'],
                        ],
                    ],
                ],
                [
                    'title' => 'vehicle-types',
                    'icon' => 'fa-regular fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all vehicle-types',
                            'icon' => 'fa-regular fa-list-ul',
                            'route' => 'transportation.vehicle-types.index',
                        ],
                        [
                            'title' => 'create vehicle-type',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'transportation.vehicle-types.create',
                        ],
                        [
                            'title' => 'import vehicle-types',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationVehicleType', 'models' => 'transportation-vehicle-types', 'view' => 'transportation.vehicle-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'routes',
                    'icon' => 'fa-regular fa-layer-group',
                    'fixed' => 'soon',
                    'children' => [
                        [
                            'title' => 'all routes',
                            'icon' => 'fa-regular fa-list-ul',
                            'route' => null,
                        ],
                        [
                            'title' => 'create route',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => null,
                        ],
                        [
                            'title' => 'import routes',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => null,
                            'parameters' => ['model' => 'transportationRoute', 'models' => 'transportation-routes', 'view' => 'transportation.routes'],
                        ],
                    ],
                ],
                [
                    'title' => 'pricing',
                    'icon' => 'fa-regular fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all pricing',
                            'icon' => 'fa-regular fa-list-ul',
                            'route' => 'transportation.pricings.index',
                        ],
                        [
                            'title' => 'create pricing',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'transportation.pricings.create',
                        ],
                        [
                            'title' => 'import pricing',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationPricing', 'models' => 'transportation-pricings', 'view' => 'transportation.pricings'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fa-regular fa-utensils',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fa-regular fa-bowl-food',
                            'route' => 'seasons.index',
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['type' => 'transportation'],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'season', 'models' => 'seasons', 'view' => 'seasons'],
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
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'Transportation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'supplements.create',
                            'parameters' => ['type' => 'transportation'],
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'supplement', 'models' => 'supplements', 'view' => 'supplements'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Food & Beverage =================
        [
            // 'title' => 'food & beverage',
            // 'title' => 'food management',
            'title' => 'restaurants management',
            'icon' => 'fa-solid fa-mug-hot',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'fa-solid fa-burger',
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
                            'parameters' => ['model' => 'restaurant', 'models' => 'restaurants', 'view' => 'restaurants'],
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
                            'parameters' => [\Illuminate\Support\Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'meals.create',
                            'parameters' => ['type' => 'restaurant'],
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'meal', 'models' => 'meals', 'view' => 'meals'],
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
                            'parameters' => ['type' => 'restaurant'],
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-regular fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'supplement', 'models' => 'supplements', 'view' => 'supplements'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Topics =================
        [
            'title' => 'topics',
            'icon' => 'fa-solid fa-hotel',
            'children' => [
                [
                    'title' => 'pricing definitions',
                    'icon' => 'fa-regular fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all pricing definitions',
                            'icon' => 'fa-regular fa-building',
                            'route' => 'pricing-definitions.index',
                        ],
                        [
                            'title' => 'create pricing definition',
                            'icon' => 'fa-regular fa-square-plus',
                            'route' => 'pricing-definitions.create',
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour-guides management',
            'icon' => 'fa-solid fa-person-hiking',
            'children' => [
                [
                    'title' => 'tour-guides',
                    'icon' => 'fa-solid fa-person-hiking',
                    'children' => [
                        [
                            'title' => 'all tour-guides',
                            'icon' => 'fa-solid fa-people-group',
                            'route' => 'tour-guides.index'
                        ],
                        [
                            'title' => 'create tour-guide',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides.create'
                        ],
                        [
                            'title' => 'import tour-guides',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tour-guide', 'models' => 'tour-guides', 'view' => 'tour-guides'],
                        ],
                    ],
                ],
                [
                    'title' => 'tour-guides-types',
                    'icon' => 'fa-solid fa-tags',
                    'children' => [
                        [
                            'title' => 'all tour-guides-types',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'tour-guides-types.index'
                        ],
                        [
                            'title' => 'create tour-guide-type',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides-types.create'
                        ],
                        [
                            'title' => 'import tour-guides-types',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tour-guides-type', 'models' => 'tour-guides-types', 'view' => 'tour-guides-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'tour-guides-reviews',
                    'icon' => 'fa-solid fa-star',
                    'children' => [
                        [
                            'title' => 'all tour-guides-reviews',
                            'icon' => 'fa-solid fa-clipboard-list',
                            'route' => 'tour-guides-reviews.index'
                        ],
                        [
                            'title' => 'create tour-guide-review',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'tour-guides-reviews.create'
                        ],
                        [
                            'title' => 'import tour-guides-reviews',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tour-guide-review', 'models' => 'tour-guides-reviews', 'view' => 'tour-guides-reviews'],
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
                    'parameters' => ['model' => 'airline', 'models' => 'airlines', 'view' => 'airlines'],
                ],
            ],
        ],

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
                    'parameters' => ['model' => 'tourist-site', 'models' => 'tourist-sites', 'view' => 'tourist-sites'],
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
                    'parameters' => ['model' => 'crossings-port', 'models' => 'crossings-ports', 'view' => 'crossings-ports'],
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