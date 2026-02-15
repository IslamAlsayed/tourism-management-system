<?php

namespace Modules\EntryPoints\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EntryPointsDatabaseSeeder extends Seeder
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
            // LandcrossingSeeder::class,
        ]);
=======
        // $this->call();
>>>>>>> production
    }
}
