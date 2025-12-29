<?php

namespace App\Livewire\Regions;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use Livewire\Component;
use App\Models\Subregion;

class LocationToCountry extends Component
{
    public $record;
    public $multiple;
    public $selectedStates = [];
    public $selectedCities = [];
    public $filters = ['region' => null, 'subregion' => null, 'state' => null, 'city' => null];
    public $options = ['regions' => [], 'subregions' => [], 'states' => [], 'cities' => []];
    protected array $map = [
        'region' => ['model' => Subregion::class, 'foreign' => 'region_id', 'target' => 'subregions'],
        'subregion' => ['model' => State::class, 'foreign' => 'subregion_id', 'target' => 'states'],
        'state' => ['model' => City::class, 'foreign' => 'state_id', 'target' => 'cities'],
    ];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
        $this->selectedStates = $record?->states?->pluck('id')->toArray() ?? [];
        $this->selectedCities = $record?->cities?->pluck('id')->toArray() ?? [];
        $this->options['regions'] = Region::orderBy('name')->get(['id', 'name']);
        if ($record) {
            foreach (array_keys($this->filters) as $key) {
                $this->filters[$key] = $record->{$key . '_id'} ?? null;
                if ($this->filters[$key]) {
                    $this->loadNext($key, $this->filters[$key]);
                }
            }
        }
    }

    public function updatedFilters($value, $key)
    {
        $this->dispatch('select-options-updated', true);
        $key = str_replace('filters.', '', $key);
        $this->resetBelow($key);
        if (blank($value)) {
            return;
        }
        if ($key == 'state') {
            $this->loadNext('state', $value);
            return;
        }

        $this->loadNext($key, $value);
    }

    protected function loadNext(string $key, int|array|string $id)
    {
        if (!isset($this->map[$key])) {
            return;
        }
        $config = $this->map[$key];
        $query = $config['model']::query();
        if ($key === 'state') {
            $query->whereHas('states', function ($q) use ($id) {
                is_array($id) ? $q->whereIn('states.id', $id) : $q->where('states.id', $id);
            });
        } else {
            is_array($id) ? $query->whereIn($config['foreign'], $id) : $query->where($config['foreign'], $id);
        }
        $this->options[$config['target']] = $query->orderBy('name')->get(['id', 'name']);
        $this->dispatch('select-options-updated', true);
    }

    protected function resetBelow(string $key)
    {
        $order = ['region', 'subregion', 'state', 'city'];
        $optionKeys = ['region' => 'regions', 'subregion' => 'subregions', 'state' => 'states', 'city' => 'cities'];
        $index = array_search($key, $order);
        if ($index === false) {
            return;
        }
        foreach (array_slice($order, $index + 1) as $lowerKey) {
            $this->filters[$lowerKey] = null;
            $this->options[$optionKeys[$lowerKey]] = [];
        }
    }

    public function render()
    {
        return view('livewire.regions.location-to-country');
    }
}