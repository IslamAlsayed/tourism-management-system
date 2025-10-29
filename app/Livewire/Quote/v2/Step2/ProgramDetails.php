<?php

namespace App\Livewire\Quote\v2\Step2;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Country;
use Livewire\Component;

class ProgramDetails extends Component
{
    public $trips = 0;
    public $quotations = [];
    public $programDetail = [];
    public $programDetails = [];
    public $stars = [];
    public $countries = [];
    public $cities = [];
    public $hotels = [];

    public function mount()
    {
        $this->programDetails = [
            'accommodation' => '🏨 Accommodation',
            'transportation' => '🚌 Transportation',
            // 'tours' => '⛱️ Tours',
            // 'guide' => '🗣️ Guide',
            // 'restaurants' => '🍽️ Restaurants',
            // 'entrance_fees' => '🏯 Entrance Fees',
            // 'services' => '🎈 Services',
            // '4x4_cars' => '🚔 4x4 Cars',
            // 'visa' => '🏁 Visa',
        ];

        $this->stars = [1, 2, 3, 4, 5];

        $this->countries = Country::all();
        $this->cities = City::all();
        $this->hotels = Hotel::all();
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    //     dd($this->programDetail);
    // }

    public function render()
    {
        return view('livewire.quote.v2.step2.programDetails', [
            'data' => $this->quotations,
            'programDetails' => $this->programDetails,
            'stars' => $this->stars,
            'countries' => $this->countries,
            'cities' => $this->cities,
            'hotels' => $this->hotels,
        ]);
    }
}