<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Type;
use App\Models\Region;
use App\Models\Country;
use App\Models\Subregion;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\Restaurants\ExportRestaurants;
use App\Excels\Restaurants\ImportRestaurants;
use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Http\Requests\Restaurant\RestaurantUpdateRequest;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with(['country', 'city'])->paginate(getPaginate());
        $total = Restaurant::count();
        return view('pages.dashboard.restaurants.index', compact('restaurants', 'total'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all();

        return view('pages.dashboard.restaurants.create', compact('countries', 'cities', 'regions', 'subregions', 'types'));
    }

    public function store(RestaurantCreateRequest $request)
    {
        $validated = $request->validated();

        $restaurant = Restaurant::create($validated);

        if ($restaurant) {
            return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_created'));
        }

        return redirect()->route('restaurants.index')->with('error', __('main.messages.restaurant_creation_failed'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $countries = Country::all();
        $cities = City::all();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all();

        return view('pages.dashboard.restaurants.edit', compact('restaurant', 'countries', 'cities', 'regions', 'subregions', 'types'));
    }

    public function update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $validated = $request->validated();

        $restaurant->update($validated);

        return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_updated'));
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $deleted = $restaurant->delete();
        if ($deleted) {
            return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_deleted'));
        }

        return redirect()->route('restaurants.index')->with('error', __('main.messages.restaurant_deletion_failed'));
    }

    public function getRestaurantsToImport()
    {
        $model = 'restaurants';
        $title = __('main.import_types', ['types' => __('main.restaurants')]);
        $description = __('main.import_types_description', ['types' => __('main.restaurants')]);

        return view('pages.dashboard.restaurants.import', compact('model', 'title', 'description'));
    }

    public function postRestaurantsToImport(Request $request)
    {
        if (!$request) {
            return redirect()->back()->withError(__('Please Select File.'));
        }

        try {
            if (!$request->hasFile('file')) {
                return redirect()->back()->withError(__('No file uploaded.'));
            }

            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();

            if (!in_array($fileExtension, ['csv', 'xlsx', 'xls'])) {
                return redirect()->back()->withError(__('This file extension is not allowed. <br/> please select a valid CSV file.'));
            }

            $importer = new ImportRestaurants();

            Excel::import($importer, $file->getRealPath());

            $rowCount = $importer->rowCount;

            if ($rowCount > 0) {
                $filename = 'restaurants' . '_' . now()->format('Y_m_d_His') . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/excels/' . 'restaurants', $filename);

                $rowCount = $importer->rowCount;

                return redirect()->back()->withSuccess(__("Data Imported Successfully. $rowCount rows added."));
            }

            return redirect()->back()->withError(__('Excel file does not contain data'));
        } catch (\Exception $e) {
            return redirect()->back()->withError(__('Import Failed: ' . $e->getMessage()));
        }
    }

    public function getRestaurantsToExport()
    {
        $restaurants = Restaurant::all();
        $filename = generateUniqueFilename('restaurants') . '.csv';
        return Excel::download(new ExportRestaurants($restaurants), $filename);
    }
}