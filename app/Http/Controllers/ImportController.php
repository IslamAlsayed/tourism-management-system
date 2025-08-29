<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportController extends Controller
{
    /**
     * Show import form for users
     */
    public function showUserImport()
    {
        return view('dashboard.imports.user-import', [
            'title' => __('main.import_users'),
            'description' => __('main.import_users_description'),
        ]);
    }

    /**
     * Show import form for countries
     */
    public function showCountryImport()
    {
        return view('dashboard.imports.country-import', [
            'title' => __('main.import_countries'),
            'description' => __('main.import_countries_description'),
        ]);
    }

    /**
     * Show import form for cities
     */
    public function showCityImport()
    {
        return view('dashboard.imports.city-import', [
            'title' => __('main.import_cities'),
            'description' => __('main.import_cities_description'),
        ]);
    }

    /**
     * Show import form for currencies
     */
    public function showCurrencyImport()
    {
        return view('dashboard.imports.currency-import', [
            'title' => __('main.import_currencies'),
            'description' => __('main.import_currencies_description'),
        ]);
    }

    /**
     * Process the import for users
     */
    public function importUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $data = $this->readSpreadsheetFile($file);

            // Remove header row
            $header = array_shift($data);

            // Validate expected columns
            $requiredColumns = ['name', 'email', 'password'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                return redirect()->back()
                    ->with('error', __('main.missing_columns') . implode(', ', $missingColumns));
            }

            DB::beginTransaction();

            $imported = 0;
            $errors = [];

            foreach ($data as $rowIndex => $row) {
                // Convert row to associative array
                $userData = array_combine($header, $row);

                // Validate each row
                $rowValidator = Validator::make($userData, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                ]);

                if ($rowValidator->fails()) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                // Create user
                User::create($userData);
                $imported++;
            }

            if (empty($errors)) {
                DB::commit();
                return redirect()->back()
                    ->with('success', __('main.import_success', ['count' => $imported]));
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('main.import_partial_errors'))
                    ->with('import_errors', $errors);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('main.import_error') . $e->getMessage());
        }
    }

    /**
     * Process the import for countries
     */
    public function importCountries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $data = $this->readSpreadsheetFile($file);

            // Remove header row
            $header = array_shift($data);

            // Validate expected columns
            $requiredColumns = ['name', 'iso2', 'iso3'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                return redirect()->back()
                    ->with('error', __('main.missing_columns') . implode(', ', $missingColumns));
            }

            DB::beginTransaction();

            $imported = 0;
            $errors = [];

            foreach ($data as $rowIndex => $row) {
                // Convert row to associative array
                $countryData = array_combine($header, $row);

                // Validate each row
                $rowValidator = Validator::make($countryData, [
                    'name' => 'required|string|max:255',
                    'iso2' => 'required|string|size:2|unique:countries,iso2',
                    'iso3' => 'required|string|size:3|unique:countries,iso3',
                    'currency_id' => 'nullable|exists:currencies,id',
                ]);

                if ($rowValidator->fails()) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                // Create country
                Country::create($countryData);
                $imported++;
            }

            if (empty($errors)) {
                DB::commit();
                return redirect()->back()
                    ->with('success', __('main.import_success', ['count' => $imported]));
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('main.import_partial_errors'))
                    ->with('import_errors', $errors);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Country import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('main.import_error') . $e->getMessage());
        }
    }

    /**
     * Process the import for cities
     */
    public function importCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('file');
            $data = $this->readSpreadsheetFile($file);

            // Remove header row
            $header = array_shift($data);

            // Validate expected columns
            $requiredColumns = ['name', 'country_id'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                return redirect()->back()
                    ->with('error', __('main.missing_columns') . implode(', ', $missingColumns));
            }

            DB::beginTransaction();

            $imported = 0;
            $errors = [];

            foreach ($data as $rowIndex => $row) {
                // Convert row to associative array
                $cityData = array_combine($header, $row);

                // Ensure that required fields are not empty
                if (empty($cityData['name']) || empty($cityData['country_id'])) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": The name field and country_id field are required.";
                    continue;
                }

                // Validate each row
                $rowValidator = Validator::make($cityData, [
                    'name' => 'required|string|max:255',
                    'country_id' => 'required|exists:countries,id',
                ]);

                if ($rowValidator->fails()) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                // Create city
                City::create($cityData);
                $imported++;
            }

            if (empty($errors)) {
                DB::commit();
                return redirect()->back()
                    ->with('success', __('main.import_success', ['count' => $imported]));
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('main.import_partial_errors'))
                    ->with('import_errors', $errors);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('City import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('main.import_error') . $e->getMessage());
        }
    }


    /**
     * Process the import for currencies
     */
    public function importCurrencies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $data = $this->readSpreadsheetFile($file);

            // Remove header row
            $header = array_shift($data);

            // Validate expected columns
            $requiredColumns = ['code', 'name', 'symbol'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                return redirect()->back()
                    ->with('error', __('main.missing_columns') . implode(', ', $missingColumns));
            }

            DB::beginTransaction();

            $imported = 0;
            $errors = [];

            foreach ($data as $rowIndex => $row) {
                // Convert row to associative array
                $currencyData = array_combine($header, $row);

                // Validate each row
                $rowValidator = Validator::make($currencyData, [
                    'code' => 'required|string|max:3|unique:currencies,code',
                    'name' => 'required|string|max:255',
                    'symbol' => 'required|string|max:10',
                ]);

                if ($rowValidator->fails()) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                // Create currency
                Currency::create($currencyData);
                $imported++;
            }

            if (empty($errors)) {
                DB::commit();
                return redirect()->back()
                    ->with('success', __('main.import_success', ['count' => $imported]));
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('main.import_partial_errors'))
                    ->with('import_errors', $errors);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Currency import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('main.import_error') . $e->getMessage());
        }
    }

    /**
     * Read the uploaded spreadsheet file (CSV or Excel)
     */
    private function readSpreadsheetFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $reader = IOFactory::createReader(ucfirst($extension));
        $spreadsheet = $reader->load($file->getPathname());

        return $spreadsheet->getActiveSheet()->toArray();
    }

    /**
     * Generate a sample user import file
     */
    public function userSample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['name', 'email', 'password', 'first_name', 'last_name', 'phone', 'mobile', 'address', 'is_admin', 'is_active'];
        $sheet->fromArray([$headers], NULL, 'A1');

        // Add sample data
        $sampleData = [
            ['John Doe', 'john@example.com', 'password123', 'John', 'Doe', '123-456-7890', '987-654-3210', '123 Main St', '0', '1'],
            ['Jane Smith', 'jane@example.com', 'password123', 'Jane', 'Smith', '123-456-7891', '987-654-3211', '456 Oak Ave', '0', '1'],
        ];
        $sheet->fromArray($sampleData, NULL, 'A2');

        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the response
        $writer = new Xlsx($spreadsheet);
        $filename = 'user_import_sample.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a sample country import file
     */
    public function countrySample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['name', 'name_ar', 'iso2', 'iso3', 'phone_code', 'capital', 'currency_id', 'nationality', 'is_active'];
        $sheet->fromArray([$headers], NULL, 'A1');

        // Add sample data
        $sampleData = [
            ['United States', 'الولايات المتحدة', 'US', 'USA', '1', 'Washington D.C.', '1', 'American', '1'],
            ['Canada', 'كندا', 'CA', 'CAN', '1', 'Ottawa', '1', 'Canadian', '1'],
        ];
        $sheet->fromArray($sampleData, NULL, 'A2');

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the response
        $writer = new Xlsx($spreadsheet);
        $filename = 'country_import_sample.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a sample city import file
     */
    public function citySample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['name', 'name_ar', 'country_id', 'state_id', 'latitude', 'longitude', 'population'];
        $sheet->fromArray([$headers], NULL, 'A1');

        // Add sample data
        $sampleData = [
            ['New York', 'نيويورك', '1', '33', '40.7128', '-74.0060', '8336817'],
            ['Los Angeles', 'لوس أنجلوس', '1', '5', '34.0522', '-118.2437', '3979576'],
        ];
        $sheet->fromArray($sampleData, NULL, 'A2');

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the response
        $writer = new Xlsx($spreadsheet);
        $filename = 'city_import_sample.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a sample currency import file
     */
    public function currencySample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['code', 'name', 'name_ar', 'symbol', 'exchange_rate', 'decimal_places', 'is_active', 'is_major_currency'];
        $sheet->fromArray([$headers], NULL, 'A1');

        // Add sample data
        $sampleData = [
            ['USD', 'US Dollar', 'دولار أمريكي', '$', '1.0000', '2', '1', '1'],
            ['EUR', 'Euro', 'يورو', '€', '1.1000', '2', '1', '1'],
        ];
        $sheet->fromArray($sampleData, NULL, 'A2');

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the response
        $writer = new Xlsx($spreadsheet);
        $filename = 'currency_import_sample.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}