<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RichText;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Room::class);
        RichText::where('record_type', Room::class)->delete();
    }
}
