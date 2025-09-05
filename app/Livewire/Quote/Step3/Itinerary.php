<?php

namespace App\Livewire\Quote\Step3;

use App\Models\Booking;
use Livewire\Component;
use App\Models\BookingItinerary;

class Itinerary extends Component
{
    public $booking;
    public $nights = 0;
    public $cities = [];
    public $itinerary = [];

    public function mount($id, $cities)
    {
        $this->booking = Booking::findOrFail($id);
        $this->cities = $cities;

        $this->computeNights();

        // Initialize itinerary rows
        for ($i = 1; $i <= $this->nights; $i++) {
            $this->itinerary[$i] = [
                'day_number' => $i,
                'city_id' => null,
                'description' => '',
            ];
        }
    }

    protected function rules()
    {
        return [
            'itinerary' => 'array',
            'itinerary.*.day_number' => 'required|integer|min:1',
            'itinerary.*.city_id' => 'required|exists:cities,id',
            'itinerary.*.description' => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'itinerary.*.day_number.min' => 'Day number must be at least 1.',
        'itinerary.*.city_id.exists' => 'Selected city is invalid.',
        'itinerary.*.description.max' => 'Description may not be greater than 1000 characters.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // $this->booking->update([
        //     'subtotal_services' => $this->subtotal_services,
        // ]);
    }

    public function updatedItinerary($value, $key)
    {
        foreach ($this->itinerary as $id => &$day) {
            $day['day_number'] = (int) ($day['day_number'] ?? 1);
            $day['city_id'] = (int) ($day['city_id'] ?? 0);
            $day['description'] = (string) ($day['description'] ?? '');
        }
    }

    public function computeNights()
    {
        if ($this->booking->arrival_date && $this->booking->departure_date) {
            $arrival = \Carbon\Carbon::parse($this->booking->arrival_date);
            $departure = \Carbon\Carbon::parse($this->booking->departure_date);

            $this->nights = max(1, $arrival->diffInDays($departure));
        }
    }

    public function save()
    {
        $this->validate();
        foreach ($this->itinerary as $day) {
            BookingItinerary::updateOrCreate(
                [
                    'booking_id' => $this->booking->id,
                    'day_number' => $day['day_number']
                ],
                [
                    'city_id' => $day['city_id'],
                    'description' => $day['description']
                ]
            );
        }
        return redirect()->route('dashboard.quote.step4', $this->booking->id);
    }

    public function render()
    {
        return view('livewire.quote.step3.itinerary');
    }
}