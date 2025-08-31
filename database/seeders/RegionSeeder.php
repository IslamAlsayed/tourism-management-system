<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        Region::truncate();

        DB::table('regions')->insert([
            ['name' => 'Amman', 'wikiDataId' => null],
            ['name' => 'Aqaba', 'wikiDataId' => null],
        ]);
    }
}
