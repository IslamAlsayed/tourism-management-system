<?php

namespace Modules\Accommodations\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Accommodations\Entities\Supplement;

class SupplementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Supplement::class);
        RichText::where('record_type', Supplement::class)->delete();
    }
}
