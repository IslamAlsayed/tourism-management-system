<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Region::truncate();
        Schema::enableForeignKeyConstraints();

        Region::insert([
            ['name' => 'Middle East', 'wiki_data_id' => 'Q7204'],
            ['name' => 'North Africa', 'wiki_data_id' => 'Q27479'],
        ]);
    }
}