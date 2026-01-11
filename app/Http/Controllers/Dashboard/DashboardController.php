<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\HotelRate;
use App\Models\HotelPolicy;
use App\Models\HotelSeason;
use App\Models\OtherService;
use Illuminate\Http\Request;
use App\Models\HotelRoomType;
use App\Models\HotelSupplement;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;

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

        // showToastSuccessMessage('Welcome to the Dashboard!');
        // showToastSuccessMessage('Great to see you again!');
        // showToastSuccessMessage('Ready to manage your data?');
        // showToastSuccessMessage('Let\'s get started!');
        // showToastSuccessMessage('Dashboard loaded successfully!');
        // showToastSuccessMessage('Hello! Have a productive day!');
        return view('pages.dashboard.index', compact('stats'));
    }

    public function mainForm_old()
    {
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        $hotels = Hotel::all()->toArray();
        $hotel_room_types = HotelRoomType::all()->toArray();
        $hotel_seasons = HotelSeason::all()->toArray();
        $hotel_rates = HotelRate::all()->toArray();
        $hotel_supplements = HotelSupplement::all()->toArray();
        $hotel_policies = HotelPolicy::all()->toArray();
        $transportations_companies = TransportationCompany::all()->toArray();
        $other_services = OtherService::all()->toArray();
        $suppliers = Supplier::all()->toArray();

        dd(
            $currencies,
            $hotels,
            $hotel_room_types,
            $hotel_seasons,
            $hotel_rates,
            $hotel_supplements,
            $hotel_policies,
            $transportations_companies,
            $other_services,
            $suppliers
        );
    }

    public function mainForm()
    {
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.multi-step-form.index', compact('currencies'));
    }

    public function formStep2(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id'
        ]);

        $hotels = Hotel::with('accommodation')->get();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();

        return view('pages.dashboard.multi-step-form.step2', compact('hotels', 'roomTypes', 'seasons'));
    }

    public function formStep3(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:hotel_room_types,id',
            'hotel_season_id' => 'required|exists:hotel_seasons,id'
        ]);

        $rates = HotelRate::where('hotel_id', $request->hotel_id)
            ->where('room_type_id', $request->room_type_id)
            ->where('hotel_season_id', $request->hotel_season_id)
            ->get();

        $supplements = HotelSupplement::where('hotel_id', $request->hotel_id)->get();
        $policies = HotelPolicy::where('hotel_id', $request->hotel_id)->get();

        return view('pages.dashboard.multi-step-form.step3', compact('rates', 'supplements', 'policies'));
    }

    public function formStep4(Request $request)
    {
        $request->validate([
            'rate_ids' => 'required|array',
            'rate_ids.*' => 'exists:hotel_rates,id',
            'supplement_ids' => 'nullable|array',
            'supplement_ids.*' => 'exists:hotel_supplements,id',
            'policy_ids' => 'nullable|array',
            'policy_ids.*' => 'exists:hotel_policies,id'
        ]);

        $transportationCompanies = TransportationCompany::all();
        $otherServices = OtherService::all();
        $suppliers = Supplier::all();

        return view('pages.dashboard.multi-step-form.step4', compact('transportationCompanies', 'otherServices', 'suppliers'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:hotel_room_types,id',
            'season_id' => 'required|exists:hotel_seasons,id',
            'rate_ids' => 'required|array',
            'rate_ids.*' => 'exists:hotel_rates,id',
            'supplement_ids' => 'nullable|array',
            'supplement_ids.*' => 'exists:hotel_supplements,id',
            'policy_ids' => 'nullable|array',
            'policy_ids.*' => 'exists:hotel_policies,id',
            'transportations_company_ids' => 'nullable|array',
            'transportations_company_ids.*' => 'exists:transportations_companies,id',
            'other_service_ids' => 'nullable|array',
            'other_service_ids.*' => 'exists:other_services,id',
            'supplier_ids' => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,id'
        ]);

        // Process the form data
        $formData = $request->all();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'data' => $formData
        ]);
    }

    public function deleteAll(Request $request)
    {
        $modelClass = "App\\Models\\" . studlyCaseName($request->input('model'));
        if (!class_exists($modelClass)) {
            return redirect()->back()->withError(__('messages.invalid_model_specified'));
        }
        $ids = $request->input('selectedItems');
        if (!$ids || !is_array($ids)) {
            return redirect()->back()->withError(__('messages.no_items_selected'));
        }
        $modelClass::whereIn('id', $ids)->delete();
        return redirect()->back()->withSuccess(__('messages.selected_items_deleted', ['count' => count($ids)]));
    }
}