<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccommodationRateNationalitySeeder extends Seeder
{
    public function run()
    {
        DB::table('accommodation_rate_nationality')->insert([
            [
                'accommodation_rate_id' => 1,
                'nationality_id' => null, // متاح لجميع الجنسيات
                'is_all' => true,
            ],
            [
                'accommodation_rate_id' => 2,
                'nationality_id' => 1, // مثال لجنسية محددة
                'is_all' => false,
            ],
            [
                'accommodation_rate_id' => 2,
                'nationality_id' => 2, // مثال لجنسية ثانية
                'is_all' => false,
            ],
        ]);
    }
}
