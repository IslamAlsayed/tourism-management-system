<?php

namespace Modules\Geography\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Geography\Entities\City;

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
