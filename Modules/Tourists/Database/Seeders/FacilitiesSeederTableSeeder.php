<?php

namespace Modules\Tourists\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FacilitiesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $defaultFacilities = [
            'wheelchair_accessible', 'free_wifi', 'parking', 'restrooms', 'restaurants', 
            'gift_shop', 'guided_tours', 'audio_guide', 'photography', 'hiking', 
            'swimming', 'camping', 'shopping', 'dining', 'entertainment', 
            'educational_tours', 'translation', 'special_events', 'group_bookings', 
            'online_booking', 'mobile_app', 'virtual_tours'
        ];

        $sites = \Modules\TouristSites\Entities\TouristSite::all();
        $facilities = \Modules\TouristSites\Entities\Facility::all()->keyBy('name'); // Key by name for faster lookup

        foreach ($sites as $site) {
            $siteFacilities = [];
            foreach ($defaultFacilities as $key) {
                // Check if column exists and is true
                 // Use str_replace('_', ' ', ucfirst($key)) to match facility name
                $facilityName = str_replace('_', ' ', ucfirst($key));
                
                if ($site->$key && isset($facilities[$facilityName])) {
                    $siteFacilities[] = $facilities[$facilityName]->id;
                }
            }
            if (!empty($siteFacilities)) {
                $site->facilities()->syncWithoutDetaching($siteFacilities);
            }
        }
    }
}
