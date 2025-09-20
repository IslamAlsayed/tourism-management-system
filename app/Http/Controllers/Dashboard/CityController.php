<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Excels\Cities\ExportCities;
use App\Excels\Cities\ImportCities;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Cities\CreateCitiesRequest;
use App\Http\Requests\Cities\UpdateCitiesRequest;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->paginate(10);
        $totalCities = City::count();
        return view('pages.dashboard.cities.index', compact('cities', 'totalCities'));
    }

    public function create()
    {
        $countries = Country::orderBy('name_ar')->get();
        $states = State::orderBy('name_ar')->get();
        return view('pages.dashboard.cities.create', compact('countries', 'states'));
    }

    public function store(CreateCitiesRequest $request)
    {
        $validated = $request->validated();
        $created = City::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->route('cities.create')->with('success', __('main.messages.city_created'));
            }
            return redirect()->route('cities.index')->with('success', __('main.messages.city_created'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_creation_failed'));
    }

    public function edit($id)
    {
        $city = City::with('country')->findOrFail($id);
        $countries = Country::all();
        $states = State::orderBy('name_ar')->get();
        return view('pages.dashboard.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(UpdateCitiesRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $validated = $request->validated();

        $updated = $city->update($validated);
        if ($updated) {
            return redirect()->route('cities.index')->with('success', __('main.messages.city_updated'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_update_failed'));
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $deleted = $city->delete();
        if ($deleted) {
            return redirect()->route('cities.index')->with('success', __('main.messages.city_deleted'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_deletion_failed'));
    }

    public function getCitiesToImport()
    {
        $model = 'cities';
        $title = __('main.import_types', ['types' => __('main.cities')]);
        $description = __('main.import_types_description', ['types' => __('main.cities')]);

        return view('pages.dashboard.cities.import', compact('title', 'description'));
    }

    public function postCitiesToImport(Request $request)
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

            $importer = new ImportCities();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'cities' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'cities', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getCitiesToExport()
    {
        $cities = City::all();
        $filename = generateUniqueFilename('cities') . '.csv';
        return Excel::download(new ExportCities($cities), $filename);
    }
}