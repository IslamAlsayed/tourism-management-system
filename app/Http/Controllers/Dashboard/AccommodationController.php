<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Supplement;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\HotelRoomType;
use App\Models\AccommodationType;
use App\Models\AccommodationTypes;
use App\Models\AccommodationSeason;
use App\Http\Controllers\Controller;
use App\Livewire\Quote\Step2\Hotels;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Accommodations\Types\ExportTypes;
use App\Excels\Accommodations\Types\ImportTypes;
use App\Excels\Nationalities\ExportNationalities;
use App\Excels\Nationalities\ImportNationalities;
use App\Excels\Accommodations\Hotels\ExportHotels;
use App\Excels\Accommodations\Hotels\ImportHotels;
use App\Excels\Accommodations\Seasons\ExportSeasons;
use App\Excels\Accommodations\Seasons\ImportSeasons;
use App\Excels\Accommodations\Supplements\ExportSupplements;
use App\Excels\Accommodations\Supplements\ImportSupplements;
use App\Excels\Accommodations\Accommodations\ExportAccommodations;
use App\Excels\Accommodations\Accommodations\ImportAccommodations;
use App\Excels\Accommodations\HotelsRoomsTypes\ImportHotelsRoomsTypes;

class AccommodationController extends Controller
{
    public function index()
    {
        return 'code...';
        // $nationalities = Nationality::paginate(10);
        // $total = Nationality::count();
        // return view('pages.dashboard.nationalities.index', compact('nationalities', 'total'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getAccommodationsToImport()
    {
        $model = 'accommodations';
        $title = __('main.import_types', ['types' => __('main.accommodations')]);
        $description = __('main.import_types_description', ['types' => __('main.accommodations')]);

        return view('pages.dashboard.accommodations.import', compact('model', 'title', 'description'));
    }

    public function postAccommodationsToImport(Request $request)
    {
        if (!$request) {
            return redirect()->back()->withError(__('Please Select File.'));
        }

        try {
            if (!$request->has('import_type')) {
                return redirect()->back()->withError(__('Please Select Import Type.'));
            }

            if (!$request->hasFile('file')) {
                return redirect()->back()->withError(__('No file uploaded.'));
            }

            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();

            if (!in_array($fileExtension, ['csv', 'xlsx', 'xls'])) {
                return redirect()->back()->withError(__('This file extension is not allowed. <br/> please select a valid CSV file.'));
            }

            if ($request->input('import_type') == 'hotels') {
                $importer = new ImportHotels();
            } else if ($request->input('import_type') == 'room_types') {
                $importer = new ImportHotelsRoomsTypes();
            } else if ($request->input('import_type') == 'accommodations_types') {
                $importer = new ImportTypes();
            } else if ($request->input('import_type') == 'accommodations') {
                $importer = new ImportAccommodations();
            } else if ($request->input('import_type') == 'seasons') {
                $importer = new ImportSeasons();
            } else if ($request->input('import_type') == 'supplements') {
                $importer = new ImportSupplements();
            } else {
                dd('other');
            }

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = $request->input('import_type') . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/accommodations/' . $request->input('import_type'), $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getAccommodationsToExport($type)
    {
        if ($type == 'hotels') {
            $hotels = Hotels::all();
            $filename = generateUniqueFilename('hotels') . '.csv';
            return Excel::download(new ExportHotels($hotels), $filename);
        } else if ($type == 'room_types') {
            $roomTypes = HotelRoomType::all();
            $filename = generateUniqueFilename('room_types') . '.csv';
            return Excel::download(new ExportTypes($roomTypes), $filename);
        } else if ($type == 'accommodations_types') {
            $types = AccommodationType::all();
            $filename = generateUniqueFilename('accommodations_types') . '.csv';
            return Excel::download(new ExportTypes($types), $filename);
        } else if ($type == 'accommodations') {
            $accommodations = Accommodation::all();
            $filename = generateUniqueFilename('accommodations') . '.csv';
            return Excel::download(new ExportAccommodations($accommodations), $filename);
        } else if ($type == 'seasons') {
            $seasons = AccommodationSeason::all();
            $filename = generateUniqueFilename('seasons') . '.csv';
            return Excel::download(new ExportSeasons($seasons), $filename);
        } else if ($type == 'supplements') {
            $supplements = Supplement::all();
            $filename = generateUniqueFilename('supplements') . '.csv';
            return Excel::download(new ExportSupplements($supplements), $filename);
        }

        return 'code...';
    }
}