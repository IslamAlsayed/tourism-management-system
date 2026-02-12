<?php

namespace App\Livewire\Quote\v1\Step1;

use App\Models\Booking;
use Modules\Geography\Entities\Nationality;
use Livewire\Component;
use Modules\Localization\Entities\Currency;

class Information extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $nationality_id;
    public $currency_id;
    public $arrival_date;
    public $departure_date;
    public $nights;
    public $adults = 1;
    public $children = 0;
    public $infants = 0;
    public $nationalities = [];
    public $currencies = [];
    public $booking = [];

    public function mount()
    {
        $this->nationalities = Nationality::all();
        $this->currencies = Currency::all();

        $this->booking = Booking::where('user_id', auth()->id())
            ->where('status', 'draft')->latest()->first();

        if ($this->booking) {
            $this->fill($this->booking->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'nationality_id',
                'currency_id',
                'arrival_date',
                'departure_date',
                'nights',
                'adults',
                'children',
                'infants'
            ]));
        }
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone' => 'required|string|min:6',
            'nationality_id' => 'required|exists:nationalities,id',
            'currency_id' => 'required|exists:currencies,id',
            'arrival_date' => 'required|date',
            'nights' => 'required|integer|min:1',
            'departure_date' => 'required|date|after:arrival_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->arrival_date && $this->departure_date) {
            $this->computeNights();
        }

        $this->saveBooking();
    }

    public function saveBooking()
    {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'nationality_id' => $this->nationality_id,
            'currency_id' => $this->currency_id,
            'arrival_date' => $this->arrival_date,
            'departure_date' => $this->departure_date,
            'nights' => $this->nights,
            'adults' => $this->adults,
            'children' => $this->children,
            'infants' => $this->infants,
            'user_id' => auth()->id(),
            'status' => 'draft',
        ];

        $this->booking = Booking::updateOrCreate(
            ['id' => $this->booking->id ?? null],
            $data
        );
    }

    public function computeNights()
    {
        if ($this->arrival_date && $this->departure_date) {
            $arrival = \Carbon\Carbon::parse($this->arrival_date);
            $departure = \Carbon\Carbon::parse($this->departure_date);

            $this->nights = max(1, (int) $arrival->diffInDays($departure));
        }
    }

    public function submit()
    {
        $this->validate();
        $this->saveBooking();
        return redirect()->route('dashboard.quote.v1.step2', $this->booking->id);
    }

    public function render()
    {
        return view('livewire.quote.v1.step1.information', [
            'currencies' => $this->currencies,
            'nationalities' => $this->nationalities,
        ]);
    }
}
