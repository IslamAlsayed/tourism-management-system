<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\HotelRate;
use App\Models\HotelSeason;
use App\Models\OtherService;
use App\Models\HotelRoomType;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BookingSummaryMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\TransportationCompany;
use App\Http\Requests\MultiStep\Step1Request;
use App\Http\Requests\MultiStep\Step2Request;
use App\Http\Requests\MultiStep\Step3Request;
use App\Http\Requests\MultiStep\Step4Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    /**
     * STEP 1 — Create draft & basic customer info.
     */
    public function step1()
    {
        $currencies = Currency::all();
        return view('pages.dashboard.quote.step1', compact('currencies'));
    }

    /**
     * Persist step1 data and create a draft Booking.
     */
    public function postStep1(Step1Request $request)
    {
        $booking = Booking::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id(), 'status' => 'draft']
        ));

        return redirect()->route('dashboard.quote.step2', $booking);
    }

    /**
     * STEP 2 — Services, Rooms & Transport (signature kept for Livewire / routes).
     * @param int|string $id
     */
    public function step2($id)
    {
        $booking = Booking::findOrFail($id);

        // Eager-load heavy nested relations once (consider selective columns later if needed)
        $transportationCompanies = TransportationCompany::with(['busTypes.rates.route'])->get();

        $hotels = Hotel::all();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();
        $extraServices = OtherService::all();
        $otherServices = $extraServices; // kept separate variable name for existing view compatibility

        return view('pages.dashboard.quote.step2', compact(
            'booking',
            'hotels',
            'roomTypes',
            'seasons',
            'transportationCompanies',
            'extraServices',
            'otherServices'
        ));
    }

    /**
     * (Deprecated) Alternative step2 kept for backward compatibility. Avoid new usage.
     */
    public function step2_(Booking $booking)
    {
        $transportationCompanies = TransportationCompany::with(['busTypes.rates.route'])->get();
        $hotels = Hotel::all();
        $roomTypes = HotelRoomType::all();
        $seasons = HotelSeason::all();
        $transportCompanies = TransportationCompany::all();
        $extraServices = OtherService::all();
        $otherServices = $extraServices;

        return view('pages.dashboard.quote.step2', compact(
            'booking',
            'hotels',
            'roomTypes',
            'seasons',
            'transportCompanies',
            'transportationCompanies',
            'extraServices',
            'otherServices'
        ));
    }

    /**
     * Minimal post step2 (new flow). Calculation intentionally deferred.
     */
    public function postStep2(Step2Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        // Intentionally lean – business logic handled in legacy method or Livewire layer.
        return redirect()->route('dashboard.quote.step3', $booking->id);
    }

    /**
     * Legacy full featured step2 submission retained for compatibility.
     */
    public function postStep2_old(Step2Request $request, $id)
    {
        $data = $request->validated();
        $booking = Booking::findOrFail($id);

        $booking->update([
            'currency_id' => $data['currency_id'] ?? $booking->currency_id,
            'hotel_id' => $data['hotel_id'] ?? null,
            'hotel_season_id' => $data['hotel_season_id'] ?? null,
            'adults' => $data['adults'] ?? 0,
            'children' => $data['children'] ?? 0,
        ]);

        $nights = $this->getNights($booking->arrival_date, $booking->departure_date);
        $roomsData = $data['rooms'] ?? [];
        $hotelSubtotal = $this->calculateHotelSubtotal(
            $roomsData,
            $booking->hotel_id,
            $booking->hotel_season_id,
            $nights,
            $booking->adults,
            $booking->children
        );

        // Transportation & Services pivot syncs
        [$transportSubtotal, $servicesSubtotal] = $this->syncRelatedSnapshots($booking, $data);

        $booking->update([
            'subtotal_hotels' => $hotelSubtotal,
            'subtotal_transport' => $transportSubtotal,
            'subtotal_services' => $servicesSubtotal,
        ]);

        // Suppliers simple sync
        $booking->suppliers()->sync($data['supplier_ids'] ?? []);

        return redirect()->route('dashboard.quote.step3', $booking);
    }

    /**
     * STEP 3 — Itinerary (id signature kept, some flows pass raw id).
     */
    public function step3($id)
    {
        $booking = Booking::findOrFail($id);
        $cities = City::all();
        return view('pages.dashboard.quote.step3', compact('booking', 'cities'));
    }

    /**
     * Persist itinerary rows.
     */
    public function postStep3(Step3Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->itineraries()->delete();
        foreach ($request->validated()['itinerary'] as $row) {
            $booking->itineraries()->create($row);
        }
        return redirect()->route('dashboard.quote.step4', $booking);
    }

    /**
     * STEP 4 — Review & Submit display.
     */
    public function step4($id)
    {
        $booking = Booking::findOrFail($id);
        $this->eagerLoadBooking($booking);
        // dd($booking->toArray());
        $totals = $this->calculateTotals($booking);
        return view('pages.dashboard.quote.step4', compact('booking', 'totals'));
    }

    /**
     * Final submission: calculate totals, persist & (optionally) email.
     */
    public function submit(Step4Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $this->eagerLoadBooking($booking);

        // 1. خصم ثابت كما أدخله المستخدم
        $discount = max(0, (float) ($request->discount ?? 0));

        // 2. Tax بالنسبة المئوية كما أدخله المستخدم
        $taxPercent = (float) ($request->tax ?? 0) / 100;

        // 3. احسب الـ subtotal من الحقول الثابتة للـ booking
        $subtotalHotels = (float) $booking->subtotal_hotels;
        $subtotalTransport = (float) $booking->subtotal_transport;
        $subtotalServices = (float) $booking->subtotal_services;
        $subtotal = $subtotalHotels + $subtotalTransport + $subtotalServices;

        // 4. احسب الـ tax
        $calculatedTax = round(($subtotal - $discount) * $taxPercent, 2);

        // 5. احسب الـ grand total
        $grandTotal = round($subtotal - $discount + $calculatedTax, 2);

        // 6. احفظ كل القيم في قاعدة البيانات ضمن transaction
        DB::transaction(function () use ($booking, $discount, $calculatedTax, $grandTotal, $subtotalHotels, $subtotalTransport, $subtotalServices) {
            $booking->update([
                'discount' => $discount,
                'tax' => $calculatedTax,
                'subtotal_hotels' => $subtotalHotels,
                'subtotal_transport' => $subtotalTransport,
                'subtotal_services' => $subtotalServices,
                'grand_total' => $grandTotal,
                'status' => 'submitted',
            ]);
        });

        // 7. توليد PDF
        // $pdf = Pdf::loadView('pdf.booking_summary', [
        //     'booking' => $booking,
        //     'totals' => [
        //         'subtotal_hotels' => $subtotalHotels,
        //         'subtotal_transport' => $subtotalTransport,
        //         'subtotal_services' => $subtotalServices,
        //         'discount' => $discount,
        //         'tax' => $calculatedTax,
        //         'grand_total' => $grandTotal,
        //     ],
        // ]);

        // // 8. إرسال البريد إذا كان موجود
        // if ($booking->email) {
        //     Mail::to($booking->email)->send(new BookingSummaryMail($booking, $pdf));
        // }

        return redirect()->route('dashboard.quote.step1')
            ->with('success', 'Quote submitted and email sent successfully.');
    }


    public function submit_old(Step4Request $request, Booking $booking)
    {
        $this->eagerLoadBooking($booking);
        $discount = max(0, (float) ($request->discount ?? 0));
        $tax = (float) ($request->tax ?? 0); // Already absolute value in legacy design
        $totals = $this->calculateTotals($booking, $discount, $tax);

        DB::transaction(function () use ($booking, $totals) {
            $booking->update([
                'discount' => $totals['discount'],
                'tax' => $totals['tax'],
                'subtotal_hotels' => $totals['subtotal_hotels'],
                'subtotal_transport' => $totals['subtotal_transport'],
                'subtotal_services' => $totals['subtotal_services'],
                'grand_total' => $totals['grand_total'],
                'status' => 'submitted',
            ]);
        });

        $pdf = Pdf::loadView('pdf.booking_summary', [
            'booking' => $booking,
            'totals' => $totals,
        ]);

        if ($booking->email) {
            Mail::to($booking->email)->send(new BookingSummaryMail($booking, $pdf));
        }

        return redirect()->route('dashboard.quote.step1')
            ->with('success', 'Quote submitted and email sent successfully.');
    }

    /**
     * Centralized relationships eager load.
     */
    private function eagerLoadBooking(Booking $booking): void
    {
        $booking->load([
            'currency',
            'hotel',
            'roomTypes',
            'season',
            'transportation',
            // 'transportationCompanies',
            'otherServices',
            'suppliers',
            'itineraries'
        ]);
    }

    /**
     * Compute all totals for the booking.
     */
    private function calculateTotals(Booking $booking, float $discount = 0, float $tax = 0): array
    {
        // $nights = $this->getNights($booking->arrival_date, $booking->departure_date);

        // $hotelSubtotal = (float) ($booking->subtotal_hotels ?? 0);
        // $transportSubtotal = $booking->transportationCompanies->sum(fn($t) => ($t->pivot->day ?? 1) * (float) ($t->pivot->price_per_day ?? 0));
        // $servicesSubtotal = $booking->otherServices->sum(fn($s) => (int) ($s->pivot->qty ?? 1) * (float) ($s->pivot->unit_price ?? 0));

        $subtotal = $booking->subtotal_hotels + $booking->subtotal_transport + $booking->subtotal_services;
        $discount = min($discount, $subtotal);
        $afterDiscount = $subtotal - $discount;
        $taxAmount = round($tax, 2); // Assumes absolute number; adjust if percentage needed.
        $grandTotal = round($afterDiscount + $taxAmount, 2);

        return [
            'nights' => $booking->nights,
            'subtotal_hotels' => round($booking->subtotal_hotels, 2),
            'subtotal_transport' => round($booking->subtotal_transport, 2),
            'subtotal_services' => round($booking->subtotal_services, 2),
            'discount' => round($discount, 2),
            'tax' => $taxAmount,
            'grand_total' => $grandTotal,
        ];
    }

    /**
     * Helper to compute nights difference.
     */
    private function getNights($arrivalDate, $departureDate): int
    {
        if (!$arrivalDate || !$departureDate) {
            return 0;
        }
        return Carbon::parse($arrivalDate)->diffInDays(Carbon::parse($departureDate));
    }

    /**
     * Hotel subtotal based on chosen room counts & rates.
     */
    private function calculateHotelSubtotal(array $roomsData, $hotelId, $seasonId, int $nights, int $adults, int $children): float
    {
        if (!$hotelId || !$seasonId || $nights <= 0) {
            return 0.0;
        }

        $subtotal = 0.0;
        foreach ($roomsData as $roomTypeId => $roomCount) {
            if ($roomCount <= 0) {
                continue;
            }

            $rate = HotelRate::where('hotel_id', $hotelId)
                ->where('hotel_season_id', $seasonId)
                ->where('room_type_id', $roomTypeId)
                ->first();

            if (!$rate) {
                continue; // Skip rooms without a rate
            }

            $room = HotelRoomType::find($roomTypeId);
            $occupancy = $room->max_occupancy ?? 1;
            $totalPeople = min($occupancy, ($adults + $children));

            $subtotal += $roomCount * $rate->rate_per_person * $totalPeople * $nights;

            if ($totalPeople === 1 && $rate->single_supplement) {
                $subtotal += $rate->single_supplement;
            }
        }

        return $subtotal;
    }

    /**
     * Sync transportation & services pivot snapshots. Returns array [transportSubtotal, servicesSubtotal].
     */
    private function syncRelatedSnapshots(Booking $booking, array $data): array
    {
        // Transportation
        $booking->transportationCompanies()->detach();
        $transportIds = $data['transportation_company_ids'] ?? [];
        $daysList = $data['transport_days'] ?? [];
        $priceList = $data['transport_price_per_day'] ?? [];
        $attachTransport = [];
        $transportSubtotal = 0.0;
        foreach ($transportIds as $i => $transportId) {
            $days = (int) ($daysList[$i] ?? 1);
            $price = (float) ($priceList[$i] ?? 0);
            $attachTransport[$transportId] = ['days' => $days, 'price_per_day' => $price];
            $transportSubtotal += $days * $price;
        }
        if ($attachTransport) {
            $booking->transportationCompanies()->attach($attachTransport);
        }

        // Other Services
        $booking->otherServices()->detach();
        $serviceIds = $data['other_service_ids'] ?? [];
        $qtyList = $data['service_qty'] ?? [];
        $unitPriceList = $data['service_unit_price'] ?? [];
        $attachServices = [];
        $servicesSubtotal = 0.0;
        foreach ($serviceIds as $i => $serviceId) {
            $qty = (int) ($qtyList[$i] ?? 1);
            $unitPrice = (float) ($unitPriceList[$i] ?? 0);
            $attachServices[$serviceId] = ['qty' => $qty, 'unit_price' => $unitPrice];
            $servicesSubtotal += $qty * $unitPrice;
        }
        if ($attachServices) {
            $booking->otherServices()->attach($attachServices);
        }

        return [$transportSubtotal, $servicesSubtotal];
    }
}

/**
 * @deprecated Legacy backup controller retained only for reference. Prefer using QuoteController.
 */
class BookingController_old extends Controller
{
    // Intentionally left unchanged except for removed debug dumps. Consider removal after full adoption.
}