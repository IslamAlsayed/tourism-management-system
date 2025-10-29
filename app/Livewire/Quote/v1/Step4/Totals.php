<?php

namespace App\Livewire\Quote\v1\Step4;

use App\Models\Booking;
use Livewire\Component;

class Totals extends Component
{
    public $booking;
    public $discount = 0;
    public $tax = 0; // نسبة مئوية
    public $subtotal = 0;
    public $calculatedTax = 0;
    public $beforeGrandTotal = 0;
    public $grandTotal = 0;

    public function mount($id)
    {
        $this->booking = Booking::findOrFail($id);
        $this->baseSubtotal = $this->booking->subtotal_hotels
            + $this->booking->subtotal_transport
            + $this->booking->subtotal_services;

        // تعيين قيم افتراضية
        $this->discount = (float) $this->booking->discount;
        $this->tax = (float) $this->booking->tax;

        $this->recalculateTotals();
    }

    public function updated($propertyName)
    {
        // إذا اتغير الخصم أو الضريبة
        if (in_array($propertyName, ['discount', 'tax'])) {
            $this->recalculateTotals();
        }
    }

    public function recalculateTotals()
    {
        // 1. خذ subtotal من قيم أصلية لا تتغير
        $subtotal = (float) $this->booking->subtotal_hotels
            + (float) $this->booking->subtotal_transport
            + (float) $this->booking->subtotal_services;

        $this->beforeGrandTotal = $subtotal;

        // 2. خصم ثابت كما أدخله المستخدم
        $discount = (float) ($this->discount ?? 0);

        // 3. tax بالنسبة المئوية كما أدخله المستخدم
        $taxPercent = (float) ($this->tax ?? 0) / 100;

        // 4. حساب الضريبة
        $calculatedTax = round(($subtotal - $discount) * $taxPercent, 2);

        // 5. حساب الـ grand total
        $grandTotal = round($subtotal - $discount + $calculatedTax, 2);

        // 6. تحديث المتغيرات في الـ component
        $this->calculatedTax = $calculatedTax;
        $this->grandTotal = $grandTotal;
    }

    public function render()
    {
        return view('livewire.quote.v1.step4.totals', [
            'discount' => (float) $this->discount,
            'tax' => (float) $this->calculatedTax,
            'beforeGrandTotal' => $this->beforeGrandTotal,
        ]);
    }
}