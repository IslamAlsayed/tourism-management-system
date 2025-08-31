<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherServiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('other_services')->insert([
            [
                'name_ar' => 'دليل سياحي مرخص',
                'name_en' => 'Licensed Tourist Guide',
                'price_type' => 'Per Day',
                'price' => 70.00,
                'currency_id' => 1,
            ],
            [
                'name_ar' => 'جيب 4x4 في وادي رم',
                'name_en' => '4x4 Jeep in Wadi Rum',
                'price_type' => 'Per Group',
                'price' => 85.00,
                'currency_id' => 1,
            ]
        ]);
    }
}
