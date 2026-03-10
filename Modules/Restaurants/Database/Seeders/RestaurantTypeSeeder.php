<?php

namespace Modules\Restaurants\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Restaurants\Entities\RestaurantType;

class RestaurantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Tourist Restaurant', 'name_ar' => 'مطعم سياحي'],
            ['name' => 'Popular Restaurant', 'name_ar' => 'مطعم شعبي'],
            ['name' => 'Fast Food', 'name_ar' => 'وجبات سريعة'],
            ['name' => 'Cafe', 'name_ar' => 'مقهى'],
            ['name' => 'Resort Restaurant', 'name_ar' => 'مطعم متنزه'],
            ['name' => 'International', 'name_ar' => 'مطعم عالمي'],
            ['name' => 'Lebanese', 'name_ar' => 'مطعم لبناني'],
            ['name' => 'Local / Middle Eastern', 'name_ar' => 'مطعم محلي / شرقي'],
            ['name' => 'Sea Food', 'name_ar' => 'مأكولات بحرية'],
            ['name' => 'Italian', 'name_ar' => 'مطعم إيطالي'],
            ['name' => 'Chinese & Japanese', 'name_ar' => 'مطعم صيني وياباني'],
            ['name' => 'French', 'name_ar' => 'مطعم فرنسي'],
            ['name' => 'American', 'name_ar' => 'مطعم أمريكي'],
            ['name' => 'Indian', 'name_ar' => 'مطعم هندي'],
            ['name' => 'Turkish', 'name_ar' => 'مطعم تركي'],
            ['name' => 'Mexican', 'name_ar' => 'مطعم مكسيكي'],
            ['name' => 'Grilled / BBQ', 'name_ar' => 'مشاوي'],
            ['name' => 'Sushi', 'name_ar' => 'سوشي'],
            ['name' => 'Snacks & Light Meals', 'name_ar' => 'وجبات خفيفة'],
        ];

        foreach ($types as $type) {
            RestaurantType::firstOrCreate(
                ['name' => $type['name']],
                ['name_ar' => $type['name_ar'], 'is_active' => true]
            );
        }
    }
}
