<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::paginate(10);
        $totalCurrencies = Currency::count();
        return view('pages.dashboard.currencies.index', compact('currencies', 'totalCurrencies'));
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        return view('pages.dashboard.currencies.edit', compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:5',
        ]);

        $updated = $currency->update($validated);
        if ($updated) {
            return redirect()->route('currencies.index')->with('success', 'Currency updated successfully');
        }

        return redirect()->route('currencies.index')->with('error', 'Currency update failed');
    }
}