<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Accommodation;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'accommodation_id' => Accommodation::where('trade_name', "Ma'in Hot Springs Resort")->first()?->id || 1,
                'sales_man' => 'Omar Ali',
                'sales_phone' => '+962799999900',
                'sales_mail' => 'omar.ali@mainresort.jo',
                'resv_man' => 'Lina Hasan',
                'resv_phone' => '+962799999901',
                'resvr_mail' => 'lina.hasan@mainresort.jo',
                'accounting_person' => 'Rami Khaled',
                'acc_mail' => 'rami.khaled@mainresort.jo',
                'acc_phone' => '+962799999902',
            ],
            [
                'accommodation_id' => Accommodation::where('trade_name', "Petra Palace Hotel")->first()?->id || 1,
                'sales_man' => 'Samir Jaber',
                'sales_phone' => '+962798888800',
                'sales_mail' => 'samir.jaber@petrapalace.jo',
                'resv_man' => 'Mona Saleh',
                'resv_phone' => '+962798888801',
                'resvr_mail' => 'mona.saleh@petrapalace.jo',
                'accounting_person' => 'Hani Nasser',
                'acc_mail' => 'hani.nasser@petrapalace.jo',
                'acc_phone' => '+962798888802',
            ],
        ];

        foreach ($hotels as $data) {
            Hotel::create($data);
        }
    }
}