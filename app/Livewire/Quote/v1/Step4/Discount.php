<?php

namespace App\Livewire\Quote\v1\Step4;

use App\Models\Booking;
use Livewire\Component;

class Discount extends Component
{
    public $discount = 0;
    public $tax = 0;
    public $booking = [];

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
    }

    protected function rules()
    {
        return [
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        $subtotal = $this->booking->subtotal_hotels
            + $this->booking->subtotal_transport
            + $this->booking->subtotal_services;

        $discount = (float) ($this->discount ?? 0);
        $taxPercent = (float) ($this->tax ?? 0) / 100; // قسمنا على 100
        $tax = ($subtotal - $discount) * $taxPercent;

        $grandTotal = $subtotal - $discount + $tax;

        // حدث DB
        $this->booking->update([
            'discount' => round($discount, 2),
            'tax' => round($tax, 2),
            'grand_total' => round($grandTotal, 2),
        ]);

        // حدث قيم الـ Component لتنعكس فوراً على الصفحة
        $this->booking->discount = $discount;
        $this->booking->tax = $tax;
        $this->booking->grand_total = $grandTotal;
    }

    public function render()
    {
        return view('livewire.quote.v1.step4.discount');
    }
}