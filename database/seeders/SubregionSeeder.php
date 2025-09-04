<?php

namespace Database\Seeders;

use App\Models\Subregion;
use Illuminate\Database\Seeder;
use App\Models\Region;

class SubregionSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Subregion::create([
                'name' => "subregion $i",
                'region_id' => Region::inRandomOrder()->first()?->id ?? 1,
                'wikiDataId' => "Q" . rand(100000, 999999),
            ]);
        }
    }
}