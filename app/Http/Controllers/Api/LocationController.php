<?php

namespace App\Http\Controllers\Api;

use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Subregion;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Get cities by country
     */
    public function getCitiesByCountry($countryId)
    {
        $cities = City::where('country_id', $countryId)
            ->where('is_active', true)
            ->select('id', 'name', 'name_ar')
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }

    /**
     * Get subregions by region
     */
    public function getSubregionsByRegion($regionId)
    {
        $subregions = Subregion::where('region_id', $regionId)
            ->where('is_active', true)
            ->select('id', 'name', 'name_ar')
            ->orderBy('name')
            ->get();

        return response()->json($subregions);
    }
}
