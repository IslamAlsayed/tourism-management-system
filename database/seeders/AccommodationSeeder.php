<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccommodationType;
use App\Models\Season;
use App\Models\Room;
use App\Models\Meal;
use App\Models\Accommodation;
use App\Models\AccommodationSeason;
use App\Models\AccommodationRoomRate;
use App\Models\AccommodationMealRate;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing data (using delete() instead of truncate() to handle rich_texts)
        AccommodationMealRate::query()->delete();
        AccommodationRoomRate::query()->delete();
        AccommodationSeason::query()->delete();
        Accommodation::query()->delete();
        Meal::query()->delete();
        Room::query()->delete();
        Season::query()->delete();
        AccommodationType::query()->delete();

        // Create 24 Accommodation Types
        $types = AccommodationType::factory(24)->create();

        // Create 5 Seasons
        $seasons = Season::factory(5)->create();

        // Create 5 Room
        $rooms = Room::factory(5)->create();

        // Create 5 Meal 
        $meals = Meal::factory(5)->create();

        // Create 5 Accommodations and link rates
        Accommodation::factory(5)->create()->each(function ($accommodation) use ($seasons, $rooms, $meals) {
            // Link accommodation with random seasons (2-3 seasons per accommodation)
            $linkedSeasons = $seasons->random(rand(2, 3));
            foreach ($linkedSeasons as $season) {
                AccommodationSeason::create([
                    'accommodation_id' => $accommodation->id,
                    'season_id' => $season->id,
                    'notes' => 'Applicable for ' . $season->name,
                ]);
            }

            // Create room rates for each season and room type combination (5 rates per accommodation)
            $seasons->random(1)->each(function ($season) use ($accommodation, $rooms) {
                $rooms->random(1)->each(function ($room) use ($accommodation, $season) {
                    AccommodationRoomRate::factory()->create([
                        'accommodation_id' => $accommodation->id,
                        'season_id' => $season->id,
                        'room_id' => $room->id,
                    ]);
                });
            });

            // Create meal rates for each season and meal type combination (5 rates per accommodation)
            $seasons->random(1)->each(function ($season) use ($accommodation, $meals) {
                $meals->random(1)->each(function ($meal) use ($accommodation, $season) {
                    AccommodationMealRate::factory()->create([
                        'accommodation_id' => $accommodation->id,
                        'season_id' => $season->id,
                        'meal_id' => $meal->id,
                    ]);
                });
            });
        });

        $accommodationSeasonCount = AccommodationSeason::count();

        $this->command->info('Accommodation data seeded successfully!');
        $this->command->info("Created: 24 Types, 5 Seasons, 5 Room Types, 5 Meal Types, 5 Accommodations, {$accommodationSeasonCount} Accommodation-Season Links, 5 Room Rates, 5 Meal Rates");
    }
}