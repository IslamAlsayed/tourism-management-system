<?php

namespace Database\Seeders;

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

        HotelRoomType::insert([
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'name_ar' => 'مفردة',
                'name_en' => 'Single',
                'max_occupancy' => 1,
            ],
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'name_ar' => 'مزدوجة',
                'name_en' => 'Double',
                'max_occupancy' => 2,
            ],
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'name_ar' => 'جناح',
                'name_en' => 'Suite',
                'max_occupancy' => 3,
            ],
        ]);
    }
}