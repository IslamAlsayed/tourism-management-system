<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\subregion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Subregions\ExportSubregions;
use App\Excels\Subregions\ImportSubregions;

class SubregionController extends Controller
{
    public function index()
    {
        $subregions = Subregion::paginate(10);
        $total = Subregion::count();
        return view('pages.dashboard.subregions.index', compact('subregions', 'total'));
    }

    public function create()
    {
        return 'code...';
    }

    public function getSubregionsToImport()
    {
        $title = __('main.import_subregions');
        $description = __('main.import_subregions_description');

        return view('pages.dashboard.subregions.import', compact('title', 'description'));
    }

    public function postSubregionsToImport(Request $request)
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

            $importer = new ImportSubregions();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'subregions' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'subregions', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getSubregionsToExport()
    {
        $subregions = Subregion::all();
        $filename = generateUniqueFilename('subregions') . '.csv';
        return Excel::download(new ExportSubregions($subregions), $filename);
    }
}