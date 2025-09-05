<?php

namespace App\Livewire\Quote\Step2;

use Livewire\Component;
use App\Models\Booking;
use App\Models\OtherService;
use App\Models\Currency;

class OtherServices extends Component
{
    public $booking;
    public $otherServices = [];
    public $services = [];
    public $subtotal_services = 0;
    public $currency_symbol = '';

    public function mount($id)
    {
        $this->booking = Booking::with('otherServices')->findOrFail($id);
        $this->otherServices = OtherService::all();
        $this->currency_symbol = Currency::where('id', $this->booking->currency_id)->value('symbol') ?? '$';

        // Initialize services as a flat array (Livewire-friendly)
        foreach ($this->otherServices as $service) {
            $this->services[$service->id] = [
                'selected' => false,
                'quantity' => 0,
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

        $this->booking->update([
            'subtotal_services' => $this->subtotal_services,
        ]);
    }

    public function updatedServices($value, $key)
    {
        foreach ($this->services as $id => &$service) {
            $service['selected'] = $service['selected'] ?? false;
            $service['quantity'] = (int) ($service['quantity'] ?? 1);
            $service['total_price'] = $service['selected'] ? $service['quantity'] * $service['price'] : 0;
        }

        $this->recalculateSubtotal();
    }

    private function recalculateSubtotal(): void
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
        return view('livewire.quote.step2.otherServices', [
            'otherServices' => $this->otherServices,
            'services' => $this->services,
            'subtotal_services' => $this->subtotal_services,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }
}