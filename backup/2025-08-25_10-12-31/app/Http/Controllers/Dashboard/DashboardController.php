<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // بيانات ثابتة مؤقتة بدلاً من قاعدة البيانات
        $stats = [
            'countries' => Country::count(),
            'cities' => City::count(),
            'currencies' => Currency::count(),
            'users' => User::count(),
        ];

        return view('pages.dashboard.index', compact('stats'));
    }
}