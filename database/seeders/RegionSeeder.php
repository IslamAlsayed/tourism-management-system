<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Region::truncate();
        Schema::enableForeignKeyConstraints();

        Region::insert([
            ['name' => 'Africa'],
            ['name' => 'Asia'],
            ['name' => 'Middle East'],
            ['name' => 'Europe'],
            ['name' => 'Americas'],
        ]);
    }
}