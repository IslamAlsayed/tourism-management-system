<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Entities\User;
use App\Http\Controllers\Controller;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;

class ReportsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', 1)->count(),
            'inactive_users' => User::where('is_active', 0)->count(),
            'total_countries' => Country::count(),
            'total_cities' => City::count(),
            'total_currencies' => Currency::count(),
        ];

        return view('core::reports.index', compact('stats'));
    }

    public function users()
    {
        $userStats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', 1)->count(),
            'inactive_users' => User::where('is_active', 0)->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'new_users_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        $recentUsers = User::latest()->take(10)->get();

        return view('core::reports.users', compact('userStats', 'recentUsers'));
    }

    public function locations()
    {
        $locationStats = [
            'total_countries' => Country::count(),
            'total_cities' => City::count(),
            'countries_without_cities' => Country::count(),
            'avg_cities_per_country' => round(City::count() / (Country::count() ?: 1), 2),
        ];
        $topCountries = Country::take(10)->get();
        return view('core::reports.locations', compact('locationStats', 'topCountries'));
    }

    public function analytics()
    {
        $analytics = [
            'growth_metrics' => [
                'users_growth' => $this->calculateGrowthRate('users'),
                'cities_growth' => $this->calculateGrowthRate('cities'),
                'countries_growth' => $this->calculateGrowthRate('countries'),
            ],
            'distribution' => [
                'users_by_status' => [
                    'active' => User::where('is_active', 1)->count(),
                    'inactive' => User::where('is_active', 0)->count(),
                ],
                'cities_by_country' => Country::take(5)->get(),
            ],
        ];

        return view('core::reports.analytics', compact('analytics'));
    }

    private function calculateGrowthRate($type)
    {
        $model = match ($type) {
            'users' => User::class,
            'cities' => City::class,
            'countries' => Country::class,
            default => User::class,
        };

        $currentMonth = $model::whereMonth('created_at', now()->month)->count();
        $lastMonth = $model::whereMonth('created_at', now()->subMonth()->month)->count();

        if ($lastMonth == 0)
            return 100;
        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 2);
    }
}
