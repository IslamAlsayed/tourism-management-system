<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Season;
use App\Models\RichText;
use App\Models\Restaurant;
use App\Models\Supplement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        Restaurant::truncate();
        Schema::enableForeignKeyConstraints();

        // Create 5 Restaurants (مطاعم مستقلة عن restaurants)
        $restaurants = [
            [
                'name' => 'Nile Maxim Restaurant',
                'name_ar' => 'مطعم نايل ماكسيم',
                'specialty' => 'Egyptian Cuisine',
            ],
            [
                'name' => 'Hashem Restaurant',
                'name_ar' => 'مطعم هاشم',
                'specialty' => 'Traditional Jordanian',
            ],
            [
                'name' => 'Al Qasr Restaurant',
                'name_ar' => 'مطعم القصر',
                'specialty' => 'Middle Eastern Cuisine',
            ],
            [
                'name' => 'Sultanahmet Köftecisi',
                'name_ar' => 'سلطان أحمد كوفتيجي',
                'specialty' => 'Turkish Meatballs',
            ],
        ];

        foreach ($restaurants as $restaurantData) {
            $restaurant = Restaurant::factory()->create($restaurantData);

            // Create 2-3 seasons for this restaurant
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
                    'model_id' => $restaurant->id,
                    'model_type' => get_class($restaurant),
                ]);
            }

            // Create 3-5 meal plans for this restaurant
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
                    'currency_id' => $restaurant->currency_id ?? \App\Models\Currency::inRandomOrder()->first()?->id,
                    'price' => rand(10, 100),
                    'is_included' => $mealData['included'],
                    'is_supplement' => !$mealData['included'],
                    'is_active' => true,
                    'model_id' => $restaurant->id,
                    'model_type' => get_class($restaurant),
                ]);
            }

            // Create 3-5 supplements for this restaurant
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
                    'price_type' => fake()->randomElement(['per_person', 'per_night', 'one_time']),
                    'is_mandatory' => rand(0, 1) == 1,
                    'is_active' => true,
                    'notes' => 'Supplement for ' . $restaurant->name,
                    'model_id' => $restaurant->id,
                    'model_type' => get_class($restaurant),
                ]);
            }
        }
    }
}