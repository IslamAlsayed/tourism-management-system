<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    public function run()
    {
        DB::table('sites')->insert([
            [
                'name_ar' => 'البتراء',
                'name_en' => 'Petra',
                'entry_fee' => 50.00,
                'currency_id' => 1,
                'city' => 'Petra',
            ],
            [
                'name_ar' => 'جرش',
                'name_en' => 'Jerash',
                'entry_fee' => 10.00,
                'currency_id' => 1,
                'city' => 'Jerash',
            ]
        ]);
    }
}
