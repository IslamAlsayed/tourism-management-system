<?php

namespace Modules\Localization\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Localization\Database\Seeders\CurrencySeeder;
use Modules\Localization\Database\Seeders\LanguageSeeder;
use Modules\Localization\Database\Seeders\SystemLanguageSeeder;
use Modules\Localization\Database\Seeders\TimezoneSeeder;

class LocalizationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            SystemLanguageSeeder::class,
            LanguageSeeder::class,
            TimezoneSeeder::class,
            CurrencySeeder::class,
        ]);
    }
}
