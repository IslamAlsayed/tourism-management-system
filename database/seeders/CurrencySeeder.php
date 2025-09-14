<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        $currencies = [
            ['name' => 'Algerian Dinar', 'code' => 'DZD', 'symbol' => 'دج'],
            ['name' => 'Bahraini Dinar', 'code' => 'BHD', 'symbol' => 'ب.د'],
            ['name' => 'Comorian Franc', 'code' => 'KMF', 'symbol' => 'CF'],
            ['name' => 'Djiboutian Franc', 'code' => 'DJF', 'symbol' => 'Fdj'],
            ['name' => 'Egyptian Pound', 'code' => 'EGP', 'symbol' => '£'],
            ['name' => 'Iraqi Dinar', 'code' => 'IQD', 'symbol' => 'ع.د'],
            ['name' => 'Jordanian Dinar', 'code' => 'JOD', 'symbol' => 'د.ا'],
            ['name' => 'Kuwaiti Dinar', 'code' => 'KWD', 'symbol' => 'د.ك'],
            ['name' => 'Lebanese Pound', 'code' => 'LBP', 'symbol' => 'ل.ل'],
            ['name' => 'Libyan Dinar', 'code' => 'LYD', 'symbol' => 'ل.د'],
            ['name' => 'Mauritanian Ouguiya', 'code' => 'MRU', 'symbol' => 'UM'],
            ['name' => 'Moroccan Dirham', 'code' => 'MAD', 'symbol' => 'د.م'],
            ['name' => 'Omani Rial', 'code' => 'OMR', 'symbol' => 'ر.ع'],
            ['name' => 'Qatari Riyal', 'code' => 'QAR', 'symbol' => 'ر.ق'],
            ['name' => 'Saudi Riyal', 'code' => 'SAR', 'symbol' => 'ر.س'],
            ['name' => 'Somali Shilling', 'code' => 'SOS', 'symbol' => 'Sh'],
            ['name' => 'Sudanese Pound', 'code' => 'SDG', 'symbol' => 'ج.س'],
            ['name' => 'Syrian Pound', 'code' => 'SYP', 'symbol' => 'ل.س'],
            ['name' => 'Tunisian Dinar', 'code' => 'TND', 'symbol' => 'د.ت'],
            ['name' => 'UAE Dirham', 'code' => 'AED', 'symbol' => 'د.إ'],
            ['name' => 'Yemeni Rial', 'code' => 'YER', 'symbol' => '﷼'],
        ];

        // Currency::insert($currencies);
    }
}