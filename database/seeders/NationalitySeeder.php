<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Nationality::truncate();
        Schema::enableForeignKeyConstraints();

        Nationality::insert([
            [
                'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? 1,
                'nationality_ar' => 'مصري',
                'nationality_en' => 'Egyptian',
                'is_active' => true,
                'nationality_id' => null,
            ],
            [
                'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? 1,
                'nationality_ar' => 'أردني',
                'nationality_en' => 'Jordanian',
                'is_active' => true,
                'nationality_id' => null,
            ],
        ]);
    }
}