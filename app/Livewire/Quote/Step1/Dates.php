<?php

namespace App\Livewire\Quote\Step1;

use Livewire\Component;

class Dates extends Component
{
    public $arrival_date;
    public $departure_date;
    public $invalidDates = false;

    public function updatedDepartureDate()
    {
        if ($this->arrival_date && $this->departure_date <= $this->arrival_date) {
            // نخلي المغادرة بعد الوصول بيوم واحد
            $this->departure_date = date('Y-m-d', strtotime($this->arrival_date));

            $this->invalidDates = true;
        } else {
            $this->invalidDates = false;
        }
    }

    public function render()
    {
        return view('livewire.quote.step1.dates');
    }
}