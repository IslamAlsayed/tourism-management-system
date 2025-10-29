<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\OtherService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OtherServiceSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        OtherService::truncate();
        Schema::enableForeignKeyConstraints();

        OtherService::insert([
            [
                'name' => 'Licensed Tourist Guide',
                'name_ar' => 'دليل سياحي مرخص',
                'price_type' => 'Per Day',
                'price' => fake()->randomFloat(2, 50, 150),
                // 'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,s
            ],
            [
                'name' => '4x4 Jeep in Wadi Rum',
                'name_ar' => 'جيب 4x4 في وادي رم',
                'price_type' => 'Per Group',
                'price' => fake()->randomFloat(2, 50, 150),
                // 'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,s
            ],
            [
                'name' => 'Petra Entrance Fee',
                'name_ar' => 'رسوم دخول البتراء',
                'price_type' => 'Per Person',
                'price' => fake()->randomFloat(2, 50, 150),
                // 'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,s
            ]
        ]);
    }
}