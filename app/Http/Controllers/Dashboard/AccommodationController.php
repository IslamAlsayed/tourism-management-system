<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Type;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;

class AccommodationController extends Controller
{
    public function index()
    {
        $accommodations = Accommodation::paginate(getPaginate());
        $total = Accommodation::count();

        return view('pages.dashboard.accommodations.index', compact('accommodations', 'total'));
    }

    public function getResultType($type)
    {
        $typeModel = Type::where('name', 'like', '%' . $type . '%')->first();
        $data = Accommodation::with('type')->where('type_id', $typeModel?->id ?? 0)->paginate(getPaginate());
        $total = $data->total();

        return view('pages.dashboard.accommodations.types', compact('data', 'total', 'type'));
    }

    public function getCreateType($type)
    {
        dd($type);
        // $types = Type::all();
        // return view('pages.dashboard.accommodations.create-type', compact('types'));
    }

    public function create()
    {
        return 'No Create View..!';
    }
}