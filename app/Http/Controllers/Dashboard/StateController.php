<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\State;
use Illuminate\Http\Request;
use App\Excels\States\ExportStates;
use App\Excels\States\ImportStates;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')->paginate(10);
        $totalStates = State::count();
        return view('pages.dashboard.states.index', compact('states', 'totalStates'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getStatesToImport()
    {
        $model = 'states';
        $title = __('main.import_types', ['types' => __('main.states')]);
        $description = __('main.import_types_description', ['types' => __('main.states')]);

        return view('pages.dashboard.states.import', compact('model', 'title', 'description'));
    }

    public function postStatesToImport(Request $request)
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

            $importer = new ImportStates();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'states' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'states', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getStatesToExport()
    {
        $states = State::all();
        $filename = generateUniqueFilename('states') . '.csv';
        return Excel::download(new ExportStates($states), $filename);
    }
}