<?php

namespace Database\Seeders;

use App\Models\TransportationBusType;
use App\Models\TransportationCarRoute;
use App\Models\TransportationCarRoutePrice;
use Illuminate\Database\Seeder;
use App\Models\TransportationCompany;
use Illuminate\Support\Facades\Schema;
use App\Models\TransportationCompanyDepartment;

class TransportationCompanySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TransportationCarRoute::truncate();
        TransportationCarRoutePrice::truncate();
        // TransportationBusType::truncate();
        // TransportationCompany::truncate();
        // TransportationCompanyDepartment::truncate();
        Schema::enableForeignKeyConstraints();

        // TransportationCompany::insert([
        //     ['name' => 'Jett Transport', 'contact_person' => 'Omar Ali', 'phone' => '+962799999999', 'email' => 'info@jett.com.jo', 'address' => 'Amman, Jordan'],
        //     ['name' => 'Jordan Express', 'contact_person' => 'Samer Khalil', 'phone' => '+962798888888', 'email' => 'contact@jordanexpress.jo', 'address' => 'Amman, Jordan'],
        //     ['name' => 'Amman Shuttle', 'contact_person' => 'Rania Haddad', 'phone' => '+962797777777', 'email' => 'info@ammanshuttle.jo', 'address' => 'Amman, Jordan'],
        //     ['name' => 'Royal Coaches', 'contact_person' => 'Fadi Nasser', 'phone' => '+962796666666', 'email' => 'support@royalcoaches.jo', 'address' => 'Amman, Jordan'],
        // ]);
    }
}