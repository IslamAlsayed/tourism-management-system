<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    public function run()
    {
        DB::table('routes')->insert([
            [
                'name_ar' => 'عمان - البحر الميت',
                'name_en' => 'Amman - Dead Sea',
                'description' => 'From Amman to Dead Sea via Madaba.',
            ],
            [
                'name_ar' => 'عمان - البتراء',
                'name_en' => 'Amman - Petra',
                'description' => 'From Amman to Petra via Kings Highway.',
            ]
        ]);
    }
}
