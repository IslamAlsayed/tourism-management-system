<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\AccommodationRateNationality;

class AccommodationRateNationalitySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        AccommodationRateNationality::truncate();
        Schema::enableForeignKeyConstraints();

        AccommodationRateNationality::insert([
            [
                'accommodation_rate_id' => \App\Models\AccommodationRate::inRandomOrder()->first()?->id ?? 1,
                'nationality_id' => \App\Models\Nationality::inRandomOrder()->first()?->id ?? null, // متاح لجميع الجنسيات
                'is_all' => true,
            ],
            [
                'accommodation_rate_id' => \App\Models\AccommodationRate::inRandomOrder()->first()?->id ?? 1,
                'nationality_id' => \App\Models\Nationality::inRandomOrder()->first()?->id ?? 1, // مثال لجنسية محددة
                'is_all' => false,
            ],
            [
                'accommodation_rate_id' => \App\Models\AccommodationRate::inRandomOrder()->first()?->id ?? 1,
                'nationality_id' => \App\Models\Nationality::inRandomOrder()->first()?->id ?? 2, // مثال لجنسية ثانية
                'is_all' => false,
            ],
        ]);
    }
}