<?php

namespace App\Livewire\Quote\v2\Step2;
use App\Models\Booking;
use Livewire\Component;
use App\Models\TransportationCompany;

class Transportation extends Component
{
    public $companies = 1;
    public $tripData = []; // [company => [trip => ['total' => 0, 'bused' => []]]]
    public $transportCompanies = [];

    public function mount()
    {
        $this->transportCompanies = TransportationCompany::with(['busTypes.rates'])->get();

        // أول شركة افتراضية + رحلة افتراضية
        $this->tripData[0][0] = [
            'total' => 0,
            'bused' => []
        ];
    }

    public function addCompany()
    {
        $this->companies++;
        $index = $this->companies - 1;

        // أول رحلة للشركة الجديدة
        $this->tripData[$index][0] = [
            'total' => 0,
            'bused' => []
        ];
    }

    public function addTrip($companyIndex)
    {
        $nextTripIndex = count($this->tripData[$companyIndex]);
        $this->tripData[$companyIndex][$nextTripIndex] = [
            'total' => 0,
            'bused' => []
        ];
    }

    public function removeTrip($companyIndex, $tripIndex)
    {
        if (count($this->tripData[$companyIndex]) > 1) {
            unset($this->tripData[$companyIndex][$tripIndex]);
            $this->tripData[$companyIndex] = array_values($this->tripData[$companyIndex]); // ترتيب الفهارس
        }
    }

    public function render()
    {
        return view('livewire.quote.v2.step2.transportation', [
            'transportCompanies' => $this->transportCompanies
        ]);
    }
}