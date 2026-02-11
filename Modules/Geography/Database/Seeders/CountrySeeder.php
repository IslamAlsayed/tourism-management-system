<?php

namespace Modules\Geography\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Geography\Entities\Country;

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
