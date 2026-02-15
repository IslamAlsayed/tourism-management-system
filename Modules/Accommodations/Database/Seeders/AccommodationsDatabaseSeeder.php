<?php

namespace Modules\Accommodations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccommodationsDatabaseSeeder extends Seeder
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
            // AccommodationSeeder::class,
            // RoomSeeder::class,
            // SeasonSeeder::class,
            // MealSeeder::class,
            // SupplementSeeder::class,
        ]);
    }
}
