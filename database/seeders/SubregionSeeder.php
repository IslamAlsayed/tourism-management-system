<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Subregion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SubregionSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Subregion::truncate();
        Schema::enableForeignKeyConstraints();

        // Subregion::insert([
        //     ['name' => 'Levant', 'wiki_data_id' => 'Q35323', 'region_id' => Region::where('name', 'Middle East')->first()?->id],
        //     ['name' => 'Maghreb', 'wiki_data_id' => 'Q27479', 'region_id' => Region::where('name', 'North Africa')->first()?->id],
        // ]);
    }
}