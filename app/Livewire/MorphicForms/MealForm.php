<?php

namespace App\Livewire\MorphicForms;

use Modules\Localization\Entities\Currency;
use Livewire\Component;

class MealForm extends Component
{
    public $meals = [];
    public $showForm = false;
    public $currencies = [];
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->currencies = Currency::pluck('code', 'id')->toArray();

        if ($record) {
            if (method_exists($record, 'meals') && $record->meals()->exists()) {
                $existingMeals = $record->meals()
                    ->get()
                    ->unique('id')
                    ->map(function ($meal) {
                        return [
                            'id' => uniqid(),
                            'meal_id' => $meal->id,
                            'name' => $meal->name,
                            'name_ar' => $meal->name_ar,
                            'currency_id' => $meal->currency_id,
                            'price' => $meal->price,
                            'is_included' => $meal->is_included ?? 1,
                            'is_supplement' => $meal->is_supplement ?? 1,
                            'is_active' => $meal->is_active ?? 1,
                            'description' => $meal->description,
                        ];
                    })->toArray();
            }
            if (!empty($existingMeals ?? [])) {
                $this->meals = $existingMeals;
            }
        }
    }

    public function addMeal()
    {
        $this->meals[] = [
            'id' => uniqid(),
            'name' => '',
            'name_ar' => '',
            'currency_id' => '',
            'price' => '',
            'is_included' => 1,
            'is_supplement' => 1,
            'is_active' => 1,
            'description' => '',
        ];
        $this->dispatch('record-added');
    }

    public function removeMeal($index)
    {
        if (count($this->meals) > 1) {
            unset($this->meals[$index]);
            $this->meals = array_values($this->meals);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.morphic-forms.meal-form');
    }
}
