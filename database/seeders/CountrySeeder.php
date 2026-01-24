<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Country::class);
        RichText::where('record_type', Country::class)->delete();
    }
}
