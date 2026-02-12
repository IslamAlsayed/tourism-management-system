<?php

use Illuminate\Support\Str;

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'fas fa-gauge',
            'route' => 'dashboard',
        ],

        // ================= Subscriptions =================
        // [
        //     'title' => 'subscriptions',
        //     'icon' => 'fas fa-box',
        //     'children' => [
        //         [
        //             'title' => 'my modules',
        //             'icon' => 'fas fa-puzzle-piece',
        //             'route' => 'dashboard.subscriptions.my-modules',
        //         ],
        //         [
        //             'title' => 'all subscriptions',
        //             'icon' => 'fas fa-list-check',
        //             'route' => 'dashboard.subscriptions.index',
        //         ],
        //     ],
        // ],

        // ================= Core - النظام =================
        [
            'title' => 'core',
            'icon' => 'fas fa-gear',
            'fixed' => 'done',
            'label' => 'system',
            'children' => [
                // ================= Users - المستخدمين =================
                [
                    'title' => 'users',
                    'icon' => 'fas fa-users-gear',
                    'children' => [
                        [
                            'title' => 'all users',
                            'icon' => 'fas fa-users',
                            'route' => 'dashboard.core.users.index',
                        ],
                        [
                            'title' => 'create user',
                            'icon' => 'fas fa-user-plus',
                            'route' => 'dashboard.core.users.create',
                        ],
                        [
                            'title' => 'import users',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'user', 'models' => 'users', 'view' => 'users'],
                        ]
                    ],
                ],
                // ================= Roles & Permissions - الأدوار والصلاحيات =================
                [
                    'title' => 'roles_and_permissions',
                    'icon' => 'fas fa-shield',
                    'children' => [
                        [
                            'title' => 'roles',
                            'icon' => 'fas fa-crown',
                            'route' => 'dashboard.core.roles.index',
                        ],
                        [
                            'title' => 'create role',
                            'icon' => 'fas fa-square-plus',
                            'route' => 'dashboard.core.roles.create',
                        ],
                        [
                            'title' => 'permissions',
                            'icon' => 'fas fa-lock',
                            'route' => 'dashboard.core.permissions.index',
                        ],
                        [
                            'title' => 'create permission',
                            'icon' => 'fas fa-square-plus',
                            'route' => 'dashboard.core.permissions.create',
                        ]
                    ],
                ],
                // ================= Reports & Analytics - التقارير والتحليلات =================
                [
                    'title' => 'reports & analytics',
                    'icon' => 'fas fa-chart-pie',
                    'children' => [
                        [
                            'title' => 'reports dashboard',
                            'icon' => 'fas fa-gauge',
                            'route' => 'dashboard.core.reports.index'
                        ],
                        [
                            'title' => 'user reports',
                            'icon' => 'fas fa-user-chart',
                            'route' => 'dashboard.core.reports.users'
                        ],
                        [
                            'title' => 'location reports',
                            'icon' => 'fas fa-map-marked',
                            'route' => 'dashboard.core.reports.locations'
                        ],
                        [
                            'title' => 'detailed analytics',
                            'icon' => 'fas fa-chart-line',
                            'route' => 'dashboard.core.reports.analytics'
                        ],
                    ],
                ],
                // ================= Topics - المواضيع =================
                [
                    'title' => 'pricing definitions',
                    'icon' => 'fas fa-money-bill-wave',
                    'children' => [
                        [
                            'title' => 'all pricing definitions',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.core.pricing-definitions.index',
                        ],
                        [
                            'title' => 'create pricing definition',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.core.pricing-definitions.create',
                        ],
                    ],
                ],
                // ================= Notifications - الإشعارات =================
                // [
                //     'title' => 'notifications',
                //     'icon' => 'fas fa-bell',
                //     'route' => 'notifications.index',
                // ],
                // ================= Activity Log - سجل النشاط =================
                [
                    'title' => 'activity log',
                    'icon' => 'fas fa-clipboard-list',
                    'children' => [
                        [
                            'title' => 'all activities',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.core.activity-log.index',
                        ],
                        [
                            'title' => 'user activities',
                            'icon' => 'fas fa-user',
                            'route' => 'dashboard.core.activity-log.users',
                        ],
                        [
                            'title' => 'system activities',
                            'icon' => 'fas fa-cogs',
                            'route' => 'dashboard.core.activity-log.system',
                        ],
                    ],
                ],
                // ================= Profile - الملف الشخصي =================
                [
                    'title' => 'profile',
                    'icon' => 'fas fa-id-badge',
                    'children' => [
                        [
                            'title' => 'view profile',
                            'icon' => 'fas fa-circle-user',
                            'route' => 'dashboard.core.profile.index'
                        ],
                        [
                            'title' => 'edit profile',
                            'icon' => 'fas fa-pen-to-square',
                            'route' => 'dashboard.core.profile.edit'
                        ],
                        [
                            'title' => 'change password',
                            'icon' => 'fas fa-key',
                            'route' => 'dashboard.core.profile.change_password'
                        ],
                    ],
                ],
                // ================= Settings - الإعدادات =================
                [
                    'title' => 'settings',
                    'icon' => 'fas fa-gear',
                    'children' => [
                        [
                            'title' => 'general',
                            'icon' => 'fas fa-sliders',
                            'route' => 'dashboard.core.settings.general',
                        ],
                        [
                            'title' => 'security',
                            'icon' => 'fas fa-shield-halved',
                            'route' => 'dashboard.core.settings.security',
                            'roles' => ['admin', 'superadmin']
                        ],
                        // [
                        //     'title' => 'notifications',
                        //     'route' => 'dashboard.core.settings.notifications'
                        // ],
                        [
                            'title' => 'backup',
                            'icon' => 'fas fa-database',
                            'fixed' => 'soon',
                            // 'route' => '#'
                            // 'route' => 'dashboard.core.settings.backup'
                        ],
                        [
                            'title' => 'booking',
                            'icon' => 'fas fa-book',
                            'fixed' => 'soon',
                            // 'route' => '#'
                            // 'route' => 'dashboard.core.settings.booking'
                        ],
                        [
                            'title' => 'integration',
                            'icon' => 'fas fa-plug',
                            'route' => 'dashboard.core.settings.integration',
                            'roles' => ['admin', 'superadmin']
                        ],
                        [
                            'title' => 'system',
                            'icon' => 'fas fa-cog',
                            'route' => 'dashboard.core.settings.system'
                        ],
                    ],
                ],
            ],
        ],

        // ================= Geography - الجغرافيا =================
        [
            'title' => 'geography',
            'icon' => 'fas fa-location-dot',
            'status' => 'done',
            'label' => 'geography',
            'children' => [
                // ================= Regions - المناطق =================
                [
                    'title' => 'regions',
                    'icon' => 'fas fa-globe',
                    'children' => [
                        [
                            'title' => 'all regions',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.regions.index',
                        ],
                        [
                            'title' => 'create region',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.regions.create',
                        ],
                        [
                            'title' => 'import regions',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'region', 'models' => 'regions', 'view' => 'regions'],
                        ],
                    ],
                ],
                // ================= Subregions - المناطق الفرعية =================
                [
                    'title' => 'subregions',
                    'icon' => 'fas fa-layer-group',
                    'children' => [
                        [
                            'title' => 'all subregions',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.subregions.index',
                        ],
                        [
                            'title' => 'create subregion',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.subregions.create',
                        ],
                        [
                            'title' => 'import subregions',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'subregion', 'models' => 'subregions', 'view' => 'subregions'],
                        ],
                    ],
                ],
                // ================= Countries - الدول =================
                [
                    'title' => 'countries',
                    'icon' => 'fas fa-earth-americas',
                    'children' => [
                        [
                            'title' => 'all countries',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.countries.index'
                        ],
                        [
                            'title' => 'create country',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.countries.create',
                        ],
                        [
                            'title' => 'import countries',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'country', 'models' => 'countries', 'view' => 'countries'],
                        ],
                    ],
                ],
                // ================= States - الولايات =================
                [
                    'title' => 'states',
                    'icon' => 'fas fa-map',
                    'children' => [
                        [
                            'title' => 'all states',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.states.index',
                        ],
                        [
                            'title' => 'create state',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.states.create',
                        ],
                        [
                            'title' => 'import states',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'state', 'models' => 'states', 'view' => 'states'],
                        ],
                    ],
                ],
                // ================= Cities - المدن =================
                [
                    'title' => 'cities',
                    'icon' => 'fa-regular fa-building',
                    'children' => [
                        [
                            'title' => 'all cities',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.cities.index',
                        ],
                        [
                            'title' => 'create city',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.cities.create',
                        ],
                        [
                            'title' => 'import cities',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'city', 'models' => 'cities', 'view' => 'cities'],
                        ],
                    ],
                ],
                // ================= Nationalities - الجنسيات =================
                [
                    'title' => 'nationalities',
                    'icon' => 'fa-regular fa-id-card',
                    'children' => [
                        [
                            'title' => 'all nationalities',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.geography.nationalities.index',
                        ],
                        [
                            'title' => 'create nationality',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.geography.nationalities.create',
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

        // ================= Localization - التعريب =================
        [
            'title' => 'localization',
            'icon' => 'fas fa-earth-africa',
            'fixed' => 'done',
            'label' => 'localization',
            'children' => [
                // ================= Languages - اللغات =================
                [
                    'title' => 'languages',
                    'icon' => 'fas fa-globe',
                    'children' => [
                        [
                            'title' => 'all languages',
                            'icon' => 'fas fa-globe',
                            'route' => 'dashboard.localization.languages.index'
                        ],
                        [
                            'title' => 'create language',
                            'icon' => 'fas fa-square-plus',
                            'route' => 'dashboard.localization.languages.create'
                        ]
                    ],
                ],
                // ================= System Languages - لغات النظام =================
                [
                    'title' => 'system languages',
                    'icon' => 'fas fa-language',
                    'children' => [
                        [
                            'title' => 'all languages',
                            'icon' => 'fas fa-language',
                            'route' => 'dashboard.localization.system-languages.index'
                        ],
                        [
                            'title' => 'create language',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.localization.system-languages.create'
                        ]
                    ],
                ],
                // ================= Currencies - العملات =================
                [
                    'title' => 'currencies',
                    'icon' => 'fas fa-dollar-sign',
                    'children' => [
                        [
                            'title' => 'all currencies',
                            'icon' => 'fas fa-coins',
                            'route' => 'dashboard.localization.currencies.index',
                        ],
                        [
                            'title' => 'create currency',
                            'icon' => 'fas fa-square-plus',
                            'route' => 'dashboard.localization.currencies.create',
                        ],
                        [
                            'title' => 'import currencies',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'currency', 'models' => 'currencies', 'view' => 'currencies'],
                        ],
                    ],
                ],
                // ================= Timezones - المناطق الزمنية =================
                [
                    'title' => 'timezones',
                    'icon' => 'fas fa-clock',
                    'children' => [
                        [
                            'title' => 'all timezones',
                            'icon' => 'fas fa-clock',
                            'route' => 'dashboard.localization.timezones.index',
                        ],
                        [
                            'title' => 'create timezone',
                            'icon' => 'fas fa-square-plus',
                            'route' => 'dashboard.localization.timezones.create',
                        ],
                        [
                            'title' => 'import timezones',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'timezone', 'models' => 'timezones', 'view' => 'timezones'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Tour Guides - مرشدين سياحيين =================
        [
            'title' => 'tour-guides',
            'icon' => 'fas fa-person-hiking',
            'fixed' => 'done',
            'label' => 'tour-guides',
            'children' => [
                // ================= Tour Guides =================
                [
                    'title' => 'guides',
                    'icon' => 'fas fa-person-hiking',
                    'children' => [
                        [
                            'title' => 'all guides',
                            'icon' => 'fas fa-people-group',
                            'route' => 'dashboard.tourguides.guides.index'
                        ],
                        [
                            'title' => 'create guide',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.tourguides.guides.create'
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
                            'route' => 'dashboard.tourguides.guides-types.index'
                        ],
                        [
                            'title' => 'create guide-type',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.tourguides.guides-types.create'
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
                            'route' => 'dashboard.tourguides.guides-reviews.index'
                        ],
                        [
                            'title' => 'create guide-review',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.tourguides.guides-reviews.create'
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
                    'children' => [
                        [
                            'title' => 'all seasons',
                            'icon' => 'fas fa-calendar-check',
                            'route' => 'dashboard.accommodations.seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'tours'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.seasons.create',
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
            ]
        ],

        // ================= Accommodations - الاقامات =================
        [
            'title' => 'accommodations',
            'icon' => 'fas fa-building',
            'fixed' => 'done',
            'label' => 'accommodations',
            'children' => [
                [
                    'title' => 'accommodations',
                    'icon' => 'fas fa-utensils',
                    'children' => [
                        [
                            'title' => 'all accommodations',
                            'icon' => 'fas fa-hotel',
                            'route' => 'dashboard.accommodations.index',
                        ],
                        [
                            'title' => 'create accommodation',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.create',
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
                            'route' => 'dashboard.accommodations.types.index',
                        ],
                        [
                            'title' => 'create type',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.types.create',
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
                            'route' => 'dashboard.accommodations.rooms.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create room',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.rooms.create',
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
                            'route' => 'dashboard.accommodations.seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-calendar-plus',
                            'route' => 'dashboard.accommodations.seasons.create',
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
                            'route' => 'dashboard.accommodations.meals.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.meals.create',
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
                            'route' => 'dashboard.accommodations.supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'accommodation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.supplements.create',
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

        // ================= Restaurants - المطاعم =================
        [
            'title' => 'restaurants',
            'icon' => 'fas fa-utensils',
            'fixed' => 'done',
            'label' => 'restaurants',
            'children' => [
                [
                    'title' => 'restaurants',
                    'icon' => 'fas fa-utensils',
                    'children' => [
                        [
                            'title' => 'all restaurants',
                            'icon' => 'fas fa-hotel',
                            'route' => 'dashboard.restaurants.index',
                        ],
                        [
                            'title' => 'create accommodation',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.restaurants.create',
                        ],
                        [
                            'title' => 'import restaurants',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'accommodation', 'models' => 'restaurants', 'view' => 'restaurants'],
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
                            'route' => 'dashboard.accommodations.meals.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create meal',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.meals.create',
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
                            'route' => 'dashboard.accommodations.supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'restaurant'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.supplements.create',
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

        // ================= Transportation - النقل =================
        [
            'title' => 'transportation',
            'icon' => 'fas fa-bus',
            'fixed' => 'done',
            'label' => 'transportation',
            'children' => [
                [
                    'title' => 'companies',
                    'icon' => 'fas fa-building',
                    'children' => [
                        [
                            'title' => 'all companies',
                            'icon' => 'fas fa-building-user',
                            'route' => 'dashboard.transportation.companies.index',
                        ],
                        [
                            'title' => 'create company',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.transportation.companies.create',
                        ],
                        [
                            'title' => 'import companies',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationCompany', 'models' => 'transportations-companies', 'view' => 'transportation.companies'],
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
                            'route' => 'dashboard.transportation.vehicle-types.index',
                        ],
                        [
                            'title' => 'create vehicle-type',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.transportation.vehicle-types.create',
                        ],
                        [
                            'title' => 'import vehicle-types',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationVehicleType', 'models' => 'transportations-vehicle-types', 'view' => 'transportation.vehicle-types'],
                        ],
                    ],
                ],
                [
                    'title' => 'jeep_safari',
                    'icon' => 'fa-solid fa-truck-monster',
                    'children' => [
                        [
                            'title' => 'all_jeeps',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'dashboard.transportation.jeeps.index'
                        ],
                        [
                            'title' => 'create_jeep',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'dashboard.transportation.jeeps.create'
                        ],
                        // [
                        //     'title' => 'import jeeps',
                        //     'icon' => 'fas fa-file-import',
                        //     'route' => 'import.data',
                        //     'parameters' => ['model' => 'jeep', 'models' => 'jeeps', 'view' => 'jeeps'],
                        // ]
                    ]
                ],
                [
                    'title' => 'routes',
                    'icon' => 'fas fa-route',
                    'children' => [
                        [
                            'title' => 'all routes',
                            'icon' => 'fas fa-map-marked-alt',
                            'route' => 'dashboard.transportation.routes.index',
                        ],
                        [
                            'title' => 'create route',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.transportation.routes.create',
                        ],
                        [
                            'title' => 'import routes',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRoute', 'models' => 'transportations-routes', 'view' => 'transportation.routes'],
                        ],
                    ],
                ],
                [
                    'title' => 'route assignments',
                    'icon' => 'fas fa-share-nodes',
                    'children' => [
                        [
                            'title' => 'all route assignments',
                            'icon' => 'fas fa-list',
                            'route' => 'dashboard.transportation.route-assignments.index',
                        ],
                        [
                            'title' => 'create route assignment',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.transportation.route-assignments.create',
                        ],
                        [
                            'title' => 'import route assignments',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationRouteAssignment', 'models' => 'transportations-route-assignments', 'view' => 'transportation.route-assignments'],
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
                            'route' => 'dashboard.transportation.pricings.index',
                        ],
                        [
                            'title' => 'create pricing',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.transportation.pricings.create',
                        ],
                        [
                            'title' => 'import pricings',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'transportationPricing', 'models' => 'transportations-pricings', 'view' => 'transportation.pricings'],
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
                            'route' => 'dashboard.accommodations.seasons.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create season',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.seasons.create',
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
                            'route' => 'dashboard.accommodations.supplements.index',
                            'parameters' => ['t' => Str::random(120), 'type' => 'transportation'],
                        ],
                        [
                            'title' => 'create supplement',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.accommodations.supplements.create',
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

        // ================= Travel Documents - المستندات السفر =================
        [
            'title' => 'travel documents',
            'icon' => 'fas fa-passport',
            'fixed' => 'done',
            'label' => 'travel documents',
            'children' => [
                [
                    'title' => 'visa requirements',
                    'icon' => 'fa-solid fa-passport',
                    'children' => [
                        [
                            'title' => 'all visa requirements',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'dashboard.traveldocuments.visa-requirements.index'
                        ],
                        [
                            'title' => 'create visa requirement',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'dashboard.traveldocuments.visa-requirements.create'
                        ],
                        // [
                        //     'title' => 'import visa requirements',
                        //     'icon' => 'fas fa-file-import',
                        //     'route' => 'import.data',
                        //     'parameters' => ['model' => 'visa-requirement', 'models' => 'visa-requirements', 'view' => 'visa-requirements'],
                        // ]
                    ],
                ],
                [
                    'title' => 'travel passes',
                    'icon' => 'fa-solid fa-ticket',
                    'children' => [
                        [
                            'title' => 'all travel passes',
                            'icon' => 'fa-solid fa-list',
                            'route' => 'dashboard.traveldocuments.travel-passes.index'
                        ],
                        [
                            'title' => 'create travel pass',
                            'icon' => 'fa-solid fa-square-plus',
                            'route' => 'dashboard.traveldocuments.travel-passes.create'
                        ],
                        // [
                        //     'title' => 'import travel passes',
                        //     'icon' => 'fa-solid fa-file-import',
                        //     'route' => 'import.data',
                        //     'parameters' => ['models' => 'travel-passes'],
                        // ],
                    ],
                ],
            ]
        ],

        // ================= CRM - أدارة العملاء =================
        [
            'title' => 'crm',
            'icon' => 'fas fa-address-book',
            'fixed' => 'done',
            'label' => 'crm',
            'children' => [
                [
                    'title' => 'clients',
                    'icon' => 'fas fa-user-group',
                    'children' => [
                        [
                            'title' => 'all clients',
                            'icon' => 'fas fa-user-group',
                            'route' => 'dashboard.crm.clients.index',
                        ],
                        [
                            'title' => 'create client',
                            'icon' => 'fas fa-user-plus',
                            'route' => 'dashboard.crm.clients.create',
                        ],
                        [
                            'title' => 'import clients',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'client', 'models' => 'clients', 'view' => 'clients'],
                        ]
                    ],
                ],
            ]
        ],

        // ================= Tourists - السياح =================
        [
            'title' => 'tourists',
            'icon' => 'fas fa-box',
            'fixed' => 'done',
            'label' => 'tourists',
            'children' => [
                [
                    'title' => 'sites',
                    'icon' => 'fas fa-map-location-dot',
                    'children' => [
                        [
                            'title' => 'all sites',
                            'icon' => 'fas fa-map-location-dot',
                            'route' => 'dashboard.tourists.sites.index',
                        ],
                        [
                            'title' => 'create site',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.tourists.sites.create',
                        ],
                        [
                            'title' => 'import sites',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'site', 'models' => 'sites', 'view' => 'sites'],
                        ]
                    ],
                ],
                [
                    'title' => 'services',
                    'icon' => 'fab fa-servicestack',
                    'children' => [
                        [
                            'title' => 'all services',
                            'icon' => 'fab fa-servicestack',
                            'route' => 'dashboard.tourists.services.index',
                        ],
                        [
                            'title' => 'create service',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.tourists.services.create',
                        ],
                        [
                            'title' => 'import services',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'service', 'models' => 'services', 'view' => 'services'],
                        ],
                    ],
                ],
            ],
        ],

        // ================= Entry Points - نقاط الدخول =================
        [
            'title' => 'entry points',
            'icon' => 'fas fa-signs-post',
            'fixed' => 'done',
            'label' => 'system',
            'children' => [
                [
                    'title' => 'land crossings',
                    'icon' => 'fas fa-bridge',
                    'children' => [
                        [
                            'title' => 'all land crossings',
                            'icon' => 'fas fa-bridge',
                            'route' => 'dashboard.entrypoints.land-crossings.index',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'create land crossing',
                            'icon' => 'fas fa-user-plus',
                            'route' => 'dashboard.entrypoints.land-crossings.create',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'import land crossings',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'land-crossing', 'models' => 'land-crossings', 'view' => 'land-crossings'],
                        ]
                    ],
                ],
                [
                    'title' => 'sea ports',
                    'icon' => 'fas fa-ship',
                    'children' => [
                        [
                            'title' => 'all sea ports',
                            'icon' => 'fas fa-ship',
                            'route' => 'dashboard.entrypoints.seaports.index',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'create sea port',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.entrypoints.seaports.create',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'import sea ports',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'seaport', 'models' => 'seaports', 'view' => 'seaports'],
                        ]
                    ],
                ],
                [
                    'title' => 'airports',
                    'icon' => 'fas fa-plane-departure',
                    'children' => [
                        [
                            'title' => 'all airports',
                            'icon' => 'fas fa-plane-departure',
                            'route' => 'dashboard.entrypoints.airports.index',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'create airport',
                            'icon' => 'fas fa-plus',
                            'route' => 'dashboard.entrypoints.airports.create',
                            'parameters' => ['t' => Str::random(120)],
                        ],
                        [
                            'title' => 'import airports',
                            'icon' => 'fas fa-file-import',
                            'route' => 'import.data',
                            'parameters' => ['model' => 'airport', 'models' => 'airports', 'view' => 'airports'],
                        ]
                    ],
                ],
            ]
        ],

        // ================= Air Transport - النقل الجوي =================
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

        // ================= Crossings & Ports - المعابر والموانئ =================
        // [
        //     'title' => 'crossings & ports',
        //     'icon' => 'fas fa-signs-post',
        //     'children' => [
        //         [
        //             'title' => 'all crossings ports',
        //             'icon' => 'fas fa-list',
        //             'route' => 'crossings-ports.index'
        //         ],
        //         [
        //             'title' => 'create crossing port',
        //             'icon' => 'fas fa-plus',
        //             'route' => 'crossings-ports.create'
        //         ],
        //         [
        //             'title' => 'import crossings ports',
        //             'icon' => 'fas fa-file-import',
        //             'route' => 'import.data',
        //             'parameters' => ['model' => 'crossings-port', 'models' => 'crossings-ports', 'view' => 'crossings-ports'],
        //         ],
        //         [
        //             'title' => 'airports',
        //             'icon' => 'fas fa-plane-departure',
        //             'children' => [
        //                 [
        //                     'title' => 'international airports',
        //                     'icon' => 'fas fa-globe',
        //                     'route' => 'crossings-ports.filtered',
        //                     'parameters' => ['t' => Str::random(120), 'filtered' => 'international-airports'],
        //                 ],
        //                 [
        //                     'title' => 'domestic airports',
        //                     'icon' => 'fas fa-plane',
        //                     'route' => 'crossings-ports.filtered',
        //                     'parameters' => ['t' => Str::random(120), 'filtered' => 'domestic-airports'],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'title' => 'seaports',
        //             'icon' => 'fas fa-ship',
        //             'route' => 'crossings-ports.filtered',
        //             'parameters' => ['t' => Str::random(120), 'filtered' => 'seaports'],
        //         ],
        //     ],
        // ],

        // ================= Media Files - الملفات الإعلامية =================
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
    ],
];
