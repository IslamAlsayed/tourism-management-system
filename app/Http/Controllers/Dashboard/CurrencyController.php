<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Currencies\ExportCurrencies;
use App\Excels\Currencies\ImportCurrencies;
use App\Http\Requests\Currency\CreateCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::paginate(10);
        $totalCurrencies = Currency::count();
        return view('pages.dashboard.currencies.index', compact('currencies', 'totalCurrencies'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.dashboard.currencies.create', compact('countries'));
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        $countries = Country::all();
        return view('pages.dashboard.currencies.edit', compact('currency', 'countries'));
    }

    public function store(CreateCurrencyRequest $request)
    {
        $validated = $request->validated();
        $currency = Currency::create($validated);

        if ($currency) {
            if ($request->has('save_and_add')) {
                return redirect()->route('currencies.create')->with('success', __('main.messages.currency_created'));
            }
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_created'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_creation_failed'));
    }

    public function update(UpdateCurrencyRequest $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $validated = $request->validated();
        $updated = $currency->update($validated);

        if ($updated) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_updated'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_updated_failed'));
    }

    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $deleted = $currency->delete();
        if ($deleted) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_deleted'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_deletion_failed'));
    }

    // public function rates()
    // {
    //     return view('pages.dashboard.currencies.rates');
    // }

    // public function updateRates(Request $request)
    // {
    //     // Logic for updating exchange rates
    //     return redirect()->route('currencies.rates')->with('success', __('main.messages.rates_updated'));
    // }

    public function getCurrenciesToImport()
    {
        $title = __('main.import_types', ['types' => 'currencies']);
        $description = __('main.import_types_description', ['types' => 'currencies']);

        return view('pages.dashboard.currencies.import', compact('title', 'description'));
    }

    public function postCurrenciesToImport(Request $request)
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

            $importer = new ImportCurrencies();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'currencies' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'currencies', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getCurrenciesToExport()
    {
        $currencies = Currency::all();
        $filename = generateUniqueFilename('currencies') . '.csv';
        return Excel::download(new ExportCurrencies($currencies), $filename);
    }
}