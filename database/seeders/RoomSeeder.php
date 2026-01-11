<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Room::truncate();
        RichText::where('record_type', Room::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}