<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Restaurants\Entities\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Al Tazaj',
                'name_ar' => 'الطازج',
                'company_name' => 'شركة لؤلؤة الطازج',
                'specialty' => 'International',
                'phone_01' => '5540055',
                'phone_02' => '5514053',
                'fax' => '5514230',
                'email_01' => 'a.yaghi@tazaj.jo',
                'street' => 'شارع وصفي التل',
                'region_id' => 3,
                'subregion_id' => 23,
                'country_id' => 111,
                'city_id' => 63141,
                'cat' => 2,
                'type_id' => 1, // Tourist Restaurant
                'is_active' => true,
            ],
            [
                'name' => 'Mammia',
                'name_ar' => 'ماما ميا/شميساني',
                'company_name' => 'شركة وضاح الداوودي',
                'specialty' => 'International',
                'phone_01' => '5666064',
                'phone_02' => '0',
                'fax' => '5561070',
                'email_01' => 'admin@ncss.jo',
                'street' => 'الشميساني',
                'region_id' => 3,
                'subregion_id' => 23,
                'country_id' => 111,
                'city_id' => 63141,
                'cat' => 2,
                'type_id' => 6, // International
                'is_active' => true,
            ],
            [
                'name' => 'Ala Hawak',
                'name_ar' => 'ع هواك / تشيلي هاوس',
                'company_name' => 'شركة وليد الطعيمة',
                'specialty' => 'Local',
                'phone_01' => '5538778',
                'phone_02' => '777999100',
                'fax' => '777999100',
                'contact_person' => 'معتز طعمه',
                'email_01' => 'mataz1111@yahoo.com',
                'postal_code' => '1997',
                'street' => 'وصفي التل',
                'region_id' => 3,
                'subregion_id' => 23,
                'country_id' => 111,
                'city_id' => 63141,
                'cat' => 2,
                'type_id' => 8, // Local / Middle Eastern
                'is_active' => true,
            ],
            [
                'name' => 'e3jab',
                'name_ar' => 'قصر دجلة',
                'company_name' => 'حاتم عبد الحافظ',
                'specialty' => 'Sea Food',
                'phone_01' => '5535543',
                'email_01' => 'hatemhafez@gmail.com',
                'box' => '963142',
                'postal_code' => '11196',
                'street' => 'شارع المدينة المنورة',
                'region_id' => 3,
                'subregion_id' => 23,
                'country_id' => 111,
                'city_id' => 63141,
                'cat' => 2,
                'type_id' => 9, // Sea Food
                'is_active' => true,
            ],
            [
                'name' => 'Ayam Zaman',
                'name_ar' => 'ايام زمان',
                'company_name' => 'شركة غدير وعماد',
                'specialty' => 'International',
                'phone_01' => '799900255',
                'phone_02' => '799900255',
                'fax' => '799900255',
                'postal_code' => '53',
                'street' => 'شارع الرينبو',
                'region_id' => 3,
                'subregion_id' => 23,
                'country_id' => 111,
                'city_id' => 63141,
                'cat' => 2,
                'type_id' => 6, // International
                'is_active' => true,
            ],
        ];

        foreach ($restaurants as $data) {
            Restaurant::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
