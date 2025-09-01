<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\HotelRate;
use App\Models\HotelPolicy;
use App\Models\HotelSeason;
use App\Models\OtherService;
use App\Models\HotelRoomType;
use App\Models\HotelSupplement;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Http\Requests\MultiStep\Step1Request;
use App\Http\Requests\MultiStep\Step2Request;
use App\Http\Requests\MultiStep\Step3Request;
use App\Http\Requests\MultiStep\Step4Request;

class MultiStepFormController extends Controller
{
    public function step1()
    {
        $currencies = Currency::all();
        return view('pages.dashboard.multi-step-form.step1', compact('currencies'));
    }

    public function postStep1(Step1Request $request)
    {
        session(['multi_step.currency_id' => $request->currency_id]);
        return redirect()->route('dashboard.multi-step-form.step2');
    }

    public function step2()
    {
        $hotels = Hotel::all();
        $hotelRoomTypes = HotelRoomType::all();
        $hotelSeasons = HotelSeason::all();
        return view('pages.dashboard.multi-step-form.step2', compact('hotels', 'hotelRoomTypes', 'hotelSeasons'));
    }

    public function postStep2(Step2Request $request)
    {
        session([
            'multi_step.hotel_id' => $request->hotel_id,
            'multi_step.room_type_id' => $request->room_type_id,
            'multi_step.hotel_season_id' => $request->hotel_season_id,
        ]);
        return redirect()->route('dashboard.multi-step-form.step3');
    }

    public function step3()
    {
        $hotelRates = HotelRate::get();
        $hotelSupplements = HotelSupplement::get();
        $hotelPolicies = HotelPolicy::get();

        return view('pages.dashboard.multi-step-form.step3', compact('hotelRates', 'hotelSupplements', 'hotelPolicies'));
    }

    public function postStep3(Step3Request $request)
    {
        session([
            'multi_step.rate_ids' => $request->rate_ids,
            'multi_step.supplement_ids' => $request->supplement_ids ?? [],
            'multi_step.policy_ids' => $request->policy_ids ?? [],
        ]);
        return redirect()->route('dashboard.multi-step-form.step4');
    }

    public function step4()
    {
        $transportationCompanies = TransportationCompany::all();
        $otherServices = OtherService::all();
        $suppliers = Supplier::all();

        return view('pages.dashboard.multi-step-form.step4', compact('transportationCompanies', 'otherServices', 'suppliers'));
    }

    public function submit(Step4Request $request)
    {
        $data = session('multi_step', []);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'currency_id' => $data['currency_id'] ?? null,
            'hotel_id' => $data['hotel_id'] ?? null,
            'hotel_room_type_id' => $data['room_type_id'] ?? null,
            'hotel_season_id' => $data['hotel_season_id'] ?? null,
        ]);

        // Attach relations
        if (!empty($request->transportation_company_ids)) {
            $booking->transportationCompanies()->attach($request->transportation_company_ids);
        }

        if (!empty($request->other_service_ids)) {
            $booking->otherServices()->attach($request->other_service_ids);
        }

        if (!empty($request->supplier_ids)) {
            $booking->suppliers()->attach($request->supplier_ids);
        }

        session()->forget('multi_step');

        return redirect()->route('dashboard.multi-step-form.step1')->with('success', 'Booking created successfully.');

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $booking->load(['transportationCompanies', 'otherServices', 'suppliers']),
        // ]);
    }
}