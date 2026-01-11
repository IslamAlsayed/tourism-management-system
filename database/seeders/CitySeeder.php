<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        RichText::where('record_type', City::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}