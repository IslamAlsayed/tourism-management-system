<?php

namespace Database\Seeders;

use App\Models\Supplement;
use App\Models\RichText;
use Illuminate\Database\Seeder;

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
