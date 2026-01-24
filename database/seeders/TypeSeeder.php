<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Type::class);
        RichText::where('record_type', Type::class)->delete();
    }
}
