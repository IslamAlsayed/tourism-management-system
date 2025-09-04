<?php

namespace App\Livewire\Quote\Step2;

use App\Models\Booking;
use App\Models\OtherService;
use Livewire\Component;

class OtherServices extends Component
{
    public $booking;
    public $otherServices = [];
    public $rows = [];
    public $subtotal_other_services = 0;

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
        $this->otherServices = OtherService::all();

        // initialize rows
        $this->rows = $this->otherServices->mapWithKeys(fn($services) => [
            $services->id => [
                'selected' => false,
                'quantity' => 1,
                'unit_price' => $services->price ?? 0,
                'total_price' => 0,
            ]
        ])->toArray();
    }

    public function updatedRows($value, $key)
    {
        foreach ($this->rows as &$row) {
            $row['total_price'] = $row['selected'] ? $row['quantity'] * $row['unit_price'] : 0;
        }

        $this->recalculateSubtotal();
    }

    private function recalculateSubtotal(): void
    {
        $this->subtotal_other_services = 0;
        foreach ($this->rows as $row) {
            $this->subtotal_other_services += $row['total_price'] ?? 0;
        }

        // $this->emit('subtotalUpdated', [
        //     'otherServices' => $this->subtotal_other_services,
        // ]);
    }

    public function render()
    {
        return view('livewire.quote.step2.otherServices', [
            'otherServices' => $this->otherServices,
            'rows' => $this->rows,
            'subtotal_other_services' => $this->subtotal_other_services,
            'currency_symbol' => '$',
        ]);
    }
}