<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Type::truncate();
        RichText::where('record_type', Type::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}