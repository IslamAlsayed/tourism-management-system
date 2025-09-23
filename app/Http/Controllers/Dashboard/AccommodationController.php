<?php

namespace App\Http\Controllers\Dashboard;

use App\Excels\Accommodations\RateDetails\ImportRateDetails;
use App\Models\Country;
use App\Models\RateDetail;
use App\Models\Supplement;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\HotelRoomType;
use App\Models\AccommodationRate;
use App\Models\Type;
use App\Models\AccommodationSeason;
use App\Http\Controllers\Controller;
use App\Livewire\Quote\Step2\Hotels;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Accommodations\Rates\ExportRates;
use App\Excels\Accommodations\Rates\ImportRates;
use App\Excels\Accommodations\Types\ExportTypes;
use App\Excels\Accommodations\Types\ImportTypes;
use App\Excels\Accommodations\Hotels\ExportHotels;
use App\Excels\Accommodations\Hotels\ImportHotels;
use App\Excels\Accommodations\Seasons\ExportSeasons;
use App\Excels\Accommodations\Seasons\ImportSeasons;
use App\Excels\Accommodations\Supplements\ExportSupplements;
use App\Excels\Accommodations\Supplements\ImportSupplements;
use App\Excels\Accommodations\Accommodations\ExportAccommodations;
use App\Excels\Accommodations\Accommodations\ImportAccommodations;
use App\Excels\Accommodations\RoomsTypes\ImportRoomsTypes;

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