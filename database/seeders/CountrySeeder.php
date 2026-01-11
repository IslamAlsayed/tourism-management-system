<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        RichText::where('record_type', Country::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}