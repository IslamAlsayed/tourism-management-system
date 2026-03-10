<?php

namespace App\Livewire\MorphicForms;

use Modules\Localization\Entities\Currency;
use Livewire\Component;

class MealForm extends Component
{
    public $meals = [];
    public $showForm = false;
    public $currencies = [];
    public $seasons = [];
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->currencies = Currency::pluck('code', 'id')->toArray();

        if ($record) {
            if (method_exists($record, 'seasons')) {
                $this->seasons = $record->seasons()->get()->pluck('name', 'id')->toArray();
            }

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
                            'type' => $meal->type,
                            'currency_id' => $meal->currency_id,
                            'season_id' => $meal->season_id,
                            'fit_price_adult' => $meal->fit_price_adult,
                            'fit_price_child_6_11' => $meal->fit_price_child_6_11,
                            'fit_price_child_under_6' => $meal->fit_price_child_under_6,
                            'group_price_adult' => $meal->group_price_adult,
                            'group_price_child_6_11' => $meal->group_price_child_6_11,
                            'group_price_child_under_6' => $meal->group_price_child_under_6,
                            'min_group_size' => $meal->min_group_size ?? 1,
                            'is_included' => $meal->is_included ?? 1,
                            'is_supplement' => $meal->is_supplement ?? 1,
                            'is_active' => $meal->is_active ?? 1,
                            'description' => $meal->description,
                            'notes' => $meal->notes,
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
            'type' => '',
            'currency_id' => '',
            'season_id' => '',
            'fit_price_adult' => '',
            'fit_price_child_6_11' => '',
            'fit_price_child_under_6' => '',
            'group_price_adult' => '',
            'group_price_child_6_11' => '',
            'group_price_child_under_6' => '',
            'min_group_size' => 1,
            'is_included' => 1,
            'is_supplement' => 1,
            'is_active' => 1,
            'description' => '',
            'notes' => '',
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
