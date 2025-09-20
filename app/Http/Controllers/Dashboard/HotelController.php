<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Hotel;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\AccommodationTypes;
use App\Models\AccommodationSeason;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Accommodations\Types\ExportTypes;
use App\Excels\Accommodations\Types\ImportTypes;
use App\Excels\Nationalities\ExportNationalities;
use App\Excels\Nationalities\ImportNationalities;
use App\Excels\Accommodations\Hotels\ImportHotels;
use App\Excels\Accommodations\Seasons\ExportSeasons;
use App\Excels\Accommodations\Seasons\ImportSeasons;
use App\Excels\Accommodations\Accommodations\ExportAccommodations;
use App\Excels\Accommodations\Accommodations\ImportAccommodations;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::paginate(10);
        $total = Hotel::count();
        return view('pages.dashboard.accommodations.hotels.index', compact('hotels', 'total'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getHotelsToImport()
    {
        $model = 'hotels';
        $title = __('main.import_types', ['types' => __('main.hotels')]);
        $description = __('main.import_types_description', ['types' => __('main.hotels')]);

        return view('pages.dashboard.accommodations.hotels.import', compact('model', 'title', 'description'));
    }

    public function postHotelsToImport(Request $request)
    {
        if (!$request) {
            return redirect()->back()->withError(__('Please Select File.'));
        }

        try {
            if (!$request->hasFile('file')) {
                return redirect()->back()->withError(__('No file uploaded.'));
            }

            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();

            if (!in_array($fileExtension, ['csv', 'xlsx', 'xls'])) {
                return redirect()->back()->withError(__('This file extension is not allowed. <br/> please select a valid CSV file.'));
            }

            $importer = new ImportHotels();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'hotels' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/accommodations/hotels', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getHotelsToExport($type)
    {
        $Hotels = Hotel::all();
        $filename = generateUniqueFilename('hotels') . '.csv';
        return Excel::download(new ExportTypes($Hotels), $filename);
    }
}