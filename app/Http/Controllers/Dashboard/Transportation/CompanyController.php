<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;

class CompanyController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportation-companies.index');
    }

    public function create()
    {
        return view('pages.dashboard.transportation-companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $transportationCompany = TransportationCompany::create($validated);

        if ($transportationCompany) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.transportation_company')]));
            }
            return redirect()->route('transportation-companies.index')->with('success', __('main.messages.type_created', ['type' => __('main.transportation_company')]));
        }

        return redirect()->route('transportation-companies.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function edit($id)
    {
        $transportationCompany = TransportationCompany::find($id);
        if (!$transportationCompany) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        }
        return view('pages.dashboard.transportation-companies.edit', compact('transportationCompany'));
    }

    public function update(Request $request, $id)
    {
        $transportationCompany = TransportationCompany::find($id);
        if (!$transportationCompany) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
        ]);

        $updated = $transportationCompany->update($validated);

        if ($updated) {
            return redirect()->route('transportation-companies.index')->with('success', __('main.messages.type_updated', ['type' => __('main.transportation_company')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.transportation_company')]));
    }

    public function destroy($id)
    {
        $transportationCompany = TransportationCompany::find($id);
        if (!$transportationCompany) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        }
        $deleted = $transportationCompany->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.transportation_company')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.transportation_company')]));
    }
}