<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\Timezone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Timezone::truncate();
        RichText::where('record_type', Timezone::class)->delete();
        Schema::enableForeignKeyConstraints();

        Timezone::query()->delete();

        $timezones = [
            // Middle East & North Africa
            [
                'name' => 'Africa/Cairo',
                'name_ar' => 'القاهرة',
                'abbreviation' => 'EET',
                'abbreviation_dst' => 'EEST',
                'offset' => 7200, // UTC+2
                'offset_dst' => 10800, // UTC+3
                'country_code' => 'EG',
                'gmt_offset_name' => 'UTC+02:00',
                'gmt_offset_name_dst' => 'UTC+03:00',
                'supports_dst' => false,
                // 'region' => 'Africa',
                // 'city' => 'Cairo',
                'description' => 'Egypt Standard Time',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Asia/Riyadh',
                'name_ar' => 'الرياض',
                'abbreviation' => 'AST',
                'abbreviation_dst' => null,
                'offset' => 10800, // UTC+3
                'offset_dst' => null,
                'country_code' => 'SA',
                'gmt_offset_name' => 'UTC+03:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Riyadh',
                'description' => 'Arabia Standard Time',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Asia/Dubai',
                'name_ar' => 'دبي',
                'abbreviation' => 'GST',
                'abbreviation_dst' => null,
                'offset' => 14400, // UTC+4
                'offset_dst' => null,
                'country_code' => 'AE',
                'gmt_offset_name' => 'UTC+04:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Dubai',
                'description' => 'Gulf Standard Time',
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Asia/Amman',
                'name_ar' => 'عمان',
                'abbreviation' => 'EEST',
                'abbreviation_dst' => null,
                'offset' => 10800, // UTC+3
                'offset_dst' => null,
                'country_code' => 'JO',
                'gmt_offset_name' => 'UTC+03:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Amman',
                'description' => 'Jordan Standard Time',
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'name' => 'Asia/Beirut',
                'name_ar' => 'بيروت',
                'abbreviation' => 'EET',
                'abbreviation_dst' => 'EEST',
                'offset' => 7200, // UTC+2
                'offset_dst' => 10800, // UTC+3
                'country_code' => 'LB',
                'gmt_offset_name' => 'UTC+02:00',
                'gmt_offset_name_dst' => 'UTC+03:00',
                'supports_dst' => true,
                // 'region' => 'Asia',
                // 'city' => 'Beirut',
                'description' => 'Middle East Standard Time',
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'name' => 'Asia/Baghdad',
                'name_ar' => 'بغداد',
                'abbreviation' => 'AST',
                'abbreviation_dst' => null,
                'offset' => 10800, // UTC+3
                'offset_dst' => null,
                'country_code' => 'IQ',
                'gmt_offset_name' => 'UTC+03:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Baghdad',
                'description' => 'Arabic Standard Time',
                'is_active' => true,
                'sort_order' => 15,
            ],
            [
                'name' => 'Asia/Kabul',
                'name_ar' => 'كابول',
                'abbreviation' => 'AFT',
                'abbreviation_dst' => null,
                'offset' => 16200, // UTC+4:30
                'offset_dst' => null,
                'country_code' => 'AF',
                'gmt_offset_name' => 'UTC+04:30',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Kabul',
                'description' => 'Afghanistan Time',
                'is_active' => true,
                'sort_order' => 16,
            ],

            // Europe
            [
                'name' => 'Europe/London',
                'name_ar' => 'لندن',
                'abbreviation' => 'GMT',
                'abbreviation_dst' => 'BST',
                'offset' => 0, // UTC+0
                'offset_dst' => 3600, // UTC+1
                'country_code' => 'GB',
                'gmt_offset_name' => 'UTC+00:00',
                'gmt_offset_name_dst' => 'UTC+01:00',
                'supports_dst' => true,
                // 'region' => 'Europe',
                // 'city' => 'London',
                'description' => 'Greenwich Mean Time',
                'is_active' => true,
                'sort_order' => 20,
            ],
            [
                'name' => 'Europe/Paris',
                'name_ar' => 'باريس',
                'abbreviation' => 'CET',
                'abbreviation_dst' => 'CEST',
                'offset' => 3600, // UTC+1
                'offset_dst' => 7200, // UTC+2
                'country_code' => 'FR',
                'gmt_offset_name' => 'UTC+01:00',
                'gmt_offset_name_dst' => 'UTC+02:00',
                'supports_dst' => true,
                // 'region' => 'Europe',
                // 'city' => 'Paris',
                'description' => 'Central European Time',
                'is_active' => true,
                'sort_order' => 21,
            ],
            [
                'name' => 'Europe/Berlin',
                'name_ar' => 'برلين',
                'abbreviation' => 'CET',
                'abbreviation_dst' => 'CEST',
                'offset' => 3600, // UTC+1
                'offset_dst' => 7200, // UTC+2
                'country_code' => 'DE',
                'gmt_offset_name' => 'UTC+01:00',
                'gmt_offset_name_dst' => 'UTC+02:00',
                'supports_dst' => true,
                // 'region' => 'Europe',
                // 'city' => 'Berlin',
                'description' => 'Central European Time',
                'is_active' => true,
                'sort_order' => 22,
            ],
            [
                'name' => 'Europe/Moscow',
                'name_ar' => 'موسكو',
                'abbreviation' => 'MSK',
                'abbreviation_dst' => null,
                'offset' => 10800, // UTC+3
                'offset_dst' => null,
                'country_code' => 'RU',
                'gmt_offset_name' => 'UTC+03:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Europe',
                // 'city' => 'Moscow',
                'description' => 'Moscow Standard Time',
                'is_active' => true,
                'sort_order' => 23,
            ],

            // Americas
            [
                'name' => 'America/New_York',
                'name_ar' => 'نيويورك',
                'abbreviation' => 'EST',
                'abbreviation_dst' => 'EDT',
                'offset' => -18000, // UTC-5
                'offset_dst' => -14400, // UTC-4
                'country_code' => 'US',
                'gmt_offset_name' => 'UTC-05:00',
                'gmt_offset_name_dst' => 'UTC-04:00',
                'supports_dst' => true,
                // 'region' => 'America',
                // 'city' => 'New York',
                'description' => 'Eastern Standard Time',
                'is_active' => true,
                'sort_order' => 30,
            ],
            [
                'name' => 'America/Los_Angeles',
                'name_ar' => 'لوس أنجلوس',
                'abbreviation' => 'PST',
                'abbreviation_dst' => 'PDT',
                'offset' => -28800, // UTC-8
                'offset_dst' => -25200, // UTC-7
                'country_code' => 'US',
                'gmt_offset_name' => 'UTC-08:00',
                'gmt_offset_name_dst' => 'UTC-07:00',
                'supports_dst' => true,
                // 'region' => 'America',
                // 'city' => 'Los Angeles',
                'description' => 'Pacific Standard Time',
                'is_active' => true,
                'sort_order' => 31,
            ],
            [
                'name' => 'America/Chicago',
                'name_ar' => 'شيكاغو',
                'abbreviation' => 'CST',
                'abbreviation_dst' => 'CDT',
                'offset' => -21600, // UTC-6
                'offset_dst' => -18000, // UTC-5
                'country_code' => 'US',
                'gmt_offset_name' => 'UTC-06:00',
                'gmt_offset_name_dst' => 'UTC-05:00',
                'supports_dst' => true,
                // 'region' => 'America',
                // 'city' => 'Chicago',
                'description' => 'Central Standard Time',
                'is_active' => true,
                'sort_order' => 32,
            ],

            // Asia
            [
                'name' => 'Asia/Tokyo',
                'name_ar' => 'طوكيو',
                'abbreviation' => 'JST',
                'abbreviation_dst' => null,
                'offset' => 32400, // UTC+9
                'offset_dst' => null,
                'country_code' => 'JP',
                'gmt_offset_name' => 'UTC+09:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Tokyo',
                'description' => 'Japan Standard Time',
                'is_active' => true,
                'sort_order' => 40,
            ],
            [
                'name' => 'Asia/Shanghai',
                'name_ar' => 'شنغهاي',
                'abbreviation' => 'CST',
                'abbreviation_dst' => null,
                'offset' => 28800, // UTC+8
                'offset_dst' => null,
                'country_code' => 'CN',
                'gmt_offset_name' => 'UTC+08:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Shanghai',
                'description' => 'China Standard Time',
                'is_active' => true,
                'sort_order' => 41,
            ],
            [
                'name' => 'Asia/Singapore',
                'name_ar' => 'سنغافورة',
                'abbreviation' => 'SGT',
                'abbreviation_dst' => null,
                'offset' => 28800, // UTC+8
                'offset_dst' => null,
                'country_code' => 'SG',
                'gmt_offset_name' => 'UTC+08:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Singapore',
                'description' => 'Singapore Standard Time',
                'is_active' => true,
                'sort_order' => 42,
            ],
            [
                'name' => 'Asia/Hong_Kong',
                'name_ar' => 'هونغ كونغ',
                'abbreviation' => 'HKT',
                'abbreviation_dst' => null,
                'offset' => 28800, // UTC+8
                'offset_dst' => null,
                'country_code' => 'HK',
                'gmt_offset_name' => 'UTC+08:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Hong Kong',
                'description' => 'Hong Kong Time',
                'is_active' => true,
                'sort_order' => 43,
            ],
            [
                'name' => 'Asia/Seoul',
                'name_ar' => 'سيول',
                'abbreviation' => 'KST',
                'abbreviation_dst' => null,
                'offset' => 32400, // UTC+9
                'offset_dst' => null,
                'country_code' => 'KR',
                'gmt_offset_name' => 'UTC+09:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Seoul',
                'description' => 'Korea Standard Time',
                'is_active' => true,
                'sort_order' => 44,
            ],
            [
                'name' => 'Asia/Karachi',
                'name_ar' => 'كراتشي',
                'abbreviation' => 'PKT',
                'abbreviation_dst' => null,
                'offset' => 18000, // UTC+5
                'offset_dst' => null,
                'country_code' => 'PK',
                'gmt_offset_name' => 'UTC+05:00',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Karachi',
                'description' => 'Pakistan Standard Time',
                'is_active' => true,
                'sort_order' => 45,
            ],
            [
                'name' => 'Asia/Kolkata',
                'name_ar' => 'كولكاتا',
                'abbreviation' => 'IST',
                'abbreviation_dst' => null,
                'offset' => 19800, // UTC+5:30
                'offset_dst' => null,
                'country_code' => 'IN',
                'gmt_offset_name' => 'UTC+05:30',
                'gmt_offset_name_dst' => null,
                'supports_dst' => false,
                // 'region' => 'Asia',
                // 'city' => 'Kolkata',
                'description' => 'India Standard Time',
                'is_active' => true,
                'sort_order' => 46,
            ],

            // Australia & Pacific
            [
                'name' => 'Australia/Sydney',
                'name_ar' => 'سيدني',
                'abbreviation' => 'AEDT',
                'abbreviation_dst' => 'AEST',
                'offset' => 36000, // UTC+10
                'offset_dst' => 39600, // UTC+11
                'country_code' => 'AU',
                'gmt_offset_name' => 'UTC+10:00',
                'gmt_offset_name_dst' => 'UTC+11:00',
                'supports_dst' => true,
                // 'region' => 'Australia',
                // 'city' => 'Sydney',
                'description' => 'Australian Eastern Standard Time',
                'is_active' => true,
                'sort_order' => 50,
            ],
            [
                'name' => 'Pacific/Auckland',
                'name_ar' => 'أوكلاند',
                'abbreviation' => 'NZST',
                'abbreviation_dst' => 'NZDT',
                'offset' => 43200, // UTC+12
                'offset_dst' => 46800, // UTC+13
                'country_code' => 'NZ',
                'gmt_offset_name' => 'UTC+12:00',
                'gmt_offset_name_dst' => 'UTC+13:00',
                'supports_dst' => true,
                // 'region' => 'Pacific',
                // 'city' => 'Auckland',
                'description' => 'New Zealand Standard Time',
                'is_active' => true,
                'sort_order' => 51,
            ],
        ];

        foreach ($timezones as $timezone) {
            Timezone::create($timezone);
        }
    }
}