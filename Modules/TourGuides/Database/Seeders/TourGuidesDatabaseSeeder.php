<?php

namespace Modules\TourGuides\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TourGuidesDatabaseSeeder extends Seeder
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
            // TourGuideLanguageSeeder::class,
            // TourGuideSeeder::class,
            // TourGuideTypeSeeder::class,
            // TourGuideReviewSeeder::class,
        ]);
    }
}
