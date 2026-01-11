<?php

namespace Database\Seeders;

use App\Models\Nationality;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Nationality::truncate();
        RichText::where('record_type', Nationality::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}