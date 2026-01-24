<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Type;
use App\Models\Season;
use App\Models\RichText;
use App\Models\Supplement;
use App\Models\Accommodation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // حذف بيانات الإقامة القديمة
        truncateWithReset(Accommodation::class);
        RichText::where('record_type', Accommodation::class)->delete();
        // foreach ([Meal::class, Room::class, Season::class, Supplement::class] as $modelClass) {
        //     $modelClass::where('model_type', Accommodation::class)->delete();
        // }
        // foreach ([Accommodation::class, Meal::class, Room::class, Season::class, Supplement::class] as $modelClass) {
        //     RichText::where('record_type', $modelClass)->delete();
        // }
        Schema::enableForeignKeyConstraints();
        dd('done');

        // Get or create types (Hotel, Resort, Villa, Apartment, Hostel, etc.)
        $typeNames = [
            ['name' => 'Hotel', 'name_ar' => 'فندق'],
            ['name' => 'Resort', 'name_ar' => 'منتجع'],
            ['name' => 'Restaurant', 'name_ar' => 'مطعم'],
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

        foreach ($typeNames as $type) {
            Type::updateOrCreate(
                ['name' => $type['name']],
                ['name_ar' => $type['name_ar'], 'is_active' => true]
            );
        }

        // Create 5 Accommodations
        $accommodations = Accommodation::factory(5)->create();

        // For each accommodation, create its related data
        foreach ($accommodations as $accommodation) {
            // Create 2-3 seasons for this accommodation
            $seasonNames = [
                ['name' => 'Winter Season', 'name_ar' => 'موسم الشتاء', 'from' => '2024-12-01', 'to' => '2025-02-28'],
                ['name' => 'Spring Season', 'name_ar' => 'موسم الربيع', 'from' => '2025-03-01', 'to' => '2025-05-31'],
                ['name' => 'Summer Season', 'name_ar' => 'موسم الصيف', 'from' => '2025-06-01', 'to' => '2025-08-31'],
                ['name' => 'Autumn Season', 'name_ar' => 'موسم الخريف', 'from' => '2025-09-01', 'to' => '2025-11-30'],
                ['name' => 'Holiday Season', 'name_ar' => 'موسم الأعياد', 'from' => '2024-12-20', 'to' => '2025-01-10'],
            ];

            $selectedSeasons = collect($seasonNames)->random(rand(3, 5));
            foreach ($selectedSeasons as $seasonData) {
                Season::create([
                    'name' => $seasonData['name'],
                    'name_ar' => $seasonData['name_ar'],
                    'season_from' => $seasonData['from'],
                    'season_to' => $seasonData['to'],
                    'is_active' => true,
                    'notes' => 'Applicable for ' . $seasonData['name'],
                    'model_id' => $accommodation->id,
                    'model_type' => get_class($accommodation),
                ]);
            }

            // Create 3-5 room types for this accommodation
            $roomTypes = [
                ['name' => 'Single room', 'name_ar' => 'غرفة مفردة', 'max_occupancy' => 1, 'occupancy_details' => '1A'],
                ['name' => 'Double room', 'name_ar' => 'غرفة مزدوجة', 'max_occupancy' => 3, 'occupancy_details' => '2A+1C'],
                ['name' => 'Triple room', 'name_ar' => 'غرفة ثلاثية', 'max_occupancy' => 3, 'occupancy_details' => '3A'],
                ['name' => 'Quad room', 'name_ar' => 'غرفة رباعية', 'max_occupancy' => 4, 'occupancy_details' => '4A'],
                ['name' => 'Junior suite', 'name_ar' => 'جناح صغير', 'max_occupancy' => 2, 'occupancy_details' => '1A+1C'],
            ];

            $selectedRooms = collect($roomTypes)->random(rand(3, 5));
            foreach ($selectedRooms as $roomData) {
                Room::create([
                    'name' => $roomData['name'],
                    'name_ar' => $roomData['name_ar'],
                    'max_occupancy' => $roomData['max_occupancy'],
                    'occupancy_details' => $roomData['occupancy_details'],
                    'currency_id' => $accommodation->currency_id,
                    'price_per_person_double' => rand(50, 500),
                    'single_room_supplement' => rand(20, 100),
                    'triple_room_discount' => rand(10, 50),
                    'third_person_price' => rand(30, 200),
                    'extra_bed_price' => rand(25, 150),
                    'sea_view_supplement' => rand(30, 100),
                    'is_active' => true,
                    'model_id' => $accommodation->id,
                    'model_type' => get_class($accommodation),
                ]);
            }

            // Create 3-5 meal plans for this accommodation
            $mealTypes = [
                ['name' => 'Breakfast', 'name_ar' => 'إفطار', 'included' => true],
                ['name' => 'Lunch', 'name_ar' => 'غداء', 'included' => false],
                ['name' => 'Dinner', 'name_ar' => 'عشاء', 'included' => false],
                ['name' => 'Half Board', 'name_ar' => 'إقامة نصف إقامة', 'included' => true],
                ['name' => 'Full Board', 'name_ar' => 'إقامة كاملة', 'included' => true],
            ];

            $selectedMeals = collect($mealTypes)->random(rand(3, 5));
            foreach ($selectedMeals as $mealData) {
                Meal::create([
                    'name' => $mealData['name'],
                    'name_ar' => $mealData['name_ar'],
                    'currency_id' => $accommodation->currency_id ?? \App\Models\Currency::inRandomOrder()->first()?->id,
                    'price' => rand(10, 100),
                    'is_included' => $mealData['included'],
                    'is_supplement' => !$mealData['included'],
                    'is_active' => true,
                    'model_id' => $accommodation->id,
                    'model_type' => get_class($accommodation),
                ]);
            }

            // Create 3-5 supplements for this accommodation
            $supplementNames = [
                ['name' => 'Sea View Upgrade', 'name_ar' => 'ترقية إطلالة بحرية'],
                ['name' => 'Airport Transfer', 'name_ar' => 'نقل من/إلى المطار'],
                ['name' => 'Late Check-out', 'name_ar' => 'تأخير المغادرة'],
                ['name' => 'Extra Bed', 'name_ar' => 'سرير إضافي'],
                ['name' => 'Breakfast Upgrade', 'name_ar' => 'ترقية الإفطار'],
                ['name' => 'Spa Package', 'name_ar' => 'باقة سبا'],
                ['name' => 'City Tour', 'name_ar' => 'جولة في المدينة'],
                ['name' => 'New Year Gala Dinner', 'name_ar' => 'عشاء رأس السنة'],
                ['name' => 'Pool View Supplement', 'name_ar' => 'إضافة إطلالة حمام سباحة'],
            ];

            $selectedSupplements = collect($supplementNames)->random(rand(3, 5));
            foreach ($selectedSupplements as $supplementData) {
                Supplement::create([
                    'name' => $supplementData['name'],
                    'name_ar' => $supplementData['name_ar'],
                    'price' => rand(10, 200),
                    'price_type' => fake()->randomElement(['per_person', 'per_room', 'per_night', 'one_time']),
                    'is_mandatory' => rand(0, 1) == 1,
                    'is_active' => true,
                    'notes' => 'Supplement for ' . $accommodation->name,
                    'model_id' => $accommodation->id,
                    'model_type' => get_class($accommodation),
                ]);
            }
        }
    }
}
