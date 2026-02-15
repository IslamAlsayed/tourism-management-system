<?php

namespace Modules\Transportation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TransportationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

<<<<<<< HEAD
        $this->call([
            // CompanySeeder::class,
            // JeepSeeder::class,
            // RouteSeeder::class,
        ]);
=======
        // $this->call();
>>>>>>> production
    }
}
