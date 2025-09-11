<?php

namespace App\Livewire\Quote\v1\Step2;

use App\Models\Hotel;
use App\Models\Booking;
use Livewire\Component;
use App\Models\Currency;
use App\Models\HotelRate;
use App\Models\HotelSeason;
use App\Models\HotelRoomType;

class Hotels extends Component
{
    public $hotels = [];
    public $seasons = [];
    public $roomTypes = [];
    public $rates = [];
    public $booking;
    public $hotel_id = '';
    public $hotel_season_id = '';
    public $rooms = [];
    public $nights = 0;
    public $subtotal_hotels = 0.0;
    public $currency_symbol = '';

    public function mount($id)
    {
        $this->booking = Booking::with(['hotel', 'season', 'roomTypes'])->findOrFail($id);

        $this->nights = $this->booking->nights ?? 0;
        $this->hotels = Hotel::orderBy('name')->get();

        // جلب كل الـ seasons الخاصة بالفندق المحدد في الـ booking
        $this->seasons = $this->booking->hotel_id
            ? HotelSeason::where('hotel_id', $this->booking->hotel_id)->get()
            : collect();

        $this->hotel_id = old('hotel_id', $this->booking->hotel_id);
        $this->hotel_season_id = old('hotel_season_id', $this->booking->hotel_season_id);

        // جلب الـ dependent data (seasons, rates, roomTypes)
        $this->loadDependentData();

        // $this->rooms = [];
        // $this->roomTypes = collect();

        // if ($this->hotel_id) {
        //     // جلب كل الغرف الخاصة بالفندق
        //     $hotelRooms = HotelRoomType::where('hotel_id', $this->hotel_id)->get();

        //     foreach ($hotelRooms as $room) {
        //         // تحقق إذا الغرفة موجودة في الـ booking
        //         $bookingRoom = $this->booking->roomTypes->firstWhere('id', $room->id);
        //         $this->rooms[$room->id] = old('rooms.' . $room->id, $bookingRoom->pivot->quantity ?? 0);

        //         $this->roomTypes->push($room);
        //     }
        // }
        $this->rooms = [];
        foreach ($this->roomTypes as $room) {
            $bookingRoom = $this->booking->roomTypes->firstWhere('id', $room->id);
            $this->rooms[$room->id] = old('rooms.' . $room->id, $bookingRoom->pivot->quantity ?? 0);
        }


        $this->currency_symbol = Currency::where('id', $this->booking->currency_id)->value('symbol') ?? '$';

        $this->recalculateSubtotal();
        $this->loadDependentData();
    }

    protected function rules()
    {
        return [
            'hotel_id' => 'nullable|exists:hotels,id',
            'hotel_season_id' => 'nullable|exists:hotel_seasons,id',
            'rooms' => 'array',
            'rooms.*' => 'nullable|integer|min:0',
        ];
    }

    protected $messages = [
        'hotel_id.exists' => 'Selected hotel is invalid.',
        'hotel_season_id.exists' => 'Selected season is invalid.',
        'rooms.*.integer' => 'Room quantities must be numbers.',
        'rooms.*.min' => 'Room quantities cannot be negative.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->recalculateSubtotal();

        $this->booking->update([
            'hotel_id' => $this->hotel_id ?: null,
            'hotel_season_id' => $this->hotel_season_id ?: null,
            'subtotal_hotels' => $this->subtotal_hotels,
        ]);
    }

    public function updatedHotelId2($value)
    {
        $this->hotel_season_id = '';
        $this->rooms = [];
        $this->seasons = [];
        $this->roomTypes = [];
        $this->rates = [];

        $this->loadDependentData();

        if ($this->booking->id) {
            $this->booking->roomTypes()->sync([]);
        }
    }

    public function updatedHotelId($value)
    {
        $this->seasons = $value
            ? HotelSeason::where('hotel_id', $value)->get()
            : collect();

        $this->hotel_season_id = null;
    }

    public function updatedHotelSeasonId($value)
    {
        $this->rooms = [];
        $this->rates = [];
        $this->roomTypes = [];

        $this->loadDependentData();

        if ($this->booking->id) {
            $this->booking->roomTypes()->sync([]);
        }
    }

    public function updatedRooms($value, $key)
    {
        $this->recalculateSubtotal();
        $syncData = [];
        foreach ($this->rooms as $roomTypeId => $quantity) {
            if ($quantity > 0) {
                $syncData[$roomTypeId] = ['quantity' => $quantity];
            }
        }

        $this->booking->roomTypes()->sync($syncData);
    }

    public function loadDependentData()
    {
        // جلب كل الـ seasons إذا اخترنا فندق
        $this->seasons = $this->hotel_id
            ? HotelSeason::where('hotel_id', $this->hotel_id)->get()
            : collect();

        // جلب الـ rates فقط إذا اخترنا موسم وفندق متوافقين
        if ($this->hotel_id && $this->hotel_season_id) {
            $this->rates = HotelRate::with('roomType')
                ->where('hotel_id', $this->hotel_id)
                ->where('hotel_season_id', $this->hotel_season_id)
                ->get();
        } else {
            $this->rates = collect();
        }

        // جلب كل الغرف الخاصة بالفندق
        $this->roomTypes = $this->hotel_id
            ? HotelRoomType::where('hotel_id', $this->hotel_id)->get()
            : collect();

        // تهيئة الكميات لكل غرفة بناءً على الـ booking أو القيمة القديمة
        foreach ($this->roomTypes as $room) {
            $bookingRoom = $this->booking->roomTypes->firstWhere('id', $room->id);
            $this->rooms[$room->id] = old('rooms.' . $room->id, $bookingRoom->pivot->quantity ?? 0);
        }

        // إعادة حساب subtotal مع التحقق من وجود rates
        $this->recalculateSubtotal();
    }

    public function recalculateSubtotal()
    {
        $this->subtotal_hotels = 0;

        if ($this->nights <= 0 || empty($this->rooms)) {
            return;
        }
        $ratesByRoom = $this->rates->keyBy('room_type_id');

        foreach ($this->rooms as $roomTypeId => $quantity) {
            if ($quantity <= 0)
                continue;

            $rate = $ratesByRoom[$roomTypeId] ?? null;

            if ($rate && $rate->roomType) {
                $occupancy = $rate->roomType->max_occupancy ?? 1;
                $totalPeople = min($occupancy, $this->booking->adults + $this->booking->children);

                $roomTotal = $quantity * $rate->rate_per_person * $totalPeople * $this->nights;

                $singleSupplementAmount = 0;
                if ($totalPeople == 1 && $rate->single_supplement) {
                    $singleSupplementAmount = $rate->single_supplement * $quantity;
                }

                $this->subtotal_hotels += $roomTotal + $singleSupplementAmount;
            }
        }
    }

    public function checkOccupancy()
    {
        if (!$this->hotel_season_id)
            return true;

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
        return view('livewire.quote.v1.step2.hotels', [
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