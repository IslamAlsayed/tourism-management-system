<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Countries\ExportCountries;
use App\Excels\Countries\ImportCountries;
use App\Http\Requests\Countries\CreateCountriesRequest;
use App\Http\Requests\Countries\UpdateCountriesRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::with('currency')->paginate(10);
        $totalCountries = Country::count();
        return view('pages.dashboard.countries.index', compact('countries', 'totalCountries'));
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.countries.create', compact('currencies'));
    }

    public function store(CreateCountriesRequest $request)
    {
        $validated = $request->validated();

        // Handle flag upload
        if ($request->hasFile('flag')) {
            $flagPath = $request->file('flag')->store('countries/flags', 'public');
            $validated['flag'] = $flagPath;
        }

        // Handle checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['is_independent'] = $request->has('is_independent');
        $validated['is_developed'] = $request->has('is_developed');
        $validated['is_landlocked'] = $request->has('is_landlocked');

        $created = Country::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->route('countries.create')->with('success', __('main.messages.country_created'));
            }
            return redirect()->route('countries.index')->with('success', __('main.messages.country_created'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_creation_failed'));
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.countries.edit', compact('country', 'currencies'));
    }

    public function update(UpdateCountriesRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $validated = $request->validated();

        $updated = $country->update($validated);
        if ($updated) {
            return redirect()->route('countries.index')->with('success', __('main.messages.country_updated'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_updated_failed'));
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $deleted = $country->delete();
        if ($deleted) {
            return redirect()->route('countries.index')->with('success', __('main.messages.country_deleted'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_deletion_failed'));
    }

    /**
     * Handle bulk edit actions for selected countries.
     */
    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->with('error', __('main.messages.select_countries_and_action'));
        }

        switch ($action) {
            case 'delete':
                $deleted = \App\Models\Country::whereIn('id', $ids)->delete();
                return redirect()->back()->with('success', __('main.messages.countries_deleted', ['count' => $deleted]));
            // يمكنك إضافة إجراءات أخرى هنا مثل التفعيل أو التعطيل
            default:
                return redirect()->back()->with('error', __('main.messages.unknown_action'));
        }
    }

    public function getCountriesToImport()
    {
        $title = __('main.import_types', ['types' => __('main.countries')]);
        $description = __('main.import_types_description', ['types' => __('main.countries')]);

        return view('pages.dashboard.countries.import', compact('title', 'description'));
    }

    public function postCountriesToImport(Request $request)
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

            $importer = new ImportCountries();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'countries' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'countries', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getCountriesToExport()
    {
        $countries = Country::all();
        $filename = generateUniqueFilename('countries') . '.csv';
        return Excel::download(new ExportCountries($countries), $filename);
    }
}