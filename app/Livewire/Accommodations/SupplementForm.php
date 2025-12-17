<?php

namespace App\Livewire\Accommodations;

use App\Models\Currency;
use Livewire\Component;

class SupplementForm extends Component
{
    public $supplements = [];
    public $showForm = false;
    public $currencies = [];
    public $accommodation = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($accommodation = null)
    {
        $this->accommodation = $accommodation;
        $this->currencies = Currency::pluck('code', 'id')->toArray();
        
        // If editing and has existing supplements, load them
        if ($accommodation && $accommodation->supplements()->exists()) {
            $existingSupplements = $accommodation->supplements()
                ->get()
                ->map(function($supplement) {
                    return [
                        'id' => uniqid(),
                        'supplement_id' => $supplement->id,
                        'name' => $supplement->name,
                        'name_ar' => $supplement->name_ar,
                        'description' => $supplement->description,
                        'currency_id' => $supplement->currency_id,
                        'price' => $supplement->price,
                        'price_type' => $supplement->price_type ?? 'per_person',
                        'is_mandatory' => $supplement->is_mandatory ?? 0,
                        'is_active' => $supplement->is_active ?? 1,
                        'notes' => $supplement->notes,
                    ];
                })->toArray();
            
            if (!empty($existingSupplements)) {
                $this->supplements = $existingSupplements;
            }
        }
        
        // Initialize with one empty supplement if none exist
        if (empty($this->supplements)) {
            $this->supplements[] = [
                'id' => uniqid(),
                'name' => '',
                'name_ar' => '',
                'currency_id' => '',
                'price' => '',
                'price_type' => 'per_person',
                'is_mandatory' => 0,
                'is_active' => 1,
                'notes' => '',
            ];
        }
    }

    public function addSupplement()
    {
        $this->supplements[] = [
            'id' => uniqid(),
            'name' => '',
            'name_ar' => '',
            'currency_id' => '',
            'price' => '',
            'price_type' => 'per_person',
            'is_mandatory' => 0,
            'is_active' => 1,
            'notes' => '',
        ];
    }

    public function removeSupplement($index)
    {
        if (count($this->supplements) > 1) {
            unset($this->supplements[$index]);
            $this->supplements = array_values($this->supplements);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.accommodations.supplement-form');
    }
}
