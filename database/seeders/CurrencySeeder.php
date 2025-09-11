<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Currency::truncate();
        Schema::enableForeignKeyConstraints();

        $currencies = [
            ['name' => 'Algerian Dinar', 'code' => 'DZD', 'symbol' => 'DZD', 'country' => 'Algeria'],
            ['name' => 'Bahraini Dinar', 'code' => 'BHD', 'symbol' => 'BHD', 'country' => 'Bahrain'],
            ['name' => 'Comorian Franc', 'code' => 'KMF', 'symbol' => 'KMF', 'country' => 'Comoros'],
            ['name' => 'Djiboutian Franc', 'code' => 'DJF', 'symbol' => 'DJF', 'country' => 'Djibouti'],
            ['name' => 'Egyptian Pound', 'code' => 'EGP', 'symbol' => 'EGP', 'country' => 'Egypt'],
            ['name' => 'Iraqi Dinar', 'code' => 'IQD', 'symbol' => 'IQD', 'country' => 'Iraq'],
            ['name' => 'Jordanian Dinar', 'code' => 'JOD', 'symbol' => 'JOD', 'country' => 'Jordan'],
            ['name' => 'Kuwaiti Dinar', 'code' => 'KWD', 'symbol' => 'KWD', 'country' => 'Kuwait'],
            ['name' => 'Lebanese Pound', 'code' => 'LBP', 'symbol' => 'LBP', 'country' => 'Lebanon'],
            ['name' => 'Libyan Dinar', 'code' => 'LYD', 'symbol' => 'LYD', 'country' => 'Libya'],
            ['name' => 'Mauritanian Ouguiya', 'code' => 'MRU', 'symbol' => 'MRU', 'country' => 'Mauritania'],
            ['name' => 'Moroccan Dirham', 'code' => 'MAD', 'symbol' => 'MAD', 'country' => 'Morocco'],
            ['name' => 'Omani Rial', 'code' => 'OMR', 'symbol' => 'OMR', 'country' => 'Oman'],
            ['name' => 'Palestinian Pound (uses JOD)', 'code' => 'JOD', 'symbol' => 'JOD', 'country' => 'Palestine'],
            ['name' => 'Qatari Riyal', 'code' => 'QAR', 'symbol' => 'QAR', 'country' => 'Qatar'],
            ['name' => 'Saudi Riyal', 'code' => 'SAR', 'symbol' => 'SAR', 'country' => 'Saudi Arabia'],
            ['name' => 'Somali Shilling', 'code' => 'SOS', 'symbol' => 'SOS', 'country' => 'Somalia'],
            ['name' => 'Sudanese Pound', 'code' => 'SDG', 'symbol' => 'SDG', 'country' => 'Sudan'],
            ['name' => 'Syrian Pound', 'code' => 'SYP', 'symbol' => 'SYP', 'country' => 'Syria'],
            ['name' => 'Tunisian Dinar', 'code' => 'TND', 'symbol' => 'TND', 'country' => 'Tunisia'],
            ['name' => 'UAE Dirham', 'code' => 'AED', 'symbol' => 'AED', 'country' => 'United Arab Emirates'],
            ['name' => 'Yemeni Rial', 'code' => 'YER', 'symbol' => 'YER', 'country' => 'Yemen'],
        ];

        Currency::insert($currencies);
    }
}