<?php

namespace Database\Seeders;

use Schema;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        $countries = [
            ['name' => 'Egypt', 'name_ar' => 'مصر', 'currency_id' => Currency::where('code', 'EGP')->first()?->id],
            ['name' => 'Saudi Arabia', 'name_ar' => 'السعودية', 'currency_id' => Currency::where('code', 'SAR')->first()?->id],
            ['name' => 'United Arab Emirates', 'name_ar' => 'الإمارات', 'currency_id' => Currency::where('code', 'AED')->first()?->id],
            ['name' => 'Jordan', 'name_ar' => 'الأردن', 'currency_id' => Currency::where('code', 'JOD')->first()?->id],
            ['name' => 'Lebanon', 'name_ar' => 'لبنان', 'currency_id' => Currency::where('code', 'LBP')->first()?->id],
            ['name' => 'Palestine', 'name_ar' => 'فلسطين', 'currency_id' => Currency::where('code', 'JOD')->first()?->id],
            ['name' => 'Syria', 'name_ar' => 'سوريا', 'currency_id' => Currency::where('code', 'SYP')->first()?->id],
            ['name' => 'Iraq', 'name_ar' => 'العراق', 'currency_id' => Currency::where('code', 'IQD')->first()?->id],
            ['name' => 'Libya', 'name_ar' => 'ليبيا', 'currency_id' => Currency::where('code', 'LYD')->first()?->id],
            ['name' => 'Tunisia', 'name_ar' => 'تونس', 'currency_id' => Currency::where('code', 'TND')->first()?->id],
            ['name' => 'Morocco', 'name_ar' => 'المغرب', 'currency_id' => Currency::where('code', 'MAD')->first()?->id],
            ['name' => 'Mauritania', 'name_ar' => 'موريتانيا', 'currency_id' => Currency::where('code', 'MRU')->first()?->id],
            ['name' => 'Oman', 'name_ar' => 'عمان', 'currency_id' => Currency::where('code', 'OMR')->first()?->id],
            ['name' => 'Kuwait', 'name_ar' => 'الكويت', 'currency_id' => Currency::where('code', 'KWD')->first()?->id],
            ['name' => 'Bahrain', 'name_ar' => 'البحرين', 'currency_id' => Currency::where('code', 'BHD')->first()?->id],
            ['name' => 'Yemen', 'name_ar' => 'اليمن', 'currency_id' => Currency::where('code', 'YER')->first()?->id],
            ['name' => 'Sudan', 'name_ar' => 'السودان', 'currency_id' => Currency::where('code', 'SDG')->first()?->id],
            ['name' => 'Somalia', 'name_ar' => 'الصومال', 'currency_id' => Currency::where('code', 'SOS')->first()?->id],
            ['name' => 'Qatar', 'name_ar' => 'قطر', 'currency_id' => Currency::where('code', 'QAR')->first()?->id],
            ['name' => 'Djibouti', 'name_ar' => 'جيبوتي', 'currency_id' => Currency::where('code', 'DJF')->first()?->id],
            ['name' => 'Comoros', 'name_ar' => 'جزر القمر', 'currency_id' => Currency::where('code', 'KMF')->first()?->id],
        ];

        // Country::insert($countries);
    }
}

// $countries = [
//     'countries_id' => '',
//     'countries_name_en' => '',
//     'countries_name_ar' => '',
//     'iso2' => '',
//     'iso3' => '',
//     'numeric_code' => '',
//     'phone_code' => '',
//     'capital	curr' => '',
//     'ency_id' => '',
//     'tld' => '',
//     'native' => '',
//     'region' => '',
//     'region_id' => '',
//     'subregion' => '',
//     'subregion_id' => '',
//     'nationality' => '',
//     'timezone' => '',
//     'latitude' => '',
//     'longitude' => '',
//     'emoji' => '',
//     'emojiU' => '',
//     'population' => '',
//     'flag_url' => '',
//     'flag_emoji' => '',
//     'continent' => '',
//     'area' => '',
//     'is_active' => '',
//     'wikipedia_link' => '',
// ];

// countries_id
// countries_name_en
// countries_name_ar
// iso2
// iso3
// numeric_code
// phone_code
// capital
// currency_id
// tld
// native
// region_id
// region_ar
// subregion_id
// subregion_ar
// nationality_id
// nationality_ar
// timezone
// latitude
// longitude
// emoji
// emojiU
// population
// flag_url
// flag_emoji
// continent
// area
// is_active
// wikipedia_link