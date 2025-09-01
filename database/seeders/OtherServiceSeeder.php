<?php

namespace Database\Seeders;

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
                'name_ar' => 'دليل سياحي مرخص',
                'name_en' => 'Licensed Tourist Guide',
                'price_type' => 'Per Day',
                'price' => 70.00,
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
            ],
            [
                'name_ar' => 'جيب 4x4 في وادي رم',
                'name_en' => '4x4 Jeep in Wadi Rum',
                'price_type' => 'Per Group',
                'price' => 85.00,
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
            ]
        ]);
    }
}