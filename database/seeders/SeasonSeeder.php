<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Season::class);
        RichText::where('record_type', Season::class)->delete();
    }
}
