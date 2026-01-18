<?php

namespace App\Livewire\MorphicForms;

use App\Models\TransportationCompany;
use Livewire\Component;

class VehicleTypeForm extends Component
{
    public $vehicleTypes = [];
    public $showForm = false;
    public $companies = [];
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->companies = TransportationCompany::get(['id', 'name', 'code'])->toArray();

        if ($record) {
            if (method_exists($record, 'vehicleTypes') && $record->vehicleTypes()->exists()) {
                $existingVehicleTypes = $record->vehicleTypes()
                    ->get()
                    ->unique('id')
                    ->map(function ($vehicleType) {
                        return [
                            'id' => uniqid(),
                            'vehicle_type_id' => $vehicleType->id,
                            'company_id' => $vehicleType->company_id,
                            'name' => $vehicleType->name,
                            'name_ar' => $vehicleType->name_ar,
                            'min_capacity' => $vehicleType->min_capacity,
                            'max_capacity' => $vehicleType->max_capacity,
                            'is_active' => $vehicleType->is_active,
                            'has_luggage' => $vehicleType->has_luggage,
                            'is_air_conditioning' => $vehicleType->is_air_conditioning,
                            'description' => $vehicleType->description,
                            'notes' => $vehicleType->notes ?? '',
                        ];
                    })->toArray();

                if (!empty($existingVehicleTypes)) {
                    $this->vehicleTypes = $existingVehicleTypes;
                }
            }
        }
    }

    public function addVehicleType()
    {
        $this->vehicleTypes[] = [
            'id' => uniqid(),
            'vehicle_type_id' => '',
            'company_id' => '',
            'name' => '',
            'name_ar' => '',
            'min_capacity' => '',
            'max_capacity' => '',
            'is_active' => 1,
            'has_luggage' => 1,
            'is_air_conditioning' => 1,
            'description' => '',
            'notes' => '',
        ];
        $this->dispatch('record-added');
    }

    public function removeVehicleType($index)
    {
        if (count($this->vehicleTypes) > 1) {
            unset($this->vehicleTypes[$index]);
            $this->vehicleTypes = array_values($this->vehicleTypes);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.morphic-forms.vehicle-type-form');
    }
}