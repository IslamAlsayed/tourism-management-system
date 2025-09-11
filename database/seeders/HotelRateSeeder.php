<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelRate;
use App\Models\HotelSeason;
use App\Models\Accommodation;
use App\Models\HotelRoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelRateSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HotelRate::truncate();
        Schema::enableForeignKeyConstraints();

        // foreach (Hotel::all() as $hotel) {
        //     $roomTypes = HotelRoomType::where('hotel_id', $hotel->id)->get();
        //     $seasons = HotelSeason::where('hotel_id', $hotel->id)->get();

        //     foreach ($seasons as $season) {
        //         foreach ($roomTypes as $roomType) {
        //             HotelRate::create([
        //                 'meal_plan' => fake()->randomElement(['BB', 'HB', 'FB', 'AI']),
        //                 'rate_per_person' => fake()->randomFloat(2, 30, 200),
        //                 'single_supplement' => fake()->randomFloat(2, 10, 100),
        //                 'hotel_id' => $hotel->id,
        //                 'hotel_season_id' => $season->id,
        //                 'room_type_id' => $roomType->id,
        //                 'accommodation_id' => $hotel->accommodation_id,
        //             ]);
        //         }
        //     }
        // }

        foreach (Hotel::all() as $hotel) {
            $seasons = HotelSeason::where('hotel_id', $hotel->id)->get();
            $roomTypes = HotelRoomType::where('hotel_id', $hotel->id)->get(); // غرف الفندق نفسه

            foreach ($seasons as $season) {
                foreach ($roomTypes as $roomType) {
                    HotelRate::create([
                        'meal_plan' => fake()->randomElement(['BB', 'HB', 'FB', 'AI']),
                        'rate_per_person' => fake()->randomFloat(2, 30, 200),
                        'single_supplement' => fake()->randomFloat(2, 10, 100),
                        'hotel_id' => $hotel->id,
                        'hotel_season_id' => $season->id,
                        'room_type_id' => $roomType->id,
                        'accommodation_id' => $hotel->accommodation_id,
                    ]);
                }
            }
        }


        // for ($i = 0; $i < count(Hotel::all()); $i++) {
        //     HotelRate::create([
        //         'meal_plan' => fake()->randomElement(['BB', 'HB', 'FB', 'AI']),
        //         'rate_per_person' => fake()->randomFloat(2, 30, 200),
        //         'single_supplement' => fake()->randomFloat(2, 10, 100),
        //         'hotel_id' => Hotel::inRandomOrder()->first()?->id ?? 1,
        //         'hotel_season_id' => HotelSeason::inRandomOrder()->first()?->id ?? 1,
        //         'room_type_id' => HotelRoomType::inRandomOrder()->first()?->id ?? 1,
        //         'accommodation_id' => Accommodation::inRandomOrder()->first()?->id ?? 1,
        //     ]);
        // }
    }
}