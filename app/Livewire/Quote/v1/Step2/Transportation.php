<?php

namespace App\Livewire\Quote\v1\Step2;

use App\Models\Booking;
use App\Models\BookingTransportationCompany;
use Livewire\Component;
use Modules\Localization\Entities\Currency;
use App\Models\TransportationRate;
use App\Models\TransportationCompany;

class Transportation extends Component
{
    public $booking;
    public $transportCompanies = [];
    public $buses = [];
    public $currency_symbol = '';
    public $subtotal_transport = 0;

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
        $this->currency_symbol = Currency::where('id', $this->booking->currency_id)->value('symbol') ?? '$';

        $this->transportCompanies = TransportationCompany::with(['busTypes.rates'])->get();

        // تهيئة الـ buses
        foreach ($this->transportCompanies as $company) {

            // جلب أي باص محجوز مسبقًا لهذا booking + company
            $bookingBus = $this->booking->transportation
                ->firstWhere('company_id', $company->id);

            $firstBusType = $company->busTypes->first();

            $this->buses[$company->id] = [
                'selected' => $bookingBus ? true : false,
                'bus_type_id' => $bookingBus->bus_type_id ?? $firstBusType->id ?? null,
                'rate_id' => $bookingBus->rate_id ?? null, // إذا عندك rate
                'days' => $bookingBus->day ?? 1,
                'price' => $bookingBus->price_per_day ?? $firstBusType->rates->first()->price_per_day ?? 0,
                'total_price' => ($bookingBus->day ?? 1) * ($bookingBus->price_per_day ?? $firstBusType->rates->first()->price_per_day ?? 0),
            ];
        }

        $this->recalculateSubtotal();
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
        $this->syncServicesToDB();

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
        }

        $this->recalculateSubtotal();
        $this->syncServicesToDB();
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
            if ($bus['selected']) {
                $this->subtotal_transport += $bus['total_price'] ?? 0;
            }
        }

        // $this->emit('subtotalUpdated', [
        //     'transportation' => $this->subtotal_transport,
        // ]);
    }

    private function syncServicesToDB()
    {
        foreach ($this->buses as $serviceId => $bus) {
            if ($bus['selected'] && $bus['bus_type_id']) {
                BookingTransportationCompany::updateOrCreate(
                    [
                        'booking_id' => $this->booking->id,
                        'company_id' => $serviceId,
                    ],
                    [
                        'day' => $bus['days'],
                        'bus_type_id' => $bus['bus_type_id'],
                        'price_per_day' => $bus['price'],
                    ]
                );
            } else {
                BookingTransportationCompany::where('booking_id', $this->booking->id)
                    ->where('company_id', $serviceId)
                    ->delete();
            }
        }
    }

    public function addTransportation($companyId)
    {
        $bus = $this->buses[$companyId] ?? null;
        if (!$bus) {
            return;
        }

        $this->recalculateSubtotal();
        $this->syncServicesToDB();

        $this->booking->update([
            'subtotal_transport' => $this->subtotal_transport,
        ]);
    }

    public function render()
    {
        return view('livewire.quote.v1.step2.transportation', [
            'transportCompanies' => $this->transportCompanies,
            'subtotal_transport' => $this->subtotal_transport,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }
}
