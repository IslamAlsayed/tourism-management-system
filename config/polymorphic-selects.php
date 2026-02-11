<?php

return [
    'accommodation' => [
        'model' => \Modules\Accommodations\Entities\Accommodation::class,
        'label' => 'accommodation',
    ],

    'restaurant' => [
        'model' => \Modules\Restaurants\Entities\Restaurant::class,
        'label' => 'restaurant',
    ],

    'transportation-company' => [
        'model' => \Modules\Transportation\Entities\Company::class,
        'label' => 'transportation',
    ],

    'tours' => [
        'model' => \Modules\TourGuides\Entities\TourGuide::class,
        'label' => 'tours.guide',
    ],
];
