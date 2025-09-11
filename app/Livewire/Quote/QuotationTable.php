<?php

namespace App\Livewire\Quote;
use App\Models\Booking;
use Livewire\Component;

class QuotationTable extends Component
{
    public $trips = 0;
    public $quotations = [];

    public function mount()
    {
        $this->quotations = Booking::all();
    }

    public function render()
    {
        return view('livewire.quote.quotation-table', [
            'data' => $this->quotations
        ]);
    }
}