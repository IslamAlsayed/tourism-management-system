<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::paginate(10);
        return view('pages.admin.currencies.index', compact('currencies'));
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        return view('pages.admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:5',
        ]);

        $currency->update($validated);
        return redirect()->route('admin.currencies.index')->with('success', 'Currency updated successfully');
    }
}
