<?php

namespace App\Livewire\Quote\Step2;

use Livewire\Component;
use App\Models\HotelRate;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\HotelSeason;
use App\Models\HotelRoomType;

class Hotels extends Component
{
    public $hotels = [];
    public $seasons = [];           // مواسم الفندق بناءً على الفندق المحدد
    public $roomTypes = [];         // أنواع الغرف بناءً على الفندق والموسم
    public $rates = [];             // أسعار الغرف بناءً على الموسم والفندق

    public $booking;

    public $hotel_id = '';
    public $hotel_season_id = '';
    public $rooms = [];             // [room_type_id => qty]

    public $nights = 0;
    public $subtotal_hotels = 0.0;
    public $currency_symbol = '$';

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
        $this->hotels = Hotel::orderBy('name')->get();

        // تحميل الاختيارات السابقة إن وجدت
        $this->hotel_id = $this->booking->hotel_id ?? '';
        $this->hotel_season_id = $this->booking->hotel_season_id ?? '';

        $this->computeNights();
        $this->loadDependentData();
        $this->recalculateSubtotal();
    }

    public function updatedHotelId()
    {
        $this->loadDependentData();
    }

    public function updatedHotelSeasonId()
    {
        $this->loadDependentData();
    }

    public function updatedRooms($value, $key)
    {
        $this->recalculateSubtotal();
    }

    // تحميل البيانات التابعة (مثل أنواع الغرف والأسعار بناءً على الموسم)
    public function loadDependentData()
    {
        if ($this->hotel_id) {
            $this->seasons = HotelSeason::where('hotel_id', $this->hotel_id)->get();
        }

        if ($this->hotel_season_id) {
            // هات الأسعار المتاحة للفندق + الموسم
            $this->rates = HotelRate::with('roomType')
                ->where('hotel_id', $this->hotel_id)
                ->where('hotel_season_id', $this->hotel_season_id)
                ->get();

            // استخرج الغرف الخاصة بالفندق فقط
            $this->roomTypes = HotelRoomType::where('hotel_id', $this->hotel_id)->get();
        }

        $this->recalculateSubtotal();
    }

    // حساب إجمالي المبلغ بناءً على الغرف المختارة
    public function recalculateSubtotal()
    {
        $this->subtotal_hotels = 0;

        if ($this->nights <= 0 || empty($this->rooms) || $this->rates->isEmpty())
            return;

        // إعادة ترتيب الأسعار بحسب room_type_id
        $ratesByRoom = $this->rates->keyBy('room_type_id');

        foreach ($this->rooms as $roomTypeId => $quantity) {
            if ($quantity <= 0)
                continue;

            $rate = $ratesByRoom[$roomTypeId] ?? null;

            if ($rate && $rate->roomType) {
                $occupancy = $rate->roomType->max_occupancy ?? 1;
                $totalPeople = min($occupancy, $this->booking->adults + $this->booking->children);

                // حساب السعر للغرفة
                $roomTotal = $quantity * $rate->rate_per_person * $totalPeople * $this->nights;

                // حساب single supplement
                $singleSupplementAmount = 0;
                if ($totalPeople == 1 && $rate->single_supplement) {
                    $singleSupplementAmount = $rate->single_supplement * $quantity;
                }

                // إضافة الأسعار للـ subtotal
                $this->subtotal_hotels += $roomTotal + $singleSupplementAmount;
            }
        }

        // $this->emit('subtotalUpdated', [
        //     'hotels' => $this->subtotal_hotels,
        // ]);
    }

    // حساب عدد الليالي بناءً على تاريخ الوصول والمغادرة
    public function computeNights()
    {
        if ($this->booking->arrival_date && $this->booking->departure_date) {
            $arrival = \Carbon\Carbon::parse($this->booking->arrival_date);
            $departure = \Carbon\Carbon::parse($this->booking->departure_date);

            // عدد الليالي = الفرق بالأيام
            $this->nights = (int) $arrival->diffInDays($departure);
        }
    }

    public function checkOccupancy()
    {
        if (!$this->hotel_season_id) {
            return true;
        }

        $totalPeople = $this->booking->adults + ($this->booking->children * 0.5) + ($this->booking->infants * 0);
        $coveredPeople = 0;

        foreach ($this->rooms as $roomTypeId => $quantity) {
            if ($quantity <= 0)
                continue;

            $room = $this->roomTypes->firstWhere('id', $roomTypeId);
            if (!$room)
                continue;

            $coveredPeople += $room->max_occupancy * $quantity;
        }

        return $coveredPeople >= $totalPeople;
    }

    public function render()
    {
        return view('livewire.quote.step2.hotels', [
            'hotels' => $this->hotels,
            'roomTypes' => $this->roomTypes,
            'seasons' => $this->seasons,
            'rates' => $this->rates,
            'booking' => $this->booking,
            'nights' => $this->nights,
            'subtotal' => $this->subtotal_hotels,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }
}