<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportationCompany;
use Illuminate\Support\Facades\Schema;

class TransportationCompanySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TransportationCompany::truncate();
        Schema::enableForeignKeyConstraints();

        TransportationCompany::insert([
            ['name' => 'Jett Transport', 'contact_person' => 'Omar Ali', 'phone' => '+962799999999', 'email' => 'info@jett.com.jo', 'address' => 'Amman, Jordan'],
            ['name' => 'Jordan Express', 'contact_person' => 'Samer Khalil', 'phone' => '+962798888888', 'email' => 'contact@jordanexpress.jo', 'address' => 'Amman, Jordan'],
            ['name' => 'Amman Shuttle', 'contact_person' => 'Rania Haddad', 'phone' => '+962797777777', 'email' => 'info@ammanshuttle.jo', 'address' => 'Amman, Jordan'],
            ['name' => 'Royal Coaches', 'contact_person' => 'Fadi Nasser', 'phone' => '+962796666666', 'email' => 'support@royalcoaches.jo', 'address' => 'Amman, Jordan'],
        ]);
    }
}