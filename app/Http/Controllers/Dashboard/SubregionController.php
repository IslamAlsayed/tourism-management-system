<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\subregion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubregionController extends Controller
{
    public function index()
    {
        $subregions = Subregion::paginate(getPaginate());
        $total = Subregion::count();
        return view('pages.dashboard.subregions.index', compact('subregions', 'total'));
    }

    public function create()
    {
        return 'code...';
    }
}