<?php

use Illuminate\Support\Str;

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'fas fa-gauge',
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
            'icon' => 'fas fa-users-gear',
            'children' => [
                [
                    'title' => 'all users',
                    'icon' => 'fas fa-users',
                    'route' => 'users.index',
                ],
                [
                    'title' => 'create user',
                    'icon' => 'fas fa-user-plus',
                    'route' => 'users.create',
                ],
                [
                    'title' => 'import users',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'user', 'models' => 'users', 'view' => 'users'],
                ]
            ],
        ],

        // ================= Roles & Permissions =================
        [
            'title' => 'roles_and_permissions',
            'icon' => 'fas fa-shield',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'roles',
                    'icon' => 'fas fa-crown',
                    'route' => 'roles.index',
                ],
                [
                    'title' => 'create role',
                    'icon' => 'fas fa-square-plus',
                    'route' => 'roles.create',
                ],
                [
                    'title' => 'permissions',
                    'icon' => 'fas fa-lock',
                    'route' => 'permissions.index',
                ],
                [
                    'title' => 'create permission',
                    'icon' => 'fas fa-square-plus',
                    'route' => 'permissions.create',
                ]
            ],
        ],

        // ================= Clients =================
        [
            'title' => 'clients',
            'icon' => 'fas fa-user-group',
            'children' => [
                [
                    'title' => 'all clients',
                    'icon' => 'fas fa-user-group',
                    'route' => 'clients.index',
                ],
                [
                    'title' => 'create client',
                    'icon' => 'fas fa-user-plus',
                    'route' => 'clients.create',
                ],
                [
                    'title' => 'import clients',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'client', 'models' => 'clients', 'view' => 'clients'],
                ]
            ],
        ],

        // ================= Currencies =================
        [
            'title' => 'currencies',
            'icon' => 'fas fa-dollar-sign',
            'children' => [
                [
                    'title' => 'all currencies',
                    'icon' => 'fas fa-coins',
                    'route' => 'currencies.index',
                ],
                [
                    'title' => 'create currency',
                    'icon' => 'fas fa-square-plus',
                    'route' => 'currencies.create',
                ],
                [
                    'title' => 'import currencies',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'currency', 'models' => 'currencies', 'view' => 'currencies'],
                ],
            ],
        ],

        // ================= Timezones =================
        [
            'title' => 'timezones',
            'icon' => 'fas fa-clock',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all timezones',
                    'icon' => 'fas fa-clock',
                    'route' => 'timezones.index',
                ],
                [
                    'title' => 'create timezone',
                    'icon' => 'fas fa-square-plus',
                    'route' => 'timezones.create',
                ],
                [
                    'title' => 'import timezones',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'timezone', 'models' => 'timezones', 'view' => 'timezones'],
                ],
            ],
        ],

        // ================= Locations =================
        [
            'title' => 'locations',
            'icon' => 'fas fa-location-dot',
            'children' => [
                [
                    'title' => 'regions',
                    'icon' => 'fas fa-globe',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'icon' => 'fas fa-list',
                            'route' => 'regions.index',
                        ],
                        [
                            'title' => 'create region',
                            'icon' => 'fas fa-plus',
                            'route' => 'regions.create',
                        ],
                        [
                            'title' => 'import regions',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'region', 'models' => 'regions', 'view' => 'regions'],
                        ],
                    ],
                ],
                [
                    'title' => 'subregions',
                    'icon' => 'fas fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all subregions',
                            'icon' => 'fas fa-list',
                            'route' => 'subregions.index',
                        ],
                        [
                            'title' => 'create subregion',
                            'icon' => 'fas fa-plus',
                            'route' => 'subregions.create',
                        ],
                        [
                            'title' => 'import subregions',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'subregion', 'models' => 'subregions', 'view' => 'subregions'],
                        ],
                    ],
                ],
                [
                    'title' => 'countries',
                    'icon' => 'fas fa-earth-americas',
                    'children' => [
                        [
                            'title' => 'all countries',
                            'icon' => 'fas fa-list',
                            'route' => 'countries.index'
                        ],
                        [
                            'title' => 'create country',
                            'icon' => 'fas fa-plus',
                            'route' => 'countries.create',
                        ],
                        [
                            'title' => 'import countries',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'country', 'models' => 'countries', 'view' => 'countries'],
                        ],
                    ],
                ],
                [
                    'title' => 'states',
                    'icon' => 'fas fa-map',
                    'children' => [
                        [
                            'title' => 'all states',
                            'icon' => 'fas fa-list',
                            'route' => 'states.index',
                        ],
                        [
                            'title' => 'create state',
                            'icon' => 'fas fa-plus',
                            'route' => 'states.create',
                        ],
                        [
                            'title' => 'import states',
                            'icon' => 'fas fa-file-import',
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
                            'icon' => 'fas fa-list',
                            'route' => 'cities.index',
                        ],
                        [
                            'title' => 'create city',
                            'icon' => 'fas fa-plus',
                            'route' => 'cities.create',
                        ],
                        [
                            'title' => 'import cities',
                            'icon' => 'fas fa-file-import',
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
                            'icon' => 'fas fa-list',
                            'route' => 'nationalities.index',
                        ],
                        [
                            'title' => 'create nationality',
                            'icon' => 'fas fa-plus',
                            'route' => 'nationalities.create',
                        ],
                        [
                            'title' => 'import nationalities',
                            'icon' => 'fas fa-file-import',
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
            'icon' => 'fas fa-hotel',
            'children' => [
                [
                    'title' => 'accommodations',
                    'icon' => 'fas fa-utensils',
                    'children' => [
                        [
                            'title' => 'all accommodations',
                            'icon' => 'fas fa-hotel',
                            'route' => 'accommodations.index',
                        ],
                        [
                            'title' => 'create accommodation',
                            'icon' => 'fas fa-plus',
                            'route' => 'accommodations.create',
                        ],
                        [
                            'title' => 'import accommodations',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'accommodation', 'models' => 'accommodations', 'view' => 'accommodations'],
                        ],
                    ],
                ],
                [
                    'title' => 'types',
                    'icon' => 'fas fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all types',
                            'icon' => 'fas fa-list',
                            'route' => 'types.index',
                        ],
                        [
                            'title' => 'create type',
                            'icon' => 'fas fa-plus',
                            'route' => 'types.create',
                        ],
                        [
                            'title' => 'import types',
                            'icon' => 'fas fa-file-import',
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
                    'icon' => 'fas fa-door-closed',
                    'children' => [
                        [
                            'title' => 'all rooms',
                            'icon' => 'fas fa-door-open',
                            'route' => 'rooms.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fas fa-plus',
                            'route' => 'rooms.create',
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import rooms',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'room', 'models' => 'rooms', 'view' => 'rooms'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fas fa-calendar-days',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fas fa-calendar-check',
                            'route' => 'seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-calendar-plus',
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
                    'icon' => 'fas fa-utensils',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fas fa-bowl-food',
                            'route' => 'meals.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fas fa-plus',
                            'route' => 'meals.create',
                            'parameters' => ['type' => 'accommodation'],
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'meal', 'models' => 'meals', 'view' => 'meals'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fas fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fas fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
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
            'icon' => 'fas fa-bus',
            'status' => 'updated',
            'children' => [
                [
                    'title' => 'companies',
                    'icon' => 'fas fa-building',
                    'status' => 'updated',
                    'children' => [
                        [
                            'title' => 'all companies',
                            'icon' => 'fas fa-building-user',
                            'route' => 'transportations.companies.index',
                        ],
                        [
                            'title' => 'create company',
                            'icon' => 'fas fa-plus',
                            'status' => 'updated',
                            'route' => 'transportations.companies.create',
                        ],
                        [
                            'title' => 'import companies',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationCompany', 'models' => 'transportations-companies', 'view' => 'transportations.companies'],
                        ],
                    ],
                ],
                [
                    'title' => 'vehicle-types',
                    'icon' => 'fas fa-car',
                    'children' => [
                        [
                            'title' => 'all vehicle-types',
                            'icon' => 'fas fa-van-shuttle',
                            'route' => 'transportations.vehicle-types.index',
                        ],
                        [
                            'title' => 'create vehicle-type',
                            'icon' => 'fas fa-plus',
                            'route' => 'transportations.vehicle-types.create',
                        ],
                        [
                            'title' => 'import vehicle-types',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationVehicleType', 'models' => 'transportations-vehicle-types', 'view' => 'transportations.vehicle-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'routes',
                    'icon' => 'fas fa-route',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all routes',
                            'icon' => 'fas fa-map-marked-alt',
                            'route' => 'transportations.routes.index',
                        ],
                        [
                            'title' => 'create route',
                            'icon' => 'fas fa-plus',
                            'route' => 'transportations.routes.create',
                        ],
                        [
                            'title' => 'import routes',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRoute', 'models' => 'transportations-routes', 'view' => 'transportations.routes'],
                        ],
                    ],
                ],
                [
                    'title' => 'route assignments',
                    'icon' => 'fas fa-share-nodes',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all route assignments',
                            'icon' => 'fas fa-list',
                            'route' => 'transportations.route-assignments.index',
                        ],
                        [
                            'title' => 'create route assignment',
                            'icon' => 'fas fa-plus',
                            'route' => 'transportations.route-assignments.create',
                        ],
                        [
                            'title' => 'import route assignments',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRouteAssignment', 'models' => 'transportations-route-assignments', 'view' => 'transportations.route-assignments'],
                        ],
                    ],
                ],
                [
                    'title' => 'pricings',
                    'icon' => 'fas fa-dollar-sign',
                    'children' => [
                        [
                            'title' => 'all pricings',
                            'icon' => 'fas fa-tags',
                            'route' => 'transportations.pricings.index',
                        ],
                        [
                            'title' => 'create pricing',
                            'icon' => 'fas fa-plus',
                            'route' => 'transportations.pricings.create',
                        ],
                        [
                            'title' => 'import pricings',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationPricing', 'models' => 'transportations-pricings', 'view' => 'transportations.pricings'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fas fa-calendar-days',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fas fa-calendar-check',
                            'route' => 'seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['t' => Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'season', 'models' => 'seasons', 'view' => 'seasons'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fas fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fas fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
                            'route' => 'supplements.create',
                            'parameters' => ['type' => 'transportation'],
                        ],
                        [
                            'title' => 'import supplements',
                            'icon' => 'fas fa-file-import',
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
            'icon' => 'fas fa-utensils',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'fas fa-utensils',
                    'children' => [
                        [
                            'title' => 'all restaurants',
                            'icon' => 'fas fa-utensils',
                            'route' => 'restaurants.index',
                        ],
                        [
                            'title' => 'create restaurant',
                            'icon' => 'fas fa-plus',
                            'route' => 'restaurants.create',
                        ],
                        [
                            'title' => 'import restaurants',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'restaurant', 'models' => 'restaurants', 'view' => 'restaurants'],
                        ],
                    ],
                ],
                [
                    'title' => 'meals',
                    'icon' => 'fas fa-bowl-food',
                    'children' => [
                        [
                            'title' => 'all meals',
                            'icon' => 'fas fa-bowl-rice',
                            'route' => 'meals.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fas fa-plus',
                            'route' => 'meals.create',
                            'parameters' => ['type' => 'restaurant'],
                        ],
                        [
                            'title' => 'import meals',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'meal', 'models' => 'meals', 'view' => 'meals'],
                        ],
                    ],
                ],
                [
                    'title' => 'supplements',
                    'icon' => 'fas fa-circle-plus',
                    'children' => [
                        [
                            'title' => 'all supplements',
                            'icon' => 'fas fa-list-check',
                            'route' => 'supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
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
            'icon' => 'fas fa-book',
            'children' => [
                [
                    'title' => 'pricing definitions',
                    'icon' => 'fas fa-money-bill-wave',
                    'children' => [
                        [
                            'title' => 'all pricing definitions',
                            'icon' => 'fas fa-list',
                            'route' => 'pricing-definitions.index',
                        ],
                        [
                            'title' => 'create pricing definition',
                            'icon' => 'fas fa-plus',
                            'route' => 'pricing-definitions.create',
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides =================
        [
            'title' => 'tour-guides',
            'icon' => 'fas fa-person-hiking',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'guides',
                    'icon' => 'fas fa-person-hiking',
                    'children' => [
                        [
                            'title' => 'all guides',
                            'icon' => 'fas fa-people-group',
                            'route' => 'tours.guides.index'
                        ],
                        [
                            'title' => 'create guide',
                            'icon' => 'fas fa-plus',
                            'route' => 'tours.guides.create'
                        ],
                        [
                            'title' => 'import guides',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuide', 'models' => 'tours-guides', 'view' => 'tours.guides'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides-types',
                    'icon' => 'fas fa-tags',
                    'children' => [
                        [
                            'title' => 'all guides-types',
                            'icon' => 'fas fa-layer-group',
                            'route' => 'tours.guides-types.index'
                        ],
                        [
                            'title' => 'create guide-type',
                            'icon' => 'fas fa-plus',
                            'route' => 'tours.guides-types.create'
                        ],
                        [
                            'title' => 'import guides-types',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuideType', 'models' => 'tours-guides-types', 'view' => 'tours.guides-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'guides-reviews',
                    'icon' => 'fas fa-star-half-stroke',
                    'children' => [
                        [
                            'title' => 'all guides-reviews',
                            'icon' => 'fas fa-star',
                            'route' => 'tours.guides-reviews.index'
                        ],
                        [
                            'title' => 'create guide-review',
                            'icon' => 'fas fa-plus',
                            'route' => 'tours.guides-reviews.create'
                        ],
                        [
                            'title' => 'import guides-reviews',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'tourGuideReview', 'models' => 'tours-guides-reviews', 'view' => 'tours.guides-reviews'],
                        ],
                    ],
                ],
                [
                    'title' => 'seasons',
                    'icon' => 'fas fa-calendar-days',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fas fa-calendar-check',
                            'route' => 'seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'tours'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-plus',
                            'route' => 'seasons.create',
                            'parameters' => ['t' => Str::random(120), 'type' => 'tours'],
                        ],
                        [
                            'title' => 'import seasons',
                            'icon' => 'fas fa-file-import',
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
            'icon' => 'fas fa-plane-departure',
            'children' => [
                [
                    'title' => 'airlines',
                    'icon' => 'fas fa-plane-up',
                    'route' => 'airlines.index'
                ],
                [
                    'title' => 'create airline',
                    'icon' => 'fas fa-plus',
                    'route' => 'airlines.create'
                ],
                [
                    'title' => 'import airlines',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'airline', 'models' => 'airlines', 'view' => 'airlines'],
                ],
            ],
        ],

        // ================= Tourist Sites =================
        [
            'title' => 'tourist sites',
            'icon' => 'fas fa-map-location-dot',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all tourist sites',
                    'icon' => 'fas fa-landmark',
                    'route' => 'tourist-sites.index'
                ],
                [
                    'title' => 'create tourist site',
                    'icon' => 'fas fa-plus',
                    'route' => 'tourist-sites.create'
                ],
                [
                    'title' => 'import tourist sites',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'tourist-site', 'models' => 'tourist-sites', 'view' => 'tourist-sites'],
                ],
            ],
        ],

        // ================= Tourist Services =================
        [
            'title' => 'tourist services',
            'icon' => 'fas fa-map-location-dot',
            'status' => 'updated',
            'children' => [
                [
                    'title' => 'all tourist services',
                    'icon' => 'fas fa-landmark',
                    'route' => 'tourist-services.index'
                ],
                [
                    'title' => 'create tourist service',
                    'icon' => 'fas fa-plus',
                    'route' => 'tourist-services.create'
                ],
                [
                    'title' => 'import tourist services',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'tourist-service', 'models' => 'tourist-services', 'view' => 'tourist-services'],
                ],
            ],
        ],


        // ================= Jeep Safari =================
        [
            'title' => 'jeep_safari',
            'icon' => 'fa-solid fa-truck-monster',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all_jeeps',
                    'icon' => 'fa-solid fa-list',
                    'route' => 'jeeps.index'
                ],
                [
                    'title' => 'create_jeep',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'jeeps.create'
                ],
                // [
                //     'title' => 'import jeeps',
                //     'icon' => 'fas fa-file-import',
                //     'route' => 'import.data',
                //     'parameters' => ['model' => 'jeep', 'models' => 'jeeps', 'view' => 'jeeps'],
                // ]
            ]
        ],

        // ================= Visa Requirements =================
        [
            'title' => 'visa requirements',
            'icon' => 'fa-solid fa-passport',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all visa requirements',
                    'icon' => 'fa-solid fa-list',
                    'route' => 'visa-requirements.index'
                ],
                [
                    'title' => 'create visa requirement',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'visa-requirements.create'
                ],
                // [
                //     'title' => 'import visa requirements',
                //     'icon' => 'fas fa-file-import',
                //     'route' => 'import.data',
                //     'parameters' => ['model' => 'visa-requirement', 'models' => 'visa-requirements', 'view' => 'visa-requirements'],
                // ]
            ],
        ],

        // ================= Travel Passes =================
        [
            'title' => 'travel passes',
            'icon' => 'fa-solid fa-ticket',
            'status' => 'new',
            'children' => [
                [
                    'title' => 'all travel passes',
                    'icon' => 'fa-solid fa-list',
                    'route' => 'travel-passes.index'
                ],
                [
                    'title' => 'create travel pass',
                    'icon' => 'fa-solid fa-square-plus',
                    'route' => 'travel-passes.create'
                ],
                // [
                //     'title' => 'import travel passes',
                //     'icon' => 'fa-solid fa-file-import',
                //     'route' => 'import.data',
                //     'parameters' => ['models' => 'travel-passes'],
                // ],
            ],
        ],

        // ================= Crossings & Ports =================
        [
            'title' => 'crossings & ports',
            'icon' => 'fas fa-signs-post',
            'children' => [
                [
                    'title' => 'all crossings ports',
                    'icon' => 'fas fa-list',
                    'route' => 'crossings-ports.index'
                ],
                [
                    'title' => 'create crossing port',
                    'icon' => 'fas fa-plus',
                    'route' => 'crossings-ports.create'
                ],
                [
                    'title' => 'import crossings ports',
                    'icon' => 'fas fa-file-import',
                    'route' => 'import.data',
                    'parameters' => ['model' => 'crossings-port', 'models' => 'crossings-ports', 'view' => 'crossings-ports'],
                ],
                [
                    'title' => 'airports',
                    'icon' => 'fas fa-plane-departure',
                    'children' => [
                        [
                            'title' => 'international airports',
                            'icon' => 'fas fa-globe',
                            'route' => 'crossings-ports.filtered',
                            'parameters' => ['t' => Str::random(120), 'filtered' => 'international-airports'],
                        ],
                        [
                            'title' => 'domestic airports',
                            'icon' => 'fas fa-plane',
                            'route' => 'crossings-ports.filtered',
                            'parameters' => ['t' => Str::random(120), 'filtered' => 'domestic-airports'],
                        ],
                    ],
                ],
                [
                    'title' => 'seaports',
                    'icon' => 'fas fa-ship',
                    'route' => 'crossings-ports.filtered',
                    'parameters' => ['t' => Str::random(120), 'filtered' => 'seaports'],
                ],
            ],
        ],

        // ================= Reports =================
        [
            'title' => 'reports & analytics',
            'icon' => 'fas fa-chart-pie',
            'children' => [
                [
                    'title' => 'reports dashboard',
                    'icon' => 'fas fa-gauge',
                    'route' => 'reports.index'
                ],
                [
                    'title' => 'user reports',
                    'icon' => 'fas fa-user-chart',
                    'route' => 'reports.users'
                ],
                [
                    'title' => 'location reports',
                    'icon' => 'fas fa-map-marked',
                    'route' => 'reports.locations'
                ],
                [
                    'title' => 'detailed analytics',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'reports.analytics'
                ],
            ],
        ],

        // ================= Activity Log =================
        [
            'title' => 'activity log',
            'icon' => 'fas fa-clipboard-list',
            'route' => 'activity-log.index',
        ],

        // ================= Notifications =================
        // [
        //     'title' => 'notifications',
        //     'icon' => 'fas fa-bell',
        //     'route' => 'notifications.index',
        // ],

        // ================= Languages =================
        [
            'title' => 'languages',
            'icon' => 'fas fa-language',
            'children' => [
                [
                    'title' => 'all languages',
                    'icon' => 'fas fa-language',
                    'route' => 'languages.index'
                ],
                [
                    'title' => 'create language',
                    'icon' => 'fas fa-square-plus',
                    'route' => 'languages.create'
                ]
            ],
        ],

        // ================= System Languages =================
        [
            'title' => 'system languages',
            'icon' => 'fas fa-globe',
            'children' => [
                [
                    'title' => 'all languages',
                    'icon' => 'fas fa-globe',
                    'route' => 'system-languages.index'
                ],
                [
                    'title' => 'create language',
                    'icon' => 'fas fa-plus',
                    'route' => 'system-languages.create'
                ]
            ],
        ],

        // ================= Profile =================
        [
            'title' => 'profile',
            'icon' => 'fas fa-id-badge',
            'children' => [
                [
                    'title' => 'view profile',
                    'icon' => 'fas fa-circle-user',
                    'route' => 'profile.index'
                ],
                [
                    'title' => 'edit profile',
                    'icon' => 'fas fa-pen-to-square',
                    'route' => 'profile.edit'
                ],
                [
                    'title' => 'change password',
                    'icon' => 'fas fa-key',
                    'route' => 'profile.change_password'
                ],
            ],
        ],

        // ================= Media Files =================
        [
            'title' => 'media files',
            'icon' => 'fas fa-photo-film',
            'children' => [
                [
                    'title' => 'all media files',
                    'icon' => 'fas fa-file-image',
                    'route' => 'media-files.index',
                ],
                [
                    'title' => 'upload files',
                    'icon' => 'fas fa-upload',
                    'route' => 'media-files.create',
                ],
            ],
        ],

        // ================= Settings =================
        [
            'title' => 'settings',
            'icon' => 'fas fa-gear',
            'children' => [
                [
                    'title' => 'general',
                    'icon' => 'fas fa-sliders',
                    'route' => 'settings.general',
                ],
                [
                    'title' => 'security',
                    'icon' => 'fas fa-shield-halved',
                    'route' => 'settings.security',
                    'roles' => ['admin', 'superadmin']
                ],
                // [
                //     'title' => 'notifications',
                //     'route' => 'settings.notifications'
                // ],
                [
                    'title' => 'backup',
                    'icon' => 'fas fa-database',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.backup'
                ],
                [
                    'title' => 'booking',
                    'icon' => 'fas fa-book',
                    'fixed' => 'soon',
                    'route' => '#'
                    // 'route' => 'settings.booking'
                ],
                [
                    'title' => 'integration',
                    'icon' => 'fas fa-plug',
                    'route' => 'settings.integration',
                    'roles' => ['admin', 'superadmin']
                ],
                [
                    'title' => 'system',
                    'icon' => 'fas fa-cog',
                    'route' => 'settings.system'
                ],
            ],
        ],
    ],
];
