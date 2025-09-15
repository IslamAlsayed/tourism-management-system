<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Nationality::truncate();
        Schema::enableForeignKeyConstraints();

        $nationalities = [
            ['name' => 'Egyptian', 'name_ar' => 'مصري', 'country_id' => Country::where('name', 'Egypt')->first()?->id],
            ['name' => 'Saudi', 'name_ar' => 'سعودي', 'country_id' => Country::where('name', 'Saudi Arabia')->first()?->id],
            ['name' => 'Emirati', 'name_ar' => 'إماراتي', 'country_id' => Country::where('name', 'United Arab Emirates')->first()?->id],
        ];

        // Nationality::insert($nationalities);

        // $nationalities = [
        //     ['nationality_ar' => 'السعودية', 'nationality' => 'Saudi', 'country' => 'Saudi Arabia', 'country_ar' => 'السعودية', 'capital' => 'Riyadh', 'iso2' => 'SA', 'iso3' => 'SAU', 'phone_code' => '966', 'tld' => '.sa', 'timezone' => 'Asia/Riyadh', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'الإماراتية', 'nationality' => 'Emirati', 'country' => 'United Arab Emirates', 'country_ar' => 'الإمارات', 'capital' => 'Abu Dhabi', 'iso2' => 'AE', 'iso3' => 'ARE', 'phone_code' => '971', 'tld' => '.ae', 'timezone' => 'Asia/Dubai', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'المصرية', 'nationality' => 'Egyptian', 'country' => 'Egypt', 'country_ar' => 'مصر', 'capital' => 'Cairo', 'iso2' => 'EG', 'iso3' => 'EGY', 'phone_code' => '20', 'tld' => '.eg', 'timezone' => 'Africa/Cairo', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'الأردنية', 'nationality' => 'Jordanian', 'country' => 'Jordan', 'country_ar' => 'الأردن', 'capital' => 'Amman', 'iso2' => 'JO', 'iso3' => 'JOR', 'phone_code' => '962', 'tld' => '.jo', 'timezone' => 'Asia/Amman', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'اللبنانية', 'nationality' => 'Lebanese', 'country' => 'Lebanon', 'country_ar' => 'لبنان', 'capital' => 'Beirut', 'iso2' => 'LB', 'iso3' => 'LBN', 'phone_code' => '961', 'tld' => '.lb', 'timezone' => 'Asia/Beirut', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'الفلسطينية', 'nationality' => 'Palestinian', 'country' => 'Palestine', 'country_ar' => 'فلسطين', 'capital' => 'East Jerusalem', 'iso2' => 'PS', 'iso3' => 'PSE', 'phone_code' => '970', 'tld' => '.ps', 'timezone' => 'Asia/Gaza', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'السورية', 'nationality' => 'Syrian', 'country' => 'Syria', 'country_ar' => 'سوريا', 'capital' => 'Damascus', 'iso2' => 'SY', 'iso3' => 'SYR', 'phone_code' => '963', 'tld' => '.sy', 'timezone' => 'Asia/Damascus', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'العراقية', 'nationality' => 'Iraqi', 'country' => 'Iraq', 'country_ar' => 'العراق', 'capital' => 'Baghdad', 'iso2' => 'IQ', 'iso3' => 'IRQ', 'phone_code' => '964', 'tld' => '.iq', 'timezone' => 'Asia/Baghdad', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'الليبية', 'nationality' => 'Libyan', 'country' => 'Libya', 'country_ar' => 'ليبيا', 'capital' => 'Tripoli', 'iso2' => 'LY', 'iso3' => 'LBY', 'phone_code' => '218', 'tld' => '.ly', 'timezone' => 'Africa/Tripoli', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'التونسية', 'nationality' => 'Tunisian', 'country' => 'Tunisia', 'country_ar' => 'تونس', 'capital' => 'Tunis', 'iso2' => 'TN', 'iso3' => 'TUN', 'phone_code' => '216', 'tld' => '.tn', 'timezone' => 'Africa/Tunis', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'الجزائرية', 'nationality' => 'Algerian', 'country' => 'Algeria', 'country_ar' => 'الجزائر', 'capital' => 'Algiers', 'iso2' => 'DZ', 'iso3' => 'DZA', 'phone_code' => '213', 'tld' => '.dz', 'timezone' => 'Africa/Algiers', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'المغربية', 'nationality' => 'Moroccan', 'country' => 'Morocco', 'country_ar' => 'المغرب', 'capital' => 'Rabat', 'iso2' => 'MA', 'iso3' => 'MAR', 'phone_code' => '212', 'tld' => '.ma', 'timezone' => 'Africa/Casablanca', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'الموريتانية', 'nationality' => 'Mauritanian', 'country' => 'Mauritania', 'country_ar' => 'موريتانيا', 'capital' => 'Nouakchott', 'iso2' => 'MR', 'iso3' => 'MRT', 'phone_code' => '222', 'tld' => '.mr', 'timezone' => 'Africa/Nouakchott', 'region' => 'Africa', 'subregion' => 'Western Africa'],
        //     ['nationality_ar' => 'العمانية', 'nationality' => 'Omani', 'country' => 'Oman', 'country_ar' => 'عمان', 'capital' => 'Muscat', 'iso2' => 'OM', 'iso3' => 'OMN', 'phone_code' => '968', 'tld' => '.om', 'timezone' => 'Asia/Muscat', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'الكويتية', 'nationality' => 'Kuwaiti', 'country' => 'Kuwait', 'country_ar' => 'الكويت', 'capital' => 'Kuwait City', 'iso2' => 'KW', 'iso3' => 'KWT', 'phone_code' => '965', 'tld' => '.kw', 'timezone' => 'Asia/Kuwait', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'البحرينية', 'nationality' => 'Bahraini', 'country' => 'Bahrain', 'country_ar' => 'البحرين', 'capital' => 'Manama', 'iso2' => 'BH', 'iso3' => 'BHR', 'phone_code' => '973', 'tld' => '.bh', 'timezone' => 'Asia/Bahrain', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'اليمنية', 'nationality' => 'Yemeni', 'country' => 'Yemen', 'country_ar' => 'اليمن', 'capital' => 'Sana\'a', 'iso2' => 'YE', 'iso3' => 'YEM', 'phone_code' => '967', 'tld' => '.ye', 'timezone' => 'Asia/Aden', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'السودانية', 'nationality' => 'Sudanese', 'country' => 'Sudan', 'country_ar' => 'السودان', 'capital' => 'Khartoum', 'iso2' => 'SD', 'iso3' => 'SDN', 'phone_code' => '249', 'tld' => '.sd', 'timezone' => 'Africa/Khartoum', 'region' => 'Africa', 'subregion' => 'Northern Africa'],
        //     ['nationality_ar' => 'الصومالية', 'nationality' => 'Somali', 'country' => 'Somalia', 'country_ar' => 'الصومال', 'capital' => 'Mogadishu', 'iso2' => 'SO', 'iso3' => 'SOM', 'phone_code' => '252', 'tld' => '.so', 'timezone' => 'Africa/Mogadishu', 'region' => 'Africa', 'subregion' => 'Eastern Africa'],
        //     ['nationality_ar' => 'القطرية', 'nationality' => 'Qatari', 'country' => 'Qatar', 'country_ar' => 'قطر', 'capital' => 'Doha', 'iso2' => 'QA', 'iso3' => 'QAT', 'phone_code' => '974', 'tld' => '.qa', 'timezone' => 'Asia/Qatar', 'region' => 'Asia', 'subregion' => 'Western Asia'],
        //     ['nationality_ar' => 'الجيبوتية', 'nationality' => 'Djiboutian', 'country' => 'Djibouti', 'country_ar' => 'جيبوتي', 'capital' => 'Djibouti City', 'iso2' => 'DJ', 'iso3' => 'DJI', 'phone_code' => '253', 'tld' => '.dj', 'timezone' => 'Africa/Djibouti', 'region' => 'Africa', 'subregion' => 'Eastern Africa'],
        //     ['nationality_ar' => 'جزر القمرية', 'nationality' => 'Comorian', 'country' => 'Comoros', 'country_ar' => 'جزر القمر', 'capital' => 'Moroni', 'iso2' => 'KM', 'iso3' => 'COM', 'phone_code' => '269', 'tld' => '.km', 'timezone' => 'Indian/Comoro', 'region' => 'Africa', 'subregion' => 'Eastern Africa'],
        // ];

        // foreach ($nationalities as $nat) {
        //     $regionId = Region::where('name', $nat['region'])->first()?->id;
        //     $subregionId = Subregion::where('name', $nat['subregion'])->first()?->id;
        //     $currencyId = Currency::where('name', $nat['country'])->first()?->id;

        //     $country = Country::updateOrCreate(
        //         ['iso2' => $nat['iso2']],
        //         [
        //             'name' => $nat['country'],
        //             'name_ar' => $nat['country_ar'],
        //             'iso3' => $nat['iso3'],
        //             'phone_code' => $nat['phone_code'],
        //             'capital' => $nat['capital'],
        //             'currency_id' => $currencyId,
        //             'tld' => $nat['tld'],
        //             'native' => $nat['country_ar'],
        //             'region_id' => $regionId,
        //             'subregion_id' => $subregionId,
        //             'nationality' => $nat['nationality'],
        //             'timezone' => $nat['timezone'],
        //             'is_active' => true,
        //         ]
        //     );

        //     $region = Region::updateOrCreate(
        //         ['name' => $nat['region']],
        //         [
        //             'country_id' => $country->id,
        //         ]
        //     );

        //     $subregion = Subregion::updateOrCreate(
        //         ['name' => $nat['subregion']],
        //         [
        //             'region_id' => $region->id,
        //         ]
        //     );

        //     Nationality::updateOrCreate(
        //         ['country_id' => $country->id],
        //         [
        //             'name' => $nat['nationality'],
        //             'name_ar' => $nat['nationality_ar'],
        //         ]
        //     );
        // }

        // $nationalities = [
        //     ['nationality' => 'السعودية', 'nationality_ar' => 'Saudi', 'country' => 'Saudi Arabia', 'country_ar' => 'السعودية', 'capital' => 'Riyadh', 'iso2' => 'SA', 'iso3' => 'SAU'],
        //     ['nationality' => 'الإماراتية', 'nationality_ar' => 'Emirati', 'country' => 'United Arab Emirates', 'country_ar' => 'الإمارات', 'capital' => 'Abu Dhabi', 'iso2' => 'AE', 'iso3' => 'ARE'],
        //     ['nationality' => 'المصرية', 'nationality_ar' => 'Egyptian', 'country' => 'Egypt', 'country_ar' => 'مصر', 'capital' => 'Cairo', 'iso2' => 'EG', 'iso3' => 'EGY'],
        //     ['nationality' => 'الأردنية', 'nationality_ar' => 'Jordanian', 'country' => 'Jordan', 'country_ar' => 'الأردن', 'capital' => 'Amman', 'iso2' => 'JO', 'iso3' => 'JOR'],
        //     ['nationality' => 'اللبنانية', 'nationality_ar' => 'Lebanese', 'country' => 'Lebanon', 'country_ar' => 'لبنان', 'capital' => 'Beirut', 'iso2' => 'LB', 'iso3' => 'LBN'],
        //     ['nationality' => 'الفلسطينية', 'nationality_ar' => 'Palestinian', 'country' => 'Palestine', 'country_ar' => 'فلسطين', 'capital' => 'East Jerusalem', 'iso2' => 'PS', 'iso3' => 'PSE'],
        //     ['nationality' => 'السورية', 'nationality_ar' => 'Syrian', 'country' => 'Syria', 'country_ar' => 'سوريا', 'capital' => 'Damascus', 'iso2' => 'SY', 'iso3' => 'SYR'],
        //     ['nationality' => 'العراقية', 'nationality_ar' => 'Iraqi', 'country' => 'Iraq', 'country_ar' => 'العراق', 'capital' => 'Baghdad', 'iso2' => 'IQ', 'iso3' => 'IRQ'],
        //     ['nationality' => 'الليبية', 'nationality_ar' => 'Libyan', 'country' => 'Libya', 'country_ar' => 'ليبيا', 'capital' => 'Tripoli', 'iso2' => 'LY', 'iso3' => 'LBY'],
        //     ['nationality' => 'التونسية', 'nationality_ar' => 'Tunisian', 'country' => 'Tunisia', 'country_ar' => 'تونس', 'capital' => 'Tunis', 'iso2' => 'TN', 'iso3' => 'TUN'],
        //     ['nationality' => 'الجزائرية', 'nationality_ar' => 'Algerian', 'country' => 'Algeria', 'country_ar' => 'الجزائر', 'capital' => 'Algiers', 'iso2' => 'DZ', 'iso3' => 'DZA'],
        //     ['nationality' => 'المغربية', 'nationality_ar' => 'Moroccan', 'country' => 'Morocco', 'country_ar' => 'المغرب', 'capital' => 'Rabat', 'iso2' => 'MA', 'iso3' => 'MAR'],
        //     ['nationality' => 'الموريتانية', 'nationality_ar' => 'Mauritanian', 'country' => 'Mauritania', 'country_ar' => 'موريتانيا', 'capital' => 'Nouakchott', 'iso2' => 'MR', 'iso3' => 'MRT'],
        //     ['nationality' => 'البروناي', 'nationality_ar' => 'Bruneian', 'country' => 'Brunei', 'country_ar' => 'بروناي', 'capital' => 'Bandar Seri Begawan', 'iso2' => 'BN', 'iso3' => 'BRN'],
        //     ['nationality' => 'العمانية', 'nationality_ar' => 'Omani', 'country' => 'Oman', 'country_ar' => 'عمان', 'capital' => 'Muscat', 'iso2' => 'OM', 'iso3' => 'OMN'],
        //     ['nationality' => 'الكويتية', 'nationality_ar' => 'Kuwaiti', 'country' => 'Kuwait', 'country_ar' => 'الكويت', 'capital' => 'Kuwait City', 'iso2' => 'KW', 'iso3' => 'KWT'],
        //     ['nationality' => 'البحرينية', 'nationality_ar' => 'Bahraini', 'country' => 'Bahrain', 'country_ar' => 'البحرين', 'capital' => 'Manama', 'iso2' => 'BH', 'iso3' => 'BHR'],
        //     ['nationality' => 'اليمنية', 'nationality_ar' => 'Yemeni', 'country' => 'Yemen', 'country_ar' => 'اليمن', 'capital' => 'Sana\'a', 'iso2' => 'YE', 'iso3' => 'YEM'],
        //     ['nationality' => 'السودانية', 'nationality_ar' => 'Sudanese', 'country' => 'Sudan', 'country_ar' => 'السودان', 'capital' => 'Khartoum', 'iso2' => 'SD', 'iso3' => 'SDN'],
        //     ['nationality' => 'الصومالية', 'nationality_ar' => 'Somali', 'country' => 'Somalia', 'country_ar' => 'الصومال', 'capital' => 'Mogadishu', 'iso2' => 'SO', 'iso3' => 'SOM'],
        //     ['nationality' => 'القطرية', 'nationality_ar' => 'Qatari', 'country' => 'Qatar', 'country_ar' => 'قطر', 'capital' => 'Doha', 'iso2' => 'QA', 'iso3' => 'QAT'],
        //     ['nationality' => 'الجيبوتية', 'nationality_ar' => 'Djiboutian', 'country' => 'Djibouti', 'country_ar' => 'جيبوتي', 'capital' => 'Djibouti City', 'iso2' => 'DJ', 'iso3' => 'DJI'],
        //     ['nationality' => 'التوجولية', 'nationality_ar' => 'Togolese', 'country' => 'Togo', 'country_ar' => 'توجو', 'capital' => 'Lomé', 'iso2' => 'TG', 'iso3' => 'TGO'],
        //     ['nationality' => 'جزر القمرية', 'nationality_ar' => 'Comorian', 'country' => 'Comoros', 'country_ar' => 'جزر القمر', 'capital' => 'Moroni', 'iso2' => 'KM', 'iso3' => 'COM'],
        // ];

        // foreach ($nationalities as $nat) {
        //     $country = Country::create([
        //         'name' => $nat['country'],
        //         'name_ar' => $nat['country_ar'],
        //         'iso2' => $nat['iso2'],
        //         'iso3' => $nat['iso3'],
        //         'numeric_code' => 818,
        //         'phone_code' => '20',
        //         'capital' => $nat['capital'],
        //         'currency_id' => Currency::where('country', $nat['country'])->first()?->id ?? 1,
        //         'tld' => '.eg',
        //         'native' => $nat['country_ar'],
        //         'region_id' => Region::where('name', 'Africa')->first()?->id ?? 1,
        //         'subregion_id' => Subregion::where('name', 'Northern Africa')->first()?->id ?? 1,
        //         'nationality' => $nat['nationality'],
        //         'timezone' => 'Africa/Cairo',
        //         'latitude' => 26.820553,
        //         'longitude' => 30.802498,
        //         'population' => 100000000,
        //         'continent' => 'Africa',
        //         'area' => 1002450,
        //     ]);

        //     Nationality::updateOrCreate(
        //         ['country_id' => $country->id],
        //         [
        //             'nationality' => $nat['nationality'],
        //             'nationality_ar' => $nat['nationality_ar'],
        //         ]
        //     );
        // }
    }
}