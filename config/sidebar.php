<?php

use Illuminate\Support\Str;

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
            'title' => 'users',
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
            'title' => 'clients',
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
            'title' => 'currencies',
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

        // ================= Timezones =================
        [
            'title' => 'timezones',
            'icon' => 'fa-solid fa-clock',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all timezones',
                    'icon' => 'fa-solid fa-clock',
                    'route' => 'timezones.index',
                ],
                [
                    'title' => 'create timezone',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'timezones.create',
                ],
                [
                    'title' => 'import timezones',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'timezone', 'models' => 'timezones', 'view' => 'timezones'],
                ],
            ],
        ],

        // ================= Locations =================
        [
            'title' => 'locations',
            'icon' => 'fa-solid fa-location-dot',
            'children' => [
                [
                    'title' => 'regions',
                    'icon' => 'fa-solid fa-globe',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'regions.index',
                        ],
                        [
                            'title' => 'create region',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'regions.create',
                        ],
                        [
                            'title' => 'import regions',
                            'icon' => 'fa-solid fa-file-import',
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
                            'icon' => 'fa-solid fa-list',
                            'route' => 'subregions.index',
                        ],
                        [
                            'title' => 'create subregion',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'subregions.create',
                        ],
                        [
                            'title' => 'import subregions',
                            'icon' => 'fa-solid fa-file-import',
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
                            'icon' => 'fa-solid fa-list',
                            'route' => 'countries.index'
                        ],
                        [
                            'title' => 'create country',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'countries.create',
                        ],
                        [
                            'title' => 'import countries',
                            'icon' => 'fa-solid fa-file-import',
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
                            'icon' => 'fa-solid fa-list',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'create state',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'states.create',
                        ],
                        [
                            'title' => 'import states',
                            'icon' => 'fa-solid fa-file-import',
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
                            'icon' => 'fa-solid fa-list',
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => 'create city',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'cities.create',
                        ],
                        [
                            'title' => 'import cities',
                            'icon' => 'fa-solid fa-file-import',
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
                            'icon' => 'fa-solid fa-list',
                            'route' => 'nationalities.index',
                        ],
                        [
                            'title' => 'create nationality',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'nationalities.create',
                        ],
                        [
                            'title' => 'import nationalities',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'nationality', 'models' => 'nationalities', 'view' => 'nationalities'],
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
                    'title' => 'accommodations',
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all accommodations',
                            'icon' => 'fa-solid fa-hotel',
                            'route' => 'accommodations.index',
                        ],
                        [
                            'title' => 'create accommodation',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'accommodations.create',
                        ],
                        [
                            'title' => 'import accommodations',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'accommodation', 'models' => 'accommodations', 'view' => 'accommodations'],
                        ],
                    ],
                ],
                [
                    'title' => 'types',
                    'icon' => 'fa-solid fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all types',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'types.index',
                        ],
                        [
                            'title' => 'create type',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'types.create',
                        ],
                        [
                            'title' => 'import types',
                            'icon' => 'fa-solid fa-file-import',
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
                    'icon' => 'fa-solid fa-door-closed',
                    'children' => [
                        [
                            'title' => 'all rooms',
                            'icon' => 'fa-solid fa-door-open',
                            'route' => 'rooms.index',
                            'parameters' => [Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'rooms.create',
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import rooms',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'room', 'models' => 'rooms', 'view' => 'rooms'],
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
                            'parameters' => [Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-solid fa-calendar-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['type' => 'accommodation', Str::random(120)],
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
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fa-solid fa-bowl-food',
                            'route' => 'meals.index',
                            'parameters' => [Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'meals.create',
                            'parameters' => ['type' => 'accommodation'],
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
                    'icon' => 'fa-solid fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-solid fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => [Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-solid fa-plus',
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
            'title' => 'transportations',
            'icon' => 'fa-solid fa-bus',
            'status' => 'updated',
            'children' => [
                [
                    'title' => 'companies',
                    'icon' => 'fa-solid fa-building',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all companies',
                            'icon' => 'fa-solid fa-building-user',
                            'route' => 'transportations.companies.index',
                        ],
                        [
                            'title' => 'create company',
                            'icon' => 'fa-solid fa-plus',
                            'status' => 'updated',
                            'route' => 'transportations.companies.create',
                        ],
                        [
                            'title' => 'import companies',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationCompany', 'models' => 'transportations-companies', 'view' => 'transportations.companies'],
                        ],
                    ],
                ],
                [
                    'title' => 'vehicle-types',
                    'icon' => 'fa-solid fa-car',
                    'children' => [
                        [
                            'title' => 'all vehicle-types',
                            'icon' => 'fa-solid fa-van-shuttle',
                            'route' => 'transportations.vehicle-types.index',
                        ],
                        [
                            'title' => 'create vehicle-type',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'transportations.vehicle-types.create',
                        ],
                        [
                            'title' => 'import vehicle-types',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationVehicleType', 'models' => 'transportations-vehicle-types', 'view' => 'transportations.vehicle-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'routes',
                    'icon' => 'fa-solid fa-route',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all routes',
                            'icon' => 'fa-solid fa-map-marked-alt',
                            'route' => 'transportations.routes.index',
                        ],
                        [
                            'title' => 'create route',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'transportations.routes.create',
                        ],
                        [
                            'title' => 'import routes',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRoute', 'models' => 'transportations-routes', 'view' => 'transportations.routes'],
                        ],
                    ],
                ],
                [
                    'title' => 'route assignments',
                    'icon' => 'fa-solid fa-share-nodes',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all route assignments',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'transportations.route-assignments.index',
                        ],
                        [
                            'title' => 'create route assignment',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'transportations.route-assignments.create',
                        ],
                        [
                            'title' => 'import route assignments',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRouteAssignment', 'models' => 'transportations-route-assignments', 'view' => 'transportations.route-assignments'],
                        ],
                    ],
                ],
                [
                    'title' => 'pricings',
                    'icon' => 'fa-solid fa-dollar-sign',
                    'children' => [
                        [
                            'title' => 'all pricings',
                            'icon' => 'fa-solid fa-tags',
                            'route' => 'transportations.pricings.index',
                        ],
                        [
                            'title' => 'create pricing',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'transportations.pricings.create',
                        ],
                        [
                            'title' => 'import pricings',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationPricing', 'models' => 'transportations-pricings', 'view' => 'transportations.pricings'],
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
                            'parameters' => [Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['type' => 'transportation', Str::random(120)],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'season', 'models' => 'seasons', 'view' => 'seasons'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fa-solid fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-solid fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => [Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'supplements.create',
                            'parameters' => ['type' => 'transportation'],
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fa-solid fa-file-import',
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
            // 'title' => 'food',
            'title' => 'restaurants',
            'icon' => 'fa-solid fa-utensils',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'fa-solid fa-utensils',
                    'children' => [
                        [
                            'title' => 'all restaurants',
                            'icon' => 'fa-solid fa-utensils',
                            'route' => 'restaurants.index',
                        ],
                        [
                            'title' => 'create restaurant',
                            'icon' => 'fa-solid fa-plus',
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
                    'icon' => 'fa-solid fa-bowl-food',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fa-solid fa-bowl-rice',
                            'route' => 'meals.index',
                            'parameters' => [Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fa-solid fa-plus',
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
                    'icon' => 'fa-solid fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fa-solid fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => [Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fa-solid fa-plus',
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
            'icon' => 'fa-solid fa-book',
            'children' => [
                [
                    'title' => 'pricing definitions',
                    'icon' => 'fa-solid fa-money-bill-wave',
                    'children' => [
                        [
                            'title' => 'all pricing definitions',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'pricing-definitions.index',
                        ],
                        [
                            'title' => 'create pricing definition',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'pricing-definitions.create',
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour-guides',
            'icon' => 'fa-solid fa-person-hiking',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'guides',
                    'icon' => 'fa-solid fa-person-hiking',
                    'children' => [
                        [
                            'title' => 'all guides',
                            'icon' => 'fa-solid fa-people-group',
                            'route' => 'tours.guides.index'
                        ],
                        [
                            'title' => 'create guide',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'tours.guides.create'
                        ],
                        [
                            'title' => 'import guides',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuide', 'models' => 'tours-guides', 'view' => 'tours.guides'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides-types',
                    'icon' => 'fa-solid fa-tags',
                    'children' => [
                        [
                            'title' => 'all guides-types',
                            'icon' => 'fa-solid fa-layer-group',
                            'route' => 'tours.guides-types.index'
                        ],
                        [
                            'title' => 'create guide-type',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'tours.guides-types.create'
                        ],
                        [
                            'title' => 'import guides-types',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuideType', 'models' => 'tours-guides-types', 'view' => 'tours.guides-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides-reviews',
                    'icon' => 'fa-solid fa-star-half-stroke',
                    'children' => [
                        [
                            'title' => 'all guides-reviews',
                            'icon' => 'fa-solid fa-star',
                            'route' => 'tours.guides-reviews.index'
                        ],
                        [
                            'title' => 'create guide-review',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'tours.guides-reviews.create'
                        ],
                        [
                            'title' => 'import guides-reviews',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuideReview', 'models' => 'tours-guides-reviews', 'view' => 'tours.guides-reviews'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fa-solid fa-calendar-days',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fa-solid fa-calendar-check',
                            'route' => 'seasons.index',
                            'parameters' => [Str::random(120), 'type' => 'tours'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fa-solid fa-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['type' => 'tours', Str::random(120)],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fa-solid fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'season', 'models' => 'seasons', 'view' => 'seasons'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Air Transport =================
        [
            'title' => 'airlines',
            'icon' => 'fa-solid fa-plane-departure',
            'children' => [
                [
                    'title' => 'airlines',
                    'icon' => 'fa-solid fa-plane-up',
                    'route' => 'airlines.index'
                ],
                [
                    'title' => 'create airline',
                    'icon' => 'fa-solid fa-plus',
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
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all tourist sites',
                    'icon' => 'fa-solid fa-landmark',
                    'route' => 'tourist-sites.index'
                ],
                [
                    'title' => 'create tourist site',
                    'icon' => 'fa-solid fa-plus',
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

        // ================= Tourist Services =================
        [
            'title' => 'tourist services',
            'icon' => 'fa-solid fa-map-location-dot',
            'status' => 'updated',
            'children' => [
                [
                    'title' => 'all tourist services',
                    'icon' => 'fa-solid fa-landmark',
                    'route' => 'tourist-services.index'
                ],
                [
                    'title' => 'create tourist service',
                    'icon' => 'fa-solid fa-plus',
                    'route' => 'tourist-services.create'
                ],
                [
                    'title' => 'import tourist services',
                    'icon' => 'fa-solid fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'tourist-service', 'models' => 'tourist-services', 'view' => 'tourist-services'],
                ],
            ],
        ],

        // ================= Crossings & Ports =================
        [
            'title' => 'crossings & ports',
            'icon' => 'fa-solid fa-signs-post',
            'children' => [
                [
                    'title' => 'all crossings ports',
                    'icon' => 'fa-solid fa-list',
                    'route' => 'crossings-ports.index'
                ],
                [
                    'title' => 'create crossing port',
                    'icon' => 'fa-solid fa-plus',
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
                            'icon' => 'fa-solid fa-globe',
                            'route' => 'crossings-ports.type',
                            'parameters' => ['type' => 'international-airports'],
                        ],
                        [
                            'title' => 'domestic airports',
                            'icon' => 'fa-solid fa-plane',
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
                    'icon' => 'fa-solid fa-gauge',
                    'route' => 'reports.index'
                ],
                [
                    'title' => 'user reports',
                    'icon' => 'fa-solid fa-user-chart',
                    'route' => 'reports.users'
                ],
                [
                    'title' => 'location reports',
                    'icon' => 'fa-solid fa-map-marked',
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
            'icon' => 'fa-solid fa-globe',
            'children' => [
                [
                    'title' => 'all languages',
                    'icon' => 'fa-solid fa-globe',
                    'route' => 'system-languages.index'
                ],
                [
                    'title' => 'create language',
                    'icon' => 'fa-solid fa-plus',
                    'route' => 'system-languages.create'
                ]
            ],
        ],

        // ================= Profile =================
        [
            'title' => 'profile',
            'icon' => 'fa-solid fa-id-badge',
            'children' => [
                [
                    'title' => 'view profile',
                    'icon' => 'fa-solid fa-circle-user',
                    'route' => 'profile.index'
                ],
                [
                    'title' => 'edit profile',
                    'icon' => 'fa-solid fa-pen-to-square',
                    'route' => 'profile.edit'
                ],
                [
                    'title' => 'change password',
                    'icon' => 'fa-solid fa-key',
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
                    'icon' => 'fa-solid fa-file-image',
                    'route' => 'media-files.index',
                ],
                [
                    'title' => 'upload files',
                    'icon' => 'fa-solid fa-upload',
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
                    'icon' => 'fa-solid fa-sliders',
                    'route' => 'settings.general',
                ],
                [
                    'title' => 'security',
                    'icon' => 'fa-solid fa-shield-halved',
                    'route' => 'settings.security',
                    'roles' => ['admin', 'superadmin']
                ],
                // [
                //     'title' => 'notifications',
                //     'route' => 'settings.notifications'
                // ],
                [
                    'title' => 'backup',
                    'icon' => 'fa-solid fa-database',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.backup'
                ],
                [
                    'title' => 'booking',
                    'icon' => 'fa-solid fa-book',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.booking'
                ],
                [
                    'title' => 'integration',
                    'icon' => 'fa-solid fa-plug',
                    'route' => 'settings.integration',
                    'roles' => ['admin', 'superadmin']
                ],
                [
                    'title' => 'system',
                    'icon' => 'fa-solid fa-cog',
                    'route' => 'settings.system'
                ],
            ],
        ],
    ],
];