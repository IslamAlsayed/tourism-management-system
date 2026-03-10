<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\AccommodationType;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::paginate(getPaginate());
        $total = Hotel::count();
        return view('pages.dashboard.accommodations.hotels.index', compact('hotels', 'total'));
    }

    public function create()
    {
        $types = AccommodationType::all();
        return view('pages.dashboard.accommodations.create', compact('types'));
    }
}
