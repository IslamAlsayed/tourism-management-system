<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NationalityController extends Controller
{
    public function index()
    {
        $nationalities = Nationality::paginate(getPaginate());
        $total = Nationality::count();
        return view('pages.dashboard.nationalities.index', compact('nationalities', 'total'));
    }

    public function create()
    {
        return 'code...';
    }
}