<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelRoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelRoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HotelRoomType::truncate();
        Schema::enableForeignKeyConstraints();

        $roomTypes = [
            ['name' => 'Single', 'name_ar' => 'مفردة', 'max_occupancy' => 1],
            ['name' => 'Double', 'name_ar' => 'مزدوجة', 'max_occupancy' => 2],
            ['name' => 'Suite', 'name_ar' => 'جناح', 'max_occupancy' => 3],
        ];

        // foreach (Hotel::all() as $hotel) {
        //     foreach ($roomTypes as $type) {
        //         HotelRoomType::create(array_merge($type, [
        //             'hotel_id' => $hotel->id,
        //         ]));
        //     }
        // }
    }
}