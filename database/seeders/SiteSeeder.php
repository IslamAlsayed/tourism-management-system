<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Site;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SiteSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Site::truncate();
        Schema::enableForeignKeyConstraints();

        Site::insert([
            [
                'name' => 'Petra',
                'name_ar' => 'البتراء',
                'entry_fee' => fake()->randomFloat(2, 30, 100),
                'city_id' => City::inRandomOrder()->first()?->id ?? 1,
            ],
            [
                'name' => 'Jerash',
                'name_ar' => 'جرش',
                'entry_fee' => fake()->randomFloat(2, 30, 100),
                'city_id' => City::inRandomOrder()->first()?->id ?? 1,
            ]
        ]);
    }
}