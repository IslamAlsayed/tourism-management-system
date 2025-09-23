<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}