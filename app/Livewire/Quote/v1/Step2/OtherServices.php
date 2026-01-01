<?php

namespace App\Livewire\Quote\v1\Step2;

use App\Models\Booking;
use Livewire\Component;
use App\Models\Currency;
use App\Models\OtherService;
use App\Models\BookingOtherService;

class OtherServices extends Component
{
    public $booking;
    public $otherServices = [];
    public $services = [];
    public $subtotal_services = 0;
    public $groups = 0;
    public $currency_symbol = '';

    public function mount($id)
    {
        $this->booking = Booking::with('otherServices')->findOrFail($id);
        $this->otherServices = OtherService::all();
        $this->currency_symbol = Currency::where('id', $this->booking->currency_id)->value('symbol') ?? '$';
        $this->groups = $this->booking->adults + $this->booking->children + $this->booking->infants ?? 1;

        // Initialize services as a flat array (Livewire-friendly)
        foreach ($this->otherServices as $service) {
            $this->services[$service->id] = [
                'selected' => false,
                'quantity' => 1,
                'price' => $service->price,
                'total_price' => $service->price * 1,
            ];
        }
    }

    protected function rules()
    {
        return [
            'services.*.selected' => 'boolean',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'required|numeric|min:0',
        ];
    }
    protected $messages = [
        'services.*.quantity.min' => 'Quantity must be at least 1.',
        'services.*.price.min' => 'Price must be at least 0.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->recalculateSubtotal();
        $this->syncServicesToDB();

        $this->booking->update([
            'subtotal_services' => $this->subtotal_services,
        ]);
    }

    private function syncServicesToDB()
    {
        foreach ($this->services as $serviceId => $service) {
            if ($service['selected']) {
                BookingOtherService::updateOrCreate(
                    [
                        'booking_id' => $this->booking->id,
                        'other_service_id' => $serviceId,
                    ],
                    [
                        'selected' => $service['selected'],
                        'quantity' => $service['quantity'] ?? 1,
                        'price' => $service['price'],
                    ]
                );
            } else {
                // حذف أي خدمة غير مختارة
                BookingOtherService::where('booking_id', $this->booking->id)
                    ->where('other_service_id', $serviceId)
                    ->delete();
            }
        }
    }

    public function updatedServices($value, $key)
    {
        foreach ($this->services as $id => &$service) {
            $service['selected'] = $service['selected'] ?? false;
            $service['quantity'] = (int) ($service['quantity'] ?? 1);
            $service['total_price'] = $service['selected'] ? $service['quantity'] * $service['price'] : 0;
        }

        $this->recalculateSubtotal();
        $this->syncServicesToDB();
    }

    public function addService($serviceId)
    {
        $service = $this->services[$serviceId] ?? null;
        if (!$service) {
            return;
        }

        $this->syncServicesToDB();
        $this->recalculateSubtotal();

        $this->booking->update([
            'subtotal_services' => $this->subtotal_services,
        ]);
    }

    private function recalculateSubtotal()
    {
        $this->subtotal_services = 0;
        foreach ($this->services as $service) {
            if ($service['selected']) {
                $this->subtotal_services += $service['total_price'] ?? 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.quote.v1.step2.otherServices', [
            'otherServices' => $this->otherServices,
            'services' => $this->services,
            'subtotal_services' => $this->subtotal_services,
            'currency_symbol' => $this->currency_symbol,
            'groups' => $this->groups,
        ]);
    }
}