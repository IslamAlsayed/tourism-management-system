<?php

namespace App\Livewire\MorphicForms;

use App\Models\Currency;
use App\Models\TransportationVehicleType;
use Livewire\Component;

class PricingForm extends Component
{
    public $pricings = [];
    public $showForm = false;
    public $currencies = [];
    public $vehicleTypes = [];
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->currencies = Currency::pluck('code', 'id')->toArray();
        $this->vehicleTypes = TransportationVehicleType::pluck('name', 'id')->toArray();

        if ($record) {
            if (method_exists($record, 'pricings') && $record->pricings()->exists()) {
                $existingPricings = $record->pricings()
                    ->get()
                    ->unique('id')
                    ->map(function ($pricing) {
                        return [
                            'id' => uniqid(),
                            'price' => $pricing->price,
                            'is_active' => $pricing->is_active ?? 1,
                            'description' => $pricing->description ?? '',
                            'notes' => $pricing->notes ?? '',
                            'company_id' => $pricing->company_id ?? '',
                            'vehicle_type_id' => $pricing->vehicle_type_id ?? '',
                            'season_id' => $pricing->season_id ?? '',
                            'pricing_unit_id' => $pricing->pricing_unit_id ?? '',
                            'currency_id' => $pricing->currency_id ?? '',
                        ];
                    })->toArray();
            }
            if (!empty($existingPricings ?? [])) {
                $this->pricings = $existingPricings;
            }
        }
    }

    public function addPricing()
    {
        $this->pricings[] = [
            'id' => uniqid(),
            'price' => '',
            'is_active' => 1,
            'description' => '',
            'notes' => '',
            'company_id' => '',
            'vehicle_type_id' => '',
            'season_id' => '',
            'pricing_unit_id' => '',
            'currency_id' => '',
        ];
        $this->dispatch('record-added');
    }

    public function removePricing($index)
    {
        if (count($this->pricings) > 1) {
            unset($this->pricings[$index]);
            $this->pricings = array_values($this->pricings);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.morphic-forms.pricing-form');
    }
}