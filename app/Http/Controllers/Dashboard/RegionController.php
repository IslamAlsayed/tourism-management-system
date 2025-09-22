<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Regions\ExportRegions;
use App\Excels\Regions\ImportRegions;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::paginate(getPaginate());
        $total = Region::count();
        return view('pages.dashboard.regions.index', compact('regions', 'total'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getRegionsToImport()
    {
        $model = 'regions';
        $title = __('main.import_types', ['types' => __('main.regions')]);
        $description = __('main.import_types_description', ['types' => __('main.regions')]);

        return view('pages.dashboard.regions.import', compact('model', 'title', 'description'));
    }

    public function postRegionsToImport(Request $request)
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

            $importer = new ImportRegions();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'regions' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'regions', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getRegionsToExport()
    {
        $regions = Region::all();
        $filename = generateUniqueFilename('regions') . '.csv';
        return Excel::download(new ExportRegions($regions), $filename);
    }
}