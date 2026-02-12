<?php

namespace App\Livewire\Quote;

use App\Models\Booking;
use Modules\Geography\Entities\Country;
use Livewire\Component;
use Modules\Localization\Entities\Currency;
use Modules\Geography\Entities\Subregion;
use Modules\Geography\Entities\Nationality;

class QuotationTable extends Component
{
    public $trips = 0;
    public $quotations = [];
    public $fileTypes = [];
    public $clients = [];
    public $tourOperators = [];
    public $travelAgents = [];
    public $nationalities = [];
    public $countries = [];
    public $currencies = [];
    public $subregions = [];

    public function mount()
    {
        // $this->quotations = Booking::all();
        $this->quotations = [];
        $this->fileTypes = [1 => 'Client', 2 => 'Tour Operator', 3 => 'Travel Agent', 4 => 'Website', 5 => 'Offers', 6 => 'Special Request', 7 => 'Other'];
        $this->clients = [1 => 'Client A', 2 => 'Client B', 3 => 'Client C', 4 => 'Client D', 5 => 'Client E'];
        $this->tourOperators = [1 => 'Tour Operator A', 2 => 'Tour Operator B', 3 => 'Tour Operator C'];
        $this->travelAgents = [1 => 'Travel Agent A', 2 => 'Travel Agent B', 3 => 'Travel Agent C'];
        $this->nationalities = Nationality::all();
        $this->countries = Country::all();
        $this->currencies = Currency::all();
        $this->subregions = Subregion::all();
    }

    public function render()
    {
        return view('livewire.quote.quotation-table', [
            'data' => $this->quotations,
            'fileTypes' => $this->fileTypes,
            'clients' => $this->clients,
            'tourOperators' => $this->tourOperators,
            'travelAgents' => $this->travelAgents,
            'nationalities' => $this->nationalities,
            'countries' => $this->countries,
            'currencies' => $this->currencies,
            'subregions' => $this->subregions,
        ]);
    }
}
