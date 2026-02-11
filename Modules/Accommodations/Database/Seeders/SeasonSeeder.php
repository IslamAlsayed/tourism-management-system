<?php

namespace Modules\Accommodations\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Accommodations\Entities\Season;

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
