<?php

namespace Database\Seeders;

use App\Models\Supplement;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SupplementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Supplement::truncate();
        RichText::where('record_type', Supplement::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}