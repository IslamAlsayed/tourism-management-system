<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nationalities')->insert([
            [
                'country_id' => 1,
                'nationality_ar' => 'أردني',
                'nationality_en' => 'Jordanian',
                'is_active' => true,
                'nationality_id' => null,
            ],
            [
                'country_id' => 2,
                'nationality_ar' => 'مصري',
                'nationality_en' => 'Egyptian',
                'is_active' => true,
                'nationality_id' => null,
            ],
        ]);
    }
}
