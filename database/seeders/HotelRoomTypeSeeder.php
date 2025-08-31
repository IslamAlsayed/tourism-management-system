<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelRoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hotel_room_types')->insert([
            [
                'accommodation_id' => 1,
                'name_ar' => 'مفردة',
                'name_en' => 'Single',
                'max_occupancy' => 1,
            ],
            [
                'accommodation_id' => 2,
                'name_ar' => 'مزدوجة',
                'name_en' => 'Double',
                'max_occupancy' => 2,
            ],
            [
                'accommodation_id' => 3,
                'name_ar' => 'جناح',
                'name_en' => 'Suite',
                'max_occupancy' => 3,
            ],
        ]);
    }
}
