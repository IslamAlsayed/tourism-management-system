<?php

namespace App\Http\Controllers\Dashboard\Quotes\v2;

use App\Models\Booking;
use App\Models\BusType;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Hotel;
use App\Models\Subregion;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;

class QuoteController extends Controller
{
    public function index()
    {
        $quotations = Booking::all();
        return view('pages.dashboard.quote.v2.index', compact('quotations'));
    }

    public function step1()
    {
        $fileTypes = [1 => 'Client', 2 => 'Tour Operator', 3 => 'Travel Agent', 4 => 'Website', 5 => 'Offers', 6 => 'Special Request', 7 => 'Other'];
        $clients = [1 => 'Client A', 2 => 'Client B', 3 => 'Client C', 4 => 'Client D', 5 => 'Client E'];
        $tourOperators = [1 => 'Tour Operator A', 2 => 'Tour Operator B', 3 => 'Tour Operator C'];
        $travelAgents = [1 => 'Travel Agent A', 2 => 'Travel Agent B', 3 => 'Travel Agent C'];
        $nationalities = Nationality::all();
        $countries = Country::all();
        $currencies = Currency::all();
        $subregions = Subregion::all();

        return view('pages.dashboard.quote.v2.step1', compact('fileTypes', 'clients', 'tourOperators', 'travelAgents', 'nationalities', 'currencies', 'countries', 'subregions'));
    }

    public function postStep1(Request $request)
    {
        // dd($request->all());

        return redirect()->route('dashboard.quote.v2.step2');
    }

    public function step2()
    {
        $programDetails = [
            'accommodation' => '🏨 Accommodation',
            'transportation' => '🚌 Transportation',
            // 'tours' => '⛱️ Tours',
            // 'guide' => '🗣️ Guide',
            // 'restaurants' => '🍽️ Restaurants',
            // 'entrance_fees' => '🏯 Entrance Fees',
            // 'services' => '🎈 Services',
            // '4x4_cars' => '🚔 4x4 Cars',
            // 'visa' => '🏁 Visa',
        ];

        $stars = [1, 2, 3, 4, 5];
        $countries = Country::all();
        $cities = City::all();
        $hotels = Hotel::all();
        $transportCompanies = TransportationCompany::with(['busTypes.rates'])->get();

        return view('pages.dashboard.quote.v2.step2', compact('programDetails', 'stars', 'countries', 'cities', 'hotels', 'transportCompanies'));
    }

    public function step3()
    {
        $hotels = Hotel::all();
        $countries = Country::all();
        $cities = City::all();
        $stars = [1, 2, 3, 4, 5];

        return view('pages.dashboard.quote.v2.step3', compact('hotels', 'countries', 'cities', 'stars'));
    }

    public function postStep4(Request $request)
    {
        dd($request->all());
    }

    public function step4()
    {
        return view('pages.dashboard.quote.v2.step4');
    }

    public function getHotelsByCountriesAndCities(Request $request)
    {
        // 1️⃣ Countries
        $selectedCountryIds = $request->input('countries', []);
        if (empty($selectedCountryIds)) {
            $selectedCountryIds = Country::pluck('id')->toArray();
        }

        // 2️⃣ Cities
        $selectedCityIds = $request->input('cities', []);

        $citiesQuery = City::whereIn('country_id', $selectedCountryIds)->with('country:id,name');

        if (!empty($selectedCityIds)) {
            $citiesQuery->whereIn('id', $selectedCityIds);
        }

        $cities = $citiesQuery->get();

        // قائمة المدن اللي هنستخدمها للفنادق
        $cityIdsForHotels = $cities->pluck('id')->toArray();

        // 3️⃣ Hotels
        $hotelsQuery = Hotel::query()->with(['city:id,name,country_id', 'city.country:id,name'])
            ->whereIn('country_id', $selectedCountryIds)
            ->whereIn('city_id', $cityIdsForHotels);

        $hotels = $hotelsQuery->get(['id', 'name', 'city_id', 'country_id']);

        // ترتيب الفنادق حسب الدولة > المدينة
        $groupedHotels = [];
        foreach ($hotels as $hotel) {
            $city = $hotel->city;
            $country = $city?->country;

            $countryId = $country->id;
            $countryName = $country->name;

            $cityId = $city->id;
            $cityName = $city->name;

            if (!isset($groupedHotels[$countryId])) {
                $groupedHotels[$countryId] = [
                    'country_name' => $countryName,
                    'hotels_by_city' => [],
                ];
            }

            if (!isset($groupedHotels[$countryId]['hotels_by_city'][$cityId])) {
                $groupedHotels[$countryId]['hotels_by_city'][$cityId] = [
                    'city_name' => $cityName,
                    'hotels' => [],
                ];
            }

            $groupedHotels[$countryId]['hotels_by_city'][$cityId]['hotels'][] = [
                'id' => $hotel->id,
                'name' => $hotel->name,
            ];
        }

        return response()->json([
            'data' => $groupedHotels,
            'request' => $request->all(),
        ]);
    }

    public function getTransportation(Request $request)
    {
        // 1️⃣ Transportation
        $selectedTransportationIds = $request->input('transportation', []);
        $transportation = TransportationCompany::whereIn('id', $selectedTransportationIds)->pluck('name', 'id');

        $buses = BusType::whereIn('company_id', $selectedTransportationIds)->get(['id', 'name', 'seats']);

        $data = [
            'transportation' => $transportation,
            'buses' => $buses,
        ];
        return response()->json([
            'data' => $data,
            'request' => $request->all(),
        ]);
    }
}