<?php

namespace App\Livewire\MorphicForms;

use App\Models\Currency;
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

        // If editing and has existing meals, load them
        if ($record && $record->meals()->exists()) {
            $existingMeals = $record->meals()
                ->get()
                ->groupBy('meal_id')
                ->map(function ($rates) {
                    $firstRate = $rates->first();
                    $meal = $firstRate ? $firstRate->meal : null;
                    if (!$firstRate || !$meal) {
                        return null;
                    }
                    return [
                        'id' => uniqid(),
                        'meal_id' => $meal->id,
                        'name' => $meal->name,
                        'name_ar' => $meal->name_ar,
                        'currency_id' => $firstRate->currency_id,
                        'price' => $firstRate->price,
                        'is_included' => $firstRate->is_included ?? 1,
                        'is_supplement' => $firstRate->is_supplement ?? 1,
                        'is_active' => $meal->is_active ?? 1,
                        'description' => $meal->description,
                    ];
                })->filter()->values()->toArray();

            if (!empty($existingMeals)) {
                $this->meals = $existingMeals;
            }
        }

        // Initialize with one empty room if none exist
        // if (empty($this->meals)) {
        // $this->meals[] = [
        //     'id' => uniqid(),
        //     'name' => '',
        //     'name_ar' => '',
        //     'currency_id' => '',
        //     'price' => '',
        //     'is_included' => 1,
        //     'is_supplement' => 1,
        //     'is_active' => 1,
        //     'description' => '',
        // ];
        // }
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