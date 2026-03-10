<?php

namespace App\Http\Controllers;

use App\Imports\AccommodationsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccommodationImportController extends Controller
{
    /**
     * Show import form
     */
    // public function showImportForm()
    // {
    //     return view('accommodations.import');
    // }

    public function showImportForm()
    {
        $models = 'accommodations';
        $title = __('main.import_types', ['types' => __('main.accommodations')]);
        $description = __('main.import_types_description', ['types' => __('main.accommodations')]);
        return view('pages.dashboard.accommodations.import', compact('title', 'description', 'models'));
    }

    /**
     * Handle the import
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ]);

        try {
            Excel::import(new AccommodationsImport, $request->file('file'));

            return back()->with('success', 'تم استيراد البيانات بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
        }
    }

    /**
     * Download sample Excel file
     */
    public function downloadSample()
    {
        $headers = [
            'accommodation_id',
            'region_id',
            'regions',
            'subregion_id',
            'subregions',
            'country_id',
            'countries',
            'city_id',
            'cities',
            'nationalities_rates',
            'currency',
            'city',
            'type',
            'accommodation_type_id',
            'classification',
            'name',
            'name_ar',
            'season_from',
            'season_to',
            'room_type',
            'p_p_double_room',
            'single_room_supp',
            'triple_room',
            '3rd_person',
            'breakfast_meal',
            'lunch_meal_supp',
            'dinner_meal',
            'extra_bed',
            'extra_meal',
            'sea_view_room_supp',
            'note'
        ];

        $sampleData = [
            [
                '1', // accommodation_id
                '3', // region_id
                'Asia', // regions
                '23', // subregion_id
                'Middle East', // subregions
                '111', // country_id
                'Jordan', // countries
                '63142', // city_id
                'Wadi Rum', // cities
                'All', // nationalities_rates
                'USD', // currency
                'Wadi Rum', // city
                'camp', // type
                '12', // accommodation_type_id
                '3*', // classification
                'CAPTAIN\'S MAIN CAMP', // name
                'CAPTAIN\'S MAIN CAMP', // name_ar
                'Wednesday, January 1, 2025', // season_from
                'Monday, December 29, 2025', // season_to
                'Bedouin Tent, H.B', // room_type
                '28.00', // p_p_double_room
                '15.00', // single_room_supp
                '84.00', // triple_room
                '28.00', // 3rd_person
                '', // breakfast_meal
                '8.00', // lunch_meal_supp
                '8.00', // dinner_meal
                '28.00', // extra_bed
                '8.00', // extra_meal
                '', // sea_view_room_supp
                '' // note
            ],
            [
                '2', // accommodation_id
                '3', // region_id
                'Asia', // regions
                '23', // subregion_id
                'Middle East', // subregions
                '111', // country_id
                'Jordan', // countries
                '63142', // city_id
                'Wadi Rum', // cities
                'All', // nationalities_rates
                'USD', // currency
                'Wadi Rum', // city
                'camp', // type
                '12', // accommodation_type_id
                '3*', // classification
                'CAPTAIN\'S MAIN CAMP', // name
                'CAPTAIN\'S MAIN CAMP', // name_ar
                'Wednesday, January 1, 2025', // season_from
                'Monday, December 29, 2025', // season_to
                'Deluxe room Tent, WC, H.B', // room_type
                '35.00', // p_p_double_room
                '20.00', // single_room_supp
                '105.00', // triple_room
                '35.00', // 3rd_person
                '', // breakfast_meal
                '10.00', // lunch_meal_supp
                '10.00', // dinner_meal
                '35.00', // extra_bed
                '10.00', // extra_meal
                '', // sea_view_room_supp
                '' // note
            ]
        ];

        // Create CSV content
        $csv = fopen('php://temp', 'w');
        fputcsv($csv, $headers);

        foreach ($sampleData as $row) {
            fputcsv($csv, $row);
        }

        rewind($csv);
        $csvContent = stream_get_contents($csv);
        fclose($csv);

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="accommodations_sample.csv"',
        ]);
    }
}
