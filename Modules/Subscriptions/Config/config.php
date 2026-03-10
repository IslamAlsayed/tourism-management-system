<?php

return [
    'name' => 'Subscriptions',

    /*
    |--------------------------------------------------------------------------
    | Core Modules (Always Available)
    |--------------------------------------------------------------------------
    |
    | These modules are always available and cannot be disabled.
    |
    */
    'core_modules' => [
        'core',
        'geography',
        'localization',
    ],

    /*
    |--------------------------------------------------------------------------
    | Paid/Optional Modules
    |--------------------------------------------------------------------------
    |
    | These modules require an active subscription.
    |
    */
    'available_modules' => [
        'tour_guides' => [
            'name' => 'Tour Guides Management',
            'description' => 'Manage tour guides, types, languages, and reviews',
            'icon' => 'fas fa-person-hiking',
            'requires' => [], // Dependencies on other modules
        ],
        'accommodations' => [
            'name' => 'Accommodations Management',
            'description' => 'Manage hotels, rooms, seasons, meals, and supplements',
            'icon' => 'fas fa-building',
            'requires' => [],
        ],
        'experiences' => [
            'name' => 'Experiences & Tourist Sites',
            'description' => 'Manage tourist sites and services',
            'icon' => 'fas fa-map-location-dot',
            'requires' => [],
        ],
        'restaurants' => [
            'name' => 'Restaurants Management',
            'description' => 'Manage restaurants and dining experiences',
            'icon' => 'fas fa-utensils',
            'requires' => [],
        ],
        'transportation' => [
            'name' => 'Transportation Management',
            'description' => 'Manage companies, vehicles, routes, and pricing',
            'icon' => 'fas fa-bus',
            'requires' => [],
        ],
        'jeeps' => [
            'name' => 'Jeep Safari Management',
            'description' => 'Manage jeep safari experiences',
            'icon' => 'fas fa-truck-monster',
            'requires' => ['transportation'], // Requires transportation module
        ],
        'travel_documents' => [
            'name' => 'Travel Documents',
            'description' => 'Manage visa requirements and travel passes',
            'icon' => 'fas fa-passport',
            'requires' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Subscription Duration (in days)
    |--------------------------------------------------------------------------
    |
    | Default duration for new subscriptions if not specified.
    | Set to null for unlimited duration.
    |
    */
    'default_duration' => 365, // 1 year

    /*
    |--------------------------------------------------------------------------
    | Trial Period (in days)
    |--------------------------------------------------------------------------
    |
    | Trial period for new subscriptions.
    |
    */
    'trial_period' => 30,

    /*
    |--------------------------------------------------------------------------
    | Renewal Grace Period (in days)
    |--------------------------------------------------------------------------
    |
    | Grace period after expiration before subscription is fully deactivated.
    |
    */
    'grace_period' => 7,
];
