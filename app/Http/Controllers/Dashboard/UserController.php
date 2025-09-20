<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Traits\PhotoUploadTrait;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $users = User::paginate(20);
        $totalUsers = User::count();
        return view('pages.dashboard.users.index', compact('users', 'totalUsers'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.dashboard.users.create', compact('countries'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.dashboard.users.show', compact('user'));
    }

    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $user = User::create($validated);

        if ($user) {
            $this->uploadPhoto($request, $user, 'avatar_url', "profile-photos");
            return redirect()->route('users.index')->with('success', __('main.messages.user_created'));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.user_creation_failed'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        return view('pages.dashboard.users.edit', compact('user', 'countries'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        $validated['name'] = ($validated['first_name'] ?? $user->first_name) . ' ' . ($validated['last_name'] ?? $user->last_name);

        $this->uploadPhoto($request, $user, 'avatar_url', "profile-photos");

        $user->update($validated);

        return redirect()->route('users.index')->with('success', __('main.messages.user_updated'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        if ($deleted) {
            $this->deletePhoto($user, 'avatar_url');
            return redirect()->route('users.index')->with('success', __('main.messages.user_deleted'));
        }

        return redirect()->route('users.index')->with('error', __('main.messages.user_deletion_failed'));
    }

    public function getCurrenciesToImport()
    {
        return 'import';
        $title = __('main.import_currencies');
        $description = __('main.import_currencies_description');

        return view('pages.dashboard.currencies.import', compact('title', 'description'));
    }

    public function postCurrenciesToImport(Request $request)
    {
        return 'import';

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
        return 'export';

        $currencies = Currency::all();
        $filename = generateUniqueFilename('currencies') . '.csv';
        return Excel::download(new ExportCurrencies($currencies), $filename);
    }
}