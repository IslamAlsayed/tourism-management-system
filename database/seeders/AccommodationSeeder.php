<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        $accommodations = [
            [
                'type' => 'resort',
                'trade_name' => "Ma'in Hot Springs Resort",
                'name_ar' => 'منتجع ماعين',
                'name' => "Ma'in Hot Springs Resort",
                'country' => 'Jordan',
                'city' => 'Amman',
                'city_name' => 'Amman',
                'street' => 'Queen Rania St.',
                'star_rating' => 5,
                'cat' => 'Hotel',
                'general_mobile' => '+962799999999',
                'general_email' => 'info@mainresort.jo',
                'email' => 'sales@mainresort.jo',
                'website' => 'https://mainresort.jo',
                'phone' => '+96265555555',
                'phone_ext' => '123',
                'fax' => '+96265555556',
                'box' => '12345',
                'postal_code' => '11953',
                'contact_person' => 'Omar Ali',
                'contract_file_path' => 'contracts/2025/main_hotsprings.pdf',
            ],
            [
                'type' => 'hotel',
                'trade_name' => "Petra Palace Hotel",
                'name_ar' => 'فندق قصر البتراء',
                'name' => "Petra Palace Hotel",
                'country' => 'Jordan',
                'city' => 'Petra',
                'city_name' => 'Petra',
                'street' => 'Tourism St.',
                'star_rating' => 4,
                'cat' => 'Hotel',
                'general_mobile' => '+962798888888',
                'general_email' => 'info@petrapalace.jo',
                'email' => 'sales@petrapalace.jo',
                'website' => 'https://petrapalace.jo',
                'phone' => '+96232155555',
                'phone_ext' => '200',
                'fax' => '+96232155556',
                'box' => '55555',
                'postal_code' => '71810',
                'contact_person' => 'Samir Jaber',
                'contract_file_path' => 'contracts/2025/petra_palace.pdf',
            ],
            [
                'type' => 'resort',
                'trade_name' => "Kempinski Hotel Ishtar Dead Sea",
                'name_ar' => 'فندق كمبينسكي عشتار البحر الميت',
                'name' => "Kempinski Hotel Ishtar Dead Sea",
                'country' => 'Jordan',
                'city' => 'Dead Sea',
                'city_name' => 'Dead Sea',
                'street' => 'Dead Sea Road',
                'star_rating' => 5,
                'cat' => 'Resort',
                'general_mobile' => '+962797777777',
                'general_email' => 'info@kempinski-deadsea.com',
                'email' => 'sales@kempinski-deadsea.com',
                'website' => 'https://www.kempinski.com/dead-sea',
                'phone' => '+96253568888',
                'phone_ext' => '300',
                'fax' => '+96253568889',
                'box' => '6910',
                'postal_code' => '11118',
                'contact_person' => 'Zaid Majali',
                'contract_file_path' => 'contracts/2025/kempinski_deadsea.pdf',
            ],
        ];

        foreach ($accommodations as $data) {
            Accommodation::create($data);
        }
    }
}