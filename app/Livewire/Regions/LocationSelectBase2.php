<?php

namespace App\Livewire\Regions;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use Livewire\Component;
use App\Models\Subregion;

class LocationSelectBase2 extends Component
{
    public $record;
    public $multiple;
    public $all_states = false;
    public $all_cities = false;
    public $selectedStates = [];
    public $selectedCities = [];
    public $filters = ['country' => null, 'state' => null, 'city' => null];
    public $options = ['countries' => [], 'states' => [], 'cities' => []];

    protected array $map = [
        'country' => ['model' => State::class, 'foreign' => 'country_id', 'target' => 'states'],
        'state' => ['model' => City::class, 'foreign' => 'state_id', 'target' => 'cities'],
        'city' => ['model' => City::class, 'foreign' => 'id', 'target' => 'cities'],
    ];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
        if ($multiple) {
            $this->selectedStates = $record?->states?->pluck('id')->toArray() ?? [];
            $this->selectedCities = $record?->cities?->pluck('id')->toArray() ?? [];
        }
        $this->options['countries'] = Country::orderBy('name')->get(['id', 'name']);

        if ($record) {
            $this->filters['country'] = $record->country_id ?? null;
            if ($this->filters['country']) {
                $this->loadNext('country', $this->filters['country']);
            }
            // states selection
            if ($this->multiple) {
                $stateIds = $record->states?->pluck('id')->toArray() ?? [];
                $this->filters['state'] = $stateIds;
                if (!empty($stateIds)) {
                    $this->loadNext('state', $stateIds);
                }
            } else {
                $this->filters['state'] = $record->state_id ?? null;
                if ($this->filters['state']) {
                    $this->loadNext('state', $this->filters['state']);
                }
            }
            // cities selection
            if ($this->multiple) {
                $cityIds = $record->cities?->pluck('id')->toArray() ?? [];
                $this->filters['city'] = $cityIds;
                if (!empty($cityIds)) {
                    $this->loadNext('city', $cityIds);
                }
            } else {
                $this->filters['city'] = $record->city_id ?? null;
                if ($this->filters['city']) {
                    $this->loadNext('city', $this->filters['city']);
                }
            }
        }
    }

    public function updatedAllStates($value)
    {
        if ($value) {
            $this->selectedStates = [];
            $this->filters['state'] = null;
            $this->options['cities'] = [];
            if (!empty($this->filters['country'])) {
                $this->options['cities'] = City::whereIn('state_id', State::where('country_id', $this->filters['country'])->pluck('id'))->orderBy('name')->get(['id', 'name']);
            }
            $this->dispatch('select-options-updated', true);
        } else {
            $this->options['cities'] = [];
            $this->selectedCities = [];
        }
    }

    public function updatedFilters($value, $key)
    {
        $key = str_replace('filters.', '', $key);
        $this->resetBelow($key);

        if ($value) {
            $this->loadNext($key, $value);
        }
    }

    protected function loadNext(string $key, int|array|string $id)
    {
        $this->dispatch('select-options-updated', true);
        if (!isset($this->map[$key]))
            return;
        if (!is_array($id)) {
            $id = (int) $id;
        }
        $config = $this->map[$key];
        if (is_array($id)) {
            $this->options[$config['target']] = $config['model']::whereIn($config['foreign'], $id)->orderBy('name')->get(['id', 'name']);
        } else {
            $this->options[$config['target']] = $config['model']::where($config['foreign'], $id)->orderBy('name')->get(['id', 'name']);
        }
    }

    protected function resetBelow(string $key)
    {
        $order = ['country', 'state', 'city'];
        $optionKeys = ['country' => 'countries', 'state' => 'states', 'city' => 'cities'];
        $index = array_search($key, $order);
        if ($index === false) {
            return;
        }
        foreach (array_slice($order, $index + 1) as $lowerKey) {
            $this->filters[$lowerKey] = null;
            $this->options[$optionKeys[$lowerKey]] = [];
        }

        // Reset all_states when country changes
        if ($key === 'country') {
            $this->all_states = false;
        }
    }

    public function render()
    {
        return view('livewire.regions.location-select-base2');
    }
}
