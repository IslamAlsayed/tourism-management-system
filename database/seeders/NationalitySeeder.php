<?php

namespace Database\Seeders;

use Modules\Geography\Entities\Nationality;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Nationality::class);
        RichText::where('record_type', Nationality::class)->delete();
    }
}
