<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Models\Season;
use App\Models\Room;
use App\Models\Meal;
use App\Models\Accommodation;
use App\Models\AccommodationSeason;
use App\Models\AccommodationRoomRate;
use App\Models\AccommodationMealRate;
use App\Models\AccommodationType;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing data (using delete() instead of truncate() to handle rich_texts)
        AccommodationType::query()->delete();
        AccommodationMealRate::query()->delete();
        AccommodationRoomRate::query()->delete();
        AccommodationSeason::query()->delete();
        Accommodation::query()->delete();
        Type::query()->delete();
        Meal::query()->delete();
        Room::query()->delete();
        Season::query()->delete();

        // Get or create types (Hotel, Resort, Villa, Apartment, Hostel, etc.)
        $typeNames = [
            ['name' => 'Hotel', 'name_ar' => 'فندق'],
            ['name' => 'Resort', 'name_ar' => 'منتجع'],
            ['name' => 'Aparthotel', 'name_ar' => 'شقة فندقية'],
            ['name' => 'Apartment', 'name_ar' => 'شقة سياحية'],
            ['name' => 'Villa', 'name_ar' => 'فيلا'],
            ['name' => 'Guest houses', 'name_ar' => 'دار الضيافة'],
            ['name' => 'Condominium resort', 'name_ar' => 'كومباوند منتجع'],
            ['name' => 'Chalet', 'name_ar' => 'شاليه'],
            ['name' => 'Private vacation home', 'name_ar' => 'منزل خاص'],
            ['name' => 'Houseboat', 'name_ar' => 'قارب سكني'],
            ['name' => 'Hostel', 'name_ar' => 'هوستل'],
            ['name' => 'Camping', 'name_ar' => 'مخيم/كامب'],
            ['name' => 'Luxury tents', 'name_ar' => 'خيمة فاخرة'],
            ['name' => 'Safari stays', 'name_ar' => 'إقامة سفاري'],
            ['name' => 'Country house', 'name_ar' => 'بيت ريفي'],
            ['name' => 'Motel', 'name_ar' => 'موتيل'],
            ['name' => 'Farm', 'name_ar' => 'إقامة مزرعة'],
            ['name' => 'Pension', 'name_ar' => 'بنسيون'],
            ['name' => 'Private holiday home', 'name_ar' => 'منزل عطلة خاص'],
            ['name' => 'Cruise', 'name_ar' => 'مركب بحرية'],
            ['name' => 'Lodge', 'name_ar' => 'نُزُل '],
            ['name' => 'Bedouin camps', 'name_ar' => 'المخيمات البدوية'],
            ['name' => 'Nile Floating hotels/boats', 'name_ar' => 'المنتجعات العائمة'],
            ['name' => 'Heritage House', 'name_ar' => 'بيت شعبي تراثي'],
        ];

        $types = collect();
        foreach ($typeNames as $type) {
            $typeModel = Type::firstOrCreate(
                ['name' => $type['name']],
                ['name_ar' => $type['name_ar'], 'is_active' => true]
            );
            $types->push($typeModel);
        }

        // Create 5 Seasons
        $seasons = Season::factory(5)->create();

        // Create 5 Room
        $rooms = Room::factory(5)->create();

        // Create 5 Meal 
        $meals = Meal::factory(5)->create();

        // Create 5 Accommodations and link rates
        Accommodation::factory(5)->create()->each(function ($accommodation) use ($seasons, $rooms, $meals, $types) {
            // Link accommodation with 2-3 random types via accommodation_types pivot
            $linkedTypes = $types->random(rand(2, 3));
            foreach ($linkedTypes as $type) {
                $accommodation->types()->attach($type->id, [
                    'notes' => 'Featured as a ' . $type->name,
                ]);
            }

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
        $this->command->info("Created: " . count($typeNames) . " Types, 5 Seasons, 5 Room Types, 5 Meal Types, 5 Accommodations, {$accommodationSeasonCount} Accommodation-Season Links, Accommodation-Type Links, 5 Room Rates, 5 Meal Rates");
    }
}