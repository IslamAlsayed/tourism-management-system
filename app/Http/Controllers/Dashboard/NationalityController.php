<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Nationalities\ExportNationalities;
use App\Excels\Nationalities\ImportNationalities;

class NationalityController extends Controller
{
    public function index()
    {
        $nationalities = Nationality::paginate(getPaginate());
        $total = Nationality::count();
        return view('pages.dashboard.nationalities.index', compact('nationalities', 'total'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getNationalitiesToImport()
    {
        $model = 'nationalities';
        $title = __('main.import_types', ['types' => __('main.nationalities')]);
        $description = __('main.import_types_description', ['types' => __('main.nationalities')]);

        return view('pages.dashboard.nationalities.import', compact('model', 'title', 'description'));
    }

    public function postNationalitiesToImport(Request $request)
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

            $importer = new ImportNationalities();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'nationalities' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'nationalities', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getNationalitiesToExport()
    {
        $nationalities = Nationality::all();
        $filename = generateUniqueFilename('nationalities') . '.csv';
        return Excel::download(new ExportNationalities($nationalities), $filename);
    }
}