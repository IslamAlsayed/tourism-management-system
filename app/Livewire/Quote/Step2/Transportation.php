<?php

namespace App\Livewire\Quote\Step2;

use Livewire\Component;
use App\Models\Booking;
use App\Models\TransportationCompany;
use App\Models\TransportationRate;

class Transportation extends Component
{
    public $booking;

    public $transportCompanies = [];
    public $rows = []; // كل صف شركة + باص + مسار + days + price + total_price
    public $currency_symbol = '$';
    public $subtotal_transportation = 0;

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);

        $this->transportCompanies = TransportationCompany::with(['busTypes.rates.route'])->get();
        $rates = TransportationCompany::with('busTypes.rates')->get();

        // initialize rows
        $this->rows = [];
        foreach ($rates as $company) {
            $this->rows[$company->id] = [
                'selected' => false,
                'bus_type_id' => null,
                'rate_id' => null,
                'days' => 1,
                'price' => 0,
                'total_price' => 0,
            ];
        }
    }

    public function updatedRows($value, $key)
    {
        foreach ($this->rows as $companyId => &$row) {
            if (!$row['selected'] || !$row['bus_type_id']) {
                $row['price'] = 0;
                $row['total_price'] = 0;
                $row['rate_id'] = null;
                continue;
            }

            $rate = $this->getRate($companyId, $row['bus_type_id']);

            if ($rate) {
                $row['rate_id'] = $rate->id;
                $row['price'] = $rate->price_per_day;
                $row['total_price'] = $rate->price_per_day * max(1, $row['days'] ?? 1);
            } else {
                $row['price'] = 0;
                $row['total_price'] = 0;
                $row['rate_id'] = null;
            }
        }

        $this->recalculateSubtotal();

    }

    private function getRate($companyId, $busTypeId)
    {
        if (!$companyId || !$busTypeId)
            return null;

        return TransportationRate::where('company_id', $companyId)
            ->where('bus_type_id', $busTypeId)
            ->first();
    }

    private function recalculateSubtotal()
    {
        $this->subtotal_transportation = 0;
        foreach ($this->rows as $row) {
            $this->subtotal_transportation += $row['total_price'] ?? 0;
        }

        // $this->emit('subtotalUpdated', [
        //     'transportation' => $this->subtotal_transportation,
        // ]);
    }

    public function render()
    {
        return view('livewire.quote.step2.transportation', [
            'transportCompanies' => $this->transportCompanies,
            'subtotal_transportation' => $this->subtotal_transportation,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }
}