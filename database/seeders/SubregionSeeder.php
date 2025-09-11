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

        $subregions = [
            [
                'name' => 'Western Asia',
                'region_id' => Region::where('name', 'Asia')->first()->id,
            ],
            [
                'name' => 'North Africa',
                'region_id' => Region::where('name', 'Africa')->first()->id,
            ],
            [
                'name' => 'East Africa',
                'region_id' => Region::where('name', 'Africa')->first()->id,
            ],
            [
                'name' => 'Gulf',
                'region_id' => Region::where('name', 'Asia')->first()->id,
            ],
            [
                'name' => 'Levant',
                'region_id' => Region::where('name', 'Asia')->first()->id,
            ],
            [
                'name' => 'South Europe',
                'region_id' => Region::where('name', 'Europe')->first()->id,
            ],
        ];

        Subregion::insert($subregions);
    }
}