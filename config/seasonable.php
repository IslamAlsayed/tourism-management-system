<?php

return [

    'accommodation' => [
        'model' => \App\Models\Accommodation::class,
        'foreign_key' => 'accommodation_id',
        'label' => 'main.accommodation',
    ],

    'transportation_company' => [
        'model' => \App\Models\TransportationCompany::class,
        'foreign_key' => 'company_id',
        'label' => 'main.transportation_company',
    ],

    // مستقبلاً:
    // 'restaurant' => [
    //     'model' => \App\Models\Restaurant::class,
    //     'foreign_key' => 'restaurant_id',
    //     'label' => 'main.restaurant',
    // ],

];