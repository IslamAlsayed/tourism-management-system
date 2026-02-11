<?php

namespace Modules\Transportation\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Country;
use Spatie\Permission\Models\Permission;
use Modules\Transportation\Entities\Jeep;
use Modules\Localization\Entities\Currency;
use Modules\Transportation\Entities\Company;

class JeepSeeder extends Seeder
{
    public function run()
    {
        truncateWithReset(Jeep::class);
        RichText::where('record_type', Jeep::class)->delete();

        $permissions = [
            'create_jeeps',
            'edit_jeeps',
            'delete_jeeps',
            'view_jeeps',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole       = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Superadmin → everything
        $superadminRole->syncPermissions(Permission::all());

        // Admin → jeep permissions
        $adminPermissions = Permission::whereIn('name', $permissions)->get();
        $adminRole->syncPermissions($adminPermissions);

        // User → view only
        $userRole->syncPermissions(Permission::where('name', 'view_jeeps')->get());

        // 1. Get Currency (JOD)
        $currency = Currency::where('code', 'JOD')->first() ?? Currency::first();

        // 2. Get Location (Jordan -> Aqaba -> Wadi Rum)
        $country = Country::where('name', 'Jordan')->orWhere('name', 'like', '%Jordan%')->first();
        $state = null;
        $city = null;

        if ($country) {
            $state = State::where('country_id', $country->id)
                ->where(function ($q) {
                    $q->where('name', 'Aqaba')->orWhere('name', 'like', '%Aqaba%');
                })->first();

            if ($state) {
                $city = City::where('state_id', $state->id)
                    ->where(function ($q) {
                        $q->where('name', 'Wadi Rum')->orWhere('name', 'like', '%Wadi Rum%');
                    })->first();
            }
        }

        // 3. Get or Create Default Company
        $company = Company::firstOrCreate(
            ['name' => 'Wadi Rum Bedouin Tours'],
            ['name_ar' => 'جولات البدو وادي رم']
        );

        // Prepare Location IDs
        $locationData = [
            'region_id' => $country?->region_id,
            'subregion_id' => $country?->subregion_id,
            'country_id' => $country?->id,
            'state_id' => $state?->id,
            'city_id' => $city?->id,
        ];

        // 4. Define Trips
        $trips = [
            [
                'route' => 'Rum 01 - Lawrence spring (Rum Village - Nabataean Temple - Lawrence spring)',
                'route_ar' => 'عين لورانس (قرية رم - المعبد النبطي - عين لورانس)',
                'duration' => 1,
                'duration_unit' => 'hours',
                'distance' => 14,
                'distance_unit' => 'km',
                'price' => 30,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 02 - Khazali canyon (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon)',
                'route_ar' => 'الخزعلي (قرية رم - المعبد النبطي - عين لورانس - سيق الخزعلي)',
                'duration' => 2,
                'duration_unit' => 'hours',
                'distance' => 30,
                'distance_unit' => 'km',
                'price' => 40,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 03 - Sunset or Sunshine (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Sunset)',
                'route_ar' => 'الغروب أو رحلة شروق (قرية رم - المعبد النبطي - عين لورانس - سيق الخزعلي - الغروب)',
                'duration' => 2.5,
                'duration_unit' => 'hours',
                'distance' => 35,
                'distance_unit' => 'km',
                'price' => 49,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 04 - Sand Dunes (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Sand Dunes)',
                'route_ar' => 'الرمال (قرية رم - المعبد النبطي - عين لورانس - سيق الخزعلي - الرمال)',
                'duration' => 3.5,
                'duration_unit' => 'hours',
                'distance' => 40,
                'distance_unit' => 'km',
                'price' => 56,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 05 - Little bridge (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Little bridge)',
                'route_ar' => 'البرج الصغير (قرية رم - المعبد النبطي - عين لورانس - سيق الخزعلي - البرج الصغير)',
                'duration' => 3,
                'duration_unit' => 'hours',
                'distance' => 35,
                'distance_unit' => 'km',
                'price' => 49,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 06 - Lawrence house (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Little bridge - Lawrence house - Anfishiyyeh - Sand Dunes)',
                'route_ar' => 'بيت لورانس (قرية رم - المعبد النبطي - عين لورانس - سيق الخزعلي - البرج الصغير - بيت لورانس - نقوش النفشية الثمودية - الرمال)',
                'duration' => 3.5,
                'duration_unit' => 'hours',
                'distance' => 45,
                'distance_unit' => 'km',
                'price' => 64,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 07 - Um Fruth Rock Bridge (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Little bridge - Um Fruth rock bridge - Lawrence house - Anfishiyyeh - Sand Dunes)',
                'route_ar' => 'برج أم فروث (قرية رم - المعبد النبطي - عين لورانس - الخزعلي - البرج الصغير - برج ام فروث - بيت لورانس - نقوش النفشية الثمودية - الرمال)',
                'duration' => 4,
                'duration_unit' => 'hours',
                'distance' => 50,
                'distance_unit' => 'km',
                'price' => 72,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 08 - Burdah rock bridge (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Little bridge - Lawrence house - Burdah rock bridge - Sand Dunes - Sunset)',
                'route_ar' => 'برج بردة (قرية رم - المعبد النبطي - عين لورانس - الخزعلي - البرج الصغير - برج ام فروث - برج بردة - بيت لورنس - نقوش النفيشية - الرمال - الخارطة - الغروب)',
                'duration' => 5,
                'duration_unit' => 'hours',
                'distance' => 60,
                'distance_unit' => 'km',
                'price' => 80,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 09 - Barrah canyon (Rum Village - Nabataean Temple - Lawrence spring - Khazali canyon - Little bridge - Um Fruth rock bridge - Burdah rock bridge - Sunset)',
                'route_ar' => 'سيق البرة (قرية رم - المعبد النبطي - عين لورانس - الخزعلي - البرج الصغير - برج أم فروث - برج بردة - الغروب)',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 65,
                'distance_unit' => 'km',
                'price' => 85,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 10 - Daily fare for luggage',
                'route_ar' => 'رم - الأجرة اليومية للأمتعة',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 0,
                'distance_unit' => 'km',
                'price' => 62,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Rum 11 - Daily fare for passengers',
                'route_ar' => 'رم - الأجرة اليومية للركاب',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 0,
                'distance_unit' => 'km',
                'price' => 85,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 01 - Al-Amleih',
                'route_ar' => 'الامليح',
                'duration' => 1,
                'duration_unit' => 'hours',
                'distance' => 15,
                'distance_unit' => 'km',
                'price' => 30,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 02 - Siq Umm Al-Tawaki (Ramlat Al-Hasani - Al-Amleih - Siq Umm Al-Tawaki)',
                'route_ar' => 'سيق ام الطواقي (رمال الحصاني - الامليح - سيق ام الطواقي)',
                'duration' => 2,
                'duration_unit' => 'hours',
                'distance' => 18,
                'distance_unit' => 'km',
                'price' => 40,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 03 - Sunset or Sunrise (Ramlat Al-Hasani - Al-Amleih - Siq Umm Al-Tawaki - Sunset)',
                'route_ar' => 'الغروب او الشروق ( رمال الحصاني - الامليح - سيق ام الطواقي - الغروب)',
                'duration' => 2.5,
                'duration_unit' => 'hours',
                'distance' => 20,
                'distance_unit' => 'km',
                'price' => 49,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 04 - Al-Barrah (Umm Ashreen - Lawrence’s House - Al-Barrah - Al-Amleih - Siq Umm Al-Tawaki)',
                'route_ar' => 'البرة (ام عشرين - بيت لورنس - البرة - الامليح - سيق ام الطواقي).',
                'duration' => 3,
                'duration_unit' => 'hours',
                'distance' => 40,
                'distance_unit' => 'km',
                'price' => 56,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 05 - Barda (Ramlat Al-Hasani - Al-Amleih - Khor Umm Ashreen - Lawrence’s House - Umm Froth - Barda)',
                'route_ar' => 'بردة (رمال الحصاني - الامليح - خور ام عشرين - بيت لورنس - ام فروث - بردة).',
                'duration' => 4,
                'duration_unit' => 'hours',
                'distance' => 50,
                'distance_unit' => 'km',
                'price' => 72,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 06 - Full day Barda (Ramlat Al-Hasani - Al-Amleih - Umm Ashreen - Lawrence’s House - Umm Froth - Barda - Siq Umm Al-Tawaki - Sunset)',
                'route_ar' => 'بردة يوم كامل (رمال الحصاني - الامليح - ام عشرين - بيت لورنس - ام فروث - بردة - سيق ام الطواقي - الغروب).',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 80,
                'distance_unit' => 'km',
                'price' => 85,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 07 - Daily Fare for Luggage',
                'route_ar' => 'الديسة - الاجرة اليومية للامتعة',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 0,
                'distance_unit' => 'km',
                'price' => 62,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
            [
                'route' => 'Dissi 08 - Daily fare for passengers',
                'route_ar' => 'الديسة - الاجرة اليومية للركاب',
                'duration' => 8,
                'duration_unit' => 'hours',
                'distance' => 0,
                'distance_unit' => 'km',
                'price' => 85,
                'origin_city_id' => City::inRandomOrder()->first()?->id,
                'destination_city_id' => City::inRandomOrder()->first()?->id,
            ],
        ];

        foreach ($trips as $trip) {
            $priceType = 'per_vehicle';
            if (str_contains(strtolower($trip['route']), 'passenger')) {
                $priceType = 'per_person';
            } elseif (str_contains(strtolower($trip['route']), 'luggage')) {
                $priceType = 'per_trip';
            }

            Jeep::create(array_merge([
                'route' => $trip['route'],
                'route_ar' => $trip['route_ar'],
                'duration' => $trip['duration'],
                'duration_unit' => $trip['duration_unit'],
                'distance' => $trip['distance'],
                'distance_unit' => $trip['distance_unit'],
                'price' => $trip['price'],
                'currency_id' => $currency->id ?? null,
                'price_type' => $priceType,
                'origin_city_id' => $trip['origin_city_id'],
                'destination_city_id' => $trip['destination_city_id'],
                'company_id' => $company->id,
                'car_seats' => 6,
                'vehicle_model' => 'Standard Jeep',
                'model_year' => '2024',
                'has_ac' => true,
                'has_driver' => true,
                'is_4x4' => true,
                'status' => 'active',
                'is_featured' => false,
            ], $locationData));
        }

        $this->command->info("Seeded " . count($trips) . " Jeep Safari trips successfully.");
    }
}
