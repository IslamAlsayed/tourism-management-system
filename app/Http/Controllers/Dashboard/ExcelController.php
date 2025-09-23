<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    protected $supportedModels;

    public function __construct()
    {
        $this->supportedModels = config('excel_models');
    }

    public function getToImport($modelKey)
    {
        if (!isset($this->supportedModels[$modelKey])) {
            abort(404);
        }

        $models = $modelKey;
        $title = __('main.import_types', ['types' => __('main.' . $modelKey)]);
        $description = __('main.import_types_description', ['types' => __('main.' . $modelKey)]);

        return view("pages.dashboard.$models.import", compact('models', 'title', 'description'));
    }

    public function postToImport(Request $request, $modelKey, $type = null)
    {
        if (!isset($this->supportedModels[$modelKey])) {
            abort(404);
        }

        try {
            if ($modelKey == 'accommodations' && !$request->has('importType')) {
                return redirect()->back()->withError(__('Please Select Import Type.'));
            }

            if (!$request->hasFile('file')) {
                return redirect()->back()->withError(__('No file uploaded.'));
            }

            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();

            if (!in_array($fileExtension, ['csv', 'xlsx', 'xls'])) {
                return redirect()->back()->withError(__('This file extension is not allowed.'));
            }

            $prefix = $modelKey == 'accommodations' ? 'accommodations/' . $type : $modelKey;

            if ($type && isset($this->supportedModels[$type])) {
                $modelKey = $type;
            }

            $importerClass = $this->supportedModels[$modelKey]['importer'];
            $importer = new $importerClass();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount ?? 0;

            if ($rowCount > 0) {
                $filename = generateUniqueFilename($modelKey) . '.' . $fileExtension;
                $file->storeAs("uploads/excels/$prefix", $filename);

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getToExport($modelKey, $type = null)
    {
        if (!isset($this->supportedModels[$modelKey])) {
            abort(404);
        }

        if ($type && isset($this->supportedModels[$type])) {
            $modelKey = $type;
        }

        $modelClass = $this->supportedModels[$modelKey]['model'];
        $exporterClass = $this->supportedModels[$modelKey]['exporter'];

        $data = $modelClass::all();
        $filename = generateUniqueFilename($modelKey) . '.' . config('app.excel_export_format', 'xlsx');

        return Excel::download(new $exporterClass($data), $filename);
    }
}