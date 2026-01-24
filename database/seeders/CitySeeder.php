<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(City::class);
        RichText::where('record_type', City::class)->delete();
    }
}
