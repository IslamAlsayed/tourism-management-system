<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\HotelRate;
use App\Models\HotelPolicy;
use App\Models\HotelSeason;
use App\Models\OtherService;
use Illuminate\Http\Request;
use App\Models\HotelRoomType;
use App\Models\HotelSupplement;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BookingSummaryMail;
use App\Models\TransportationRate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\TransportationCompany;
use App\Http\Requests\MultiStep\Step1Request;
use App\Http\Requests\MultiStep\Step2Request;
use App\Http\Requests\MultiStep\Step3Request;
use App\Http\Requests\MultiStep\Step4Request;

class BookingController extends Controller
{
    // STEP 1 — Create draft & basic customer info
    public function step1()
    {
        $currencies = Currency::all();
        return view('pages.dashboard.quote.step1', compact('currencies'));
    }

    public function postStep1(Step1Request $request)
    {
        $booking = Booking::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id(), 'status' => 'draft']
        ));

        return redirect()->route('dashboard.quote.step2', $booking);
    }

    // STEP 2 — Services, Rooms & Transport
    // public function step2(Booking $booking)
    public function step2($id)
    {
        $booking = Booking::findOrFail($id);
        $hotels = Hotel::all();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();

        // dd($roomTypes->toArray());

        $transportationCompanies = TransportationCompany::with(['busTypes.rates.route'])->get();

        $extraServices = OtherService::all();
        $otherServices = OtherService::all();

        // dd($transportationCompanies->toArray());

        return view('pages.dashboard.quote.step2', compact(
            'booking',
            'hotels',
            'roomTypes',
            'seasons',
            'transportationCompanies',
            'extraServices',
            'otherServices',
        ));
    }

    public function step2_(Booking $booking)
    {
        $hotels = Hotel::all();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();
        $transportCompanies = TransportationCompany::all();
        // $transportationCompanies = TransportationCompany::all();
        // $transportationCompanies->load('busTypes');
        $transportationCompanies = TransportationCompany::with([
            'busTypes.rates.route' // تحميل الأسعار والمسارات مع كل نوع باص
        ])->get();
        $extraServices = OtherService::all();
        // $suppliers = Supplier::all();
        $otherServices = OtherService::all();

        dd($transportationCompanies->toArray());

        return view('pages.dashboard.quote.step2', compact(
            'booking',
            'hotels',
            'roomTypes',
            'seasons',
            'transportCompanies',
            'transportationCompanies',
            'extraServices',
            // 'suppliers',
            'otherServices',
        ));
    }

    public function postStep2(Step2Request $request, $id)
    {
        $data = $request->all();
        $booking = Booking::findOrFail($id);

        // تحديث بيانات الحجز
        $booking->update([
            'hotel_id' => $data['hotel_id'] ?? null,
            'hotel_season_id' => $data['hotel_season_id'] ?? null,
            'adults' => $data['adults'] ?? 0,
            'children' => $data['children'] ?? 0,
        ]);

        // حساب المجموع الكلي للفنادق
        $nights = $this->calculateNights($booking->arrival_date, $booking->departure_date);
        $hotelSubtotal = $this->calculateHotelSubtotal($data['rooms'], $booking->hotel_id, $booking->hotel_season_id, $nights, $booking->adults, $booking->children);

        // حفظ الـ subtotal في الحجز
        $booking->update([
            'subtotal_hotels' => $hotelSubtotal,
        ]);

        return redirect()->route('dashboard.quote.step3', $booking->id);
    }

    public function postStep2_old(Step2Request $request, $id)
    {
        $data = $request->validated();
        $booking = Booking::findOrFail($id);

        // تحديث بيانات الحجز الأساسية
        $booking->update([
            'currency_id' => $data['currency_id'] ?? $booking->currency_id,
            'hotel_id' => $data['hotel_id'] ?? null,
            'hotel_season_id' => $data['hotel_season_id'] ?? null,
            'adults' => $data['adults'] ?? 0,
            'children' => $data['children'] ?? 0,
        ]);

        // حساب سعر الغرف حسب عدد الغرف وعدد الأشخاص
        $nights = 0;
        if ($booking->arrival_date && $booking->departure_date) {
            $nights = max(0, \Carbon\Carbon::parse($booking->departure_date)
                ->diffInDays(\Carbon\Carbon::parse($booking->arrival_date)));
        }

        $hotelSubtotal = 0;
        $roomsData = $data['rooms'] ?? [];
        foreach ($roomsData as $roomTypeId => $roomCount) {
            if ($roomCount <= 0)
                continue;

            $rate = HotelRate::where('hotel_id', $booking->hotel_id)
                ->where('hotel_season_id', $booking->hotel_season_id)
                ->where('room_type_id', $roomTypeId)
                ->first();

            if (!$rate) {
                continue;
            }

            $room = HotelRoomType::find($roomTypeId);
            $occupancy = $room->max_occupancy ?? 1;

            $totalPeople = min($occupancy, ($booking->adults + $booking->children));

            $hotelSubtotal += $roomCount * $rate->rate_per_person * $totalPeople * $nights;

            // single supplement لو شخص واحد في الغرفة
            if ($totalPeople == 1 && $rate->single_supplement) {
                $hotelSubtotal += $rate->single_supplement;
            }
        }

        // $rate = TransportationRate::where('company_id', $companyId)
        //     ->where('bus_type_id', $busTypeId)
        //     ->where('route_id', $routeId)
        //     ->first();

        // $total = $rate->price_per_day * $days;

        // sync transportation
        $booking->transportationCompanies()->detach();
        $transportIds = $data['transportation_company_ids'] ?? [];
        $daysList = $data['transport_days'] ?? [];
        $priceList = $data['transport_price_per_day'] ?? [];
        $attachTransport = [];
        $transportSubtotal = 0;

        foreach ($transportIds as $i => $transportId) {
            $days = (int) ($daysList[$i] ?? 1);
            $price = (float) ($priceList[$i] ?? 0);
            $attachTransport[$transportId] = ['days' => $days, 'price_per_day' => $price];
            $transportSubtotal += $days * $price;
        }

        if ($attachTransport) {
            $booking->transportationCompanies()->attach($attachTransport);
        }

        // sync extra services
        $booking->otherServices()->detach();
        $serviceIds = $data['other_service_ids'] ?? [];
        $qtyList = $data['service_qty'] ?? [];
        $unitPriceList = $data['service_unit_price'] ?? [];
        $attachServices = [];
        $servicesSubtotal = 0;

        foreach ($serviceIds as $i => $serviceId) {
            $qty = (int) ($qtyList[$i] ?? 1);
            $unitPrice = (float) ($unitPriceList[$i] ?? 0);
            $attachServices[$serviceId] = ['qty' => $qty, 'unit_price' => $unitPrice];
            $servicesSubtotal += $qty * $unitPrice;
        }

        if ($attachServices) {
            $booking->otherServices()->attach($attachServices);
        }

        // sync suppliers
        $booking->suppliers()->sync($data['supplier_ids'] ?? []);

        // حفظ الـ subtotals مؤقتاً
        $booking->update([
            'subtotal_hotels' => $hotelSubtotal,
            'subtotal_transport' => $transportSubtotal,
            'subtotal_services' => $servicesSubtotal,
        ]);

        // dd($booking->toArray());

        return redirect()->route('dashboard.quote.step3', $booking);
    }

    // STEP 3 — Itinerary
    public function step3($id)
    {
        $booking = Booking::findOrFail($id);
        $cities = City::all();
        return view('pages.dashboard.quote.step3', compact('booking', 'cities'));
    }

    public function postStep3(Step3Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->itineraries()->delete();
        foreach ($request->validated()['itinerary'] as $row) {
            $booking->itineraries()->create($row);
        }
        return redirect()->route('dashboard.quote.step4', $booking);
    }

    // STEP 4 — Review & Submit
    public function step4(Booking $booking)
    {
        $booking->load(['currency', 'hotel', 'roomType', 'season', 'transportationCompanies', 'otherServices', 'suppliers', 'itineraries']);
        $totals = $this->calculateTotals($booking);
        return view('pages.dashboard.quote.step4', compact('booking', 'totals'));
    }

    public function submit(Step4Request $request, Booking $booking)
    {
        $booking->load(['currency', 'hotel', 'roomType', 'season', 'transportationCompanies', 'otherServices', 'suppliers', 'itineraries']);
        $totals = $this->calculateTotals($booking, $request->discount ?? 0, $request->tax ?? 0);

        $booking->update([
            'discount' => $totals['discount'],
            'tax' => $totals['tax'],
            'subtotal_hotels' => $totals['subtotal_hotels'],
            'subtotal_transport' => $totals['subtotal_transport'],
            'subtotal_services' => $totals['subtotal_services'],
            'grand_total' => $totals['grand_total'],
            'status' => 'submitted',
        ]);

        // PDF
        $pdf = Pdf::loadView('pdf.booking_summary', [
            'booking' => $booking,
            'totals' => $totals
        ]);

        // Email
        if ($booking->email) {
            Mail::to($booking->email)->send(new BookingSummaryMail($booking, $pdf));
        }

        return redirect()->route('dashboard.quote.step1')->with('success', 'Quote submitted and email sent successfully.');
    }

    // حساب كل الأسعار
    private function calculateTotals(Booking $booking, float $discount = 0, float $tax = 0): array
    {
        $nights = 0;
        if ($booking->arrival_date && $booking->departure_date) {
            $nights = max(0, \Carbon\Carbon::parse($booking->departure_date)
                ->diffInDays(\Carbon\Carbon::parse($booking->arrival_date)));
        }

        $hotelSubtotal = $booking->subtotal_hotels ?? 0;

        $transportSubtotal = $booking->transportationCompanies->sum(function ($t) {
            return ($t->pivot->days ?? 1) * (float) ($t->pivot->price_per_day ?? 0);
        });

        $servicesSubtotal = $booking->otherServices->sum(function ($s) {
            return (int) ($s->pivot->qty ?? 1) * (float) ($s->pivot->unit_price ?? 0);
        });

        $subtotal = $hotelSubtotal + $transportSubtotal + $servicesSubtotal;

        $discount = min($discount, $subtotal);
        $afterDiscount = $subtotal - $discount;
        $taxAmount = round($tax, 2);
        $grandTotal = round($afterDiscount + $taxAmount, 2);

        return [
            'nights' => $nights,
            'subtotal_hotels' => round($hotelSubtotal, 2),
            'subtotal_transport' => round($transportSubtotal, 2),
            'subtotal_services' => round($servicesSubtotal, 2),
            'discount' => round($discount, 2),
            'tax' => $taxAmount,
            'grand_total' => $grandTotal,
        ];
    }

    // دالة لحساب عدد الليالي بين تاريخ الوصول وتاريخ المغادرة
    private function calculateNights($arrivalDate, $departureDate)
    {
        if (!$arrivalDate || !$departureDate) {
            return 0;
        }

        $arrival = \Carbon\Carbon::parse($arrivalDate);
        $departure = \Carbon\Carbon::parse($departureDate);

        return $arrival->diffInDays($departure);
    }

    // دالة لحساب الـ subtotal للفنادق
    private function calculateHotelSubtotal($roomsData, $hotelId, $seasonId, $nights, $adults, $children)
    {
        $subtotal = 0;

        foreach ($roomsData as $roomTypeId => $roomCount) {
            if ($roomCount <= 0)
                continue;

            $rate = HotelRate::where('hotel_id', $hotelId)
                ->where('hotel_season_id', $seasonId)
                ->where('room_type_id', $roomTypeId)
                ->first();

            if ($rate) {
                $room = HotelRoomType::find($roomTypeId);
                $occupancy = $room->max_occupancy ?? 1;
                $totalPeople = min($occupancy, ($adults + $children));

                $subtotal += $roomCount * $rate->rate_per_person * $totalPeople * $nights;

                // إضافة التكلفة الإضافية لو كان هناك شخص واحد
                if ($totalPeople == 1 && $rate->single_supplement) {
                    $subtotal += $rate->single_supplement;
                }
            }
        }

        return $subtotal;
    }
}

class BookingController_old extends Controller
{
    // STEP 1 — Create draft & basic customer info
    public function step1()
    {
        $currencies = Currency::all();
        return view('pages.dashboard.quote.step1', compact('currencies'));
    }

    public function postStep1(Step1Request $request)
    {
        $booking = Booking::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id(), 'status' => 'draft']
        ));
        return redirect()->route('dashboard.quote.step2', $booking);
    }

    // STEP 2 — Services
    public function step2(Booking $booking)
    {
        $hotels = Hotel::all();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();
        $transportationCompanies = TransportationCompany::all();
        $otherServices = OtherService::all();
        $suppliers = Supplier::all();

        return view('pages.dashboard.quote.step2', compact(
            'booking',
            'hotels',
            'roomTypes',
            'seasons',
            'transportationCompanies',
            'otherServices',
            'suppliers'
        ));
    }

    public function postStep2(Step2Request $request, Booking $booking)
    {
        dd($request->all(), $booking->toArray());

        $data = $request->validated();

        // core refs (nullable)
        $booking->update([
            'currency_id' => $data['currency_id'] ?? $booking->currency_id,
            'hotel_id' => $data['hotel_id'] ?? null,
            'hotel_room_type_id' => $data['hotel_room_type_id'] ?? null,
            'hotel_season_id' => $data['hotel_season_id'] ?? null,
        ]);

        // sync transportation with snapshot
        $booking->transportationCompanies()->detach();
        $tIds = $data['transportation_company_ids'] ?? [];
        $days = $data['transport_days'] ?? [];
        $prices = $data['transport_price_per_day'] ?? [];
        $attach = [];
        foreach ($tIds as $i => $id) {
            $attach[$id] = [
                'days' => (int) ($days[$i] ?? 1),
                'price_per_day' => (float) ($prices[$i] ?? 0),
            ];
        }
        if ($attach)
            $booking->transportationCompanies()->attach($attach);

        // sync services with snapshot
        $booking->otherServices()->detach();
        $sIds = $data['other_service_ids'] ?? [];
        $qtys = $data['service_qty'] ?? [];
        $upris = $data['service_unit_price'] ?? [];
        $attach = [];
        foreach ($sIds as $i => $id) {
            $attach[$id] = [
                'qty' => (int) ($qtys[$i] ?? 1),
                'unit_price' => (float) ($upris[$i] ?? 0),
            ];
        }
        if ($attach)
            $booking->otherServices()->attach($attach);

        // suppliers
        $booking->suppliers()->sync($data['supplier_ids'] ?? []);

        // $countDays = $data['departure_date'] - $data['arrival_date'];
        // dd($countDays);

        // dd($booking->toArray());

        return redirect()->route('dashboard.quote.step3', $booking);
    }

    // STEP 3 — Itinerary
    public function step3(Booking $booking)
    {
        $cities = City::all();
        return view('pages.dashboard.quote.step3', compact('booking', 'cities'));
    }

    public function postStep3(Step3Request $request, Booking $booking)
    {
        $booking->itineraries()->delete();
        foreach ($request->validated()['itinerary'] as $row) {
            $booking->itineraries()->create($row);
        }
        return redirect()->route('dashboard.quote.step4', $booking);
    }

    // STEP 4 — Review & Submit
    public function step4(Booking $booking)
    {
        $booking->load(['currency', 'hotel', 'roomType', 'season', 'transportationCompanies', 'otherServices', 'suppliers', 'itineraries']);
        $totals = $this->calculateTotals($booking);
        return view('pages.dashboard.quote.step4', compact('booking', 'totals'));
    }

    public function submit(Step4Request $request, Booking $booking)
    {
        $booking->load(['currency', 'hotel', 'roomType', 'season', 'transportationCompanies', 'otherServices', 'suppliers', 'itineraries']);
        $totals = $this->calculateTotals($booking, $request->discount ?? 0, $request->tax ?? 0);

        $booking->update([
            'discount' => $totals['discount'],
            'tax' => $totals['tax'],
            'subtotal_hotels' => $totals['subtotal_hotels'],
            'subtotal_transport' => $totals['subtotal_transport'],
            'subtotal_services' => $totals['subtotal_services'],
            'grand_total' => $totals['grand_total'],
            'status' => 'submitted',
        ]);

        // PDF
        $pdf = Pdf::loadView('pdf.booking_summary', [
            'booking' => $booking,
            'totals' => $totals
        ]);

        // Email
        if ($booking->email) {
            Mail::to($booking->email)->send(new BookingSummaryMail($booking, $pdf));
        }

        return redirect()->route('dashboard.quote.step1')->with('success', 'Quote submitted and email sent successfully.');
    }

    private function calculateTotals(Booking $booking, float $discount = 0, float $tax = 0): array
    {
        // subtotal hotels — مثال: rate_per_person * adults * nights (لو عندك rates فعلياً احسبها هنا)
        $nights = 0;
        if ($booking->arrival_date && $booking->departure_date) {
            $nights = max(0, (new \Carbon\Carbon($booking->departure_date))->diffInDays(new \Carbon\Carbon($booking->arrival_date)));
        }
        $hotelBase = 0; // ضع حساب فندقك الفعلي هنا إن وجد

        // transport
        $transport = $booking->transportationCompanies->sum(function ($t) {
            return ($t->pivot->days ?? 1) * (float) ($t->pivot->price_per_day ?? 0);
        });

        // other services
        $services = $booking->otherServices->sum(function ($s) {
            return (int) ($s->pivot->qty ?? 1) * (float) ($s->pivot->unit_price ?? 0);
        });

        $subHot = round($hotelBase, 2);
        $subTrans = round($transport, 2);
        $subServ = round($services, 2);
        $subtotal = $subHot + $subTrans + $subServ;

        $discount = min($discount, $subtotal);
        $afterDiscount = $subtotal - $discount;
        $taxAmount = round($tax, 2); // أو احسب نسبة مئوية لو تحب
        $grand = round($afterDiscount + $taxAmount, 2);

        return [
            'nights' => $nights,
            'subtotal_hotels' => $subHot,
            'subtotal_transport' => $subTrans,
            'subtotal_services' => $subServ,
            'discount' => round($discount, 2),
            'tax' => $taxAmount,
            'grand_total' => $grand,
        ];
    }
}