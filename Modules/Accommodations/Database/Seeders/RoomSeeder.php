<?php

namespace Modules\Accommodations\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Accommodations\Entities\Room;

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
