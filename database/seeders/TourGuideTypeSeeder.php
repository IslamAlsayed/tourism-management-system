<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\RichText;
use App\Models\Subregion;
use App\Models\TourGuideType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TourGuideTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TourGuideType::truncate();
        RichText::where('record_type', TourGuideType::class)->delete();
        Schema::enableForeignKeyConstraints();

        $types = [
            ['type' => 'Standard Guide', 'price' => 100.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'region_id' => Currency::inRandomOrder()->first()?->id, 'subregion_id' => Subregion::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id],
            ['type' => 'Specialized Guide', 'price' => 150.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'region_id' => Currency::inRandomOrder()->first()?->id, 'subregion_id' => Subregion::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id],
            ['type' => 'Private Guide', 'price' => 200.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'region_id' => Currency::inRandomOrder()->first()?->id, 'subregion_id' => Subregion::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id]
        ];
        foreach ($types as $typeData) {
            TourGuideType::updateOrCreate($typeData);
        }
    }
}