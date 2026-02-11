<?php

namespace Modules\TourGuides\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\TourGuides\Entities\TourGuideType;

class TourGuideTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(TourGuideType::class);
        RichText::where('record_type', TourGuideType::class)->delete();

        // $types = [
        //     ['type' => 'Standard Guide', 'price' => 100.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id],
        //     ['type' => 'Specialized Guide', 'price' => 150.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id],
        //     ['type' => 'Private Guide', 'price' => 200.00, 'currency_id' => Currency::inRandomOrder()->first()?->id, 'country_id' => Country::inRandomOrder()->first()?->id]
        // ];
        // foreach ($types as $typeData) {
        //     TourGuideType::updateOrCreate($typeData);
        // }
    }
}
