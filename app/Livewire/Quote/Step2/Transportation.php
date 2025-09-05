<?php

namespace App\Livewire\Quote\Step2;

use App\Models\Booking;
use App\Models\BookingTransportationCompany;
use Livewire\Component;
use App\Models\Currency;
use App\Models\TransportationRate;
use App\Models\TransportationCompany;

class Transportation extends Component
{
    public $booking;
    public $transportCompanies = [];
    public $buses = []; // كل صف شركة + باص + مسار + days + price + total_price
    public $currency_symbol = '';
    public $subtotal_transport = 0;

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
        $this->currency_symbol = Currency::where('id', $this->booking->currency_id)->value('symbol') ?? '$';

        $this->transportCompanies = TransportationCompany::with(['busTypes.rates.route'])->get();
        $rates = TransportationCompany::with('busTypes.rates')->get();

        // initialize buses
        $this->buses = [];
        foreach ($rates as $company) {
            $this->buses[$company->id] = [
                'selected' => false,
                'bus_type_id' => null,
                'rate_id' => null,
                'days' => 1,
                'price' => 0,
                'total_price' => 0,
            ];
        }
    }

    protected function rules()
    {
        return [
            'buses.*.selected' => 'boolean',
            'buses.*.bus_type_id' => 'nullable|exists:bus_types,id',
            'buses.*.days' => 'required|integer|min:1',
        ];
    }

    protected $messages = [
        'buses.*.bus_type_id.exists' => 'Selected bus type is invalid.',
        'buses.*.days.min' => 'Days must be at least 1.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->recalculateSubtotal();

        foreach ($this->buses as $companyId => $bus) {
            if ($bus['selected'] && $bus['bus_type_id']) {
                BookingTransportationCompany::updateOrCreate(
                    [
                        'booking_id' => $this->booking->id,
                        'company_id' => $companyId,
                    ],
                    [
                        'day' => $bus['days'],
                        'bus_type_id' => $bus['bus_type_id'],
                        'price_per_day' => $bus['price'],
                    ]
                );
            } else {
                BookingTransportationCompany::where('booking_id', $this->booking->id)
                    ->where('company_id', $companyId)
                    ->delete();
            }
        }

        $this->booking->update([
            'subtotal_transport' => $this->subtotal_transport,
        ]);
    }

    public function updatedBuses($value, $key)
    {
        foreach ($this->buses as $companyId => &$bus) {
            if (!$bus['selected'] || !$bus['bus_type_id']) {
                $bus['price'] = 0;
                $bus['total_price'] = 0;
                $bus['rate_id'] = null;
                continue;
            }

            $rate = $this->getRate($companyId, $bus['bus_type_id']);

            if ($rate) {
                $bus['rate_id'] = $rate->id;
                $bus['price'] = $rate->price_per_day;
                $bus['total_price'] = $rate->price_per_day * max(1, $bus['days'] ?? 1);
            } else {
                $bus['price'] = 0;
                $bus['total_price'] = 0;
                $bus['rate_id'] = null;
            }

            BookingTransportationCompany::updateOrCreate(
                ['booking_id' => $this->booking->id, 'company_id' => $companyId],
                ['bus_type_id' => $bus['bus_type_id'], 'day' => $bus['days'], 'price_per_day' => $bus['price']]
            );
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
        $this->subtotal_transport = 0;
        foreach ($this->buses as $bus) {
            $this->subtotal_transport += $bus['total_price'] ?? 0;
        }

        // $this->emit('subtotalUpdated', [
        //     'transportation' => $this->subtotal_transport,
        // ]);
    }

    public function render()
    {
        return view('livewire.quote.step2.transportation', [
            'transportCompanies' => $this->transportCompanies,
            'subtotal_transport' => $this->subtotal_transport,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }
}