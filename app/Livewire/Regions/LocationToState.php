<?php

namespace App\Livewire\Regions;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Livewire\Component;
use App\Models\Subregion;

class LocationToState extends Component
{
    public $record;
    public $multiple;
    public $selectedCities = [];
    public $filters = ['country' => null, 'city' => null];
    public $options = ['countries' => [], 'cities' => []];
    protected array $map = [
        'country' => ['model' => City::class, 'foreign' => 'country_id', 'target' => 'cities'],
    ];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
        $this->selectedCities = $record?->cities?->pluck('id')->toArray() ?? [];
        $this->options['countries'] = Country::orderBy('name')->get(['id', 'name']);
        if ($record) {
            foreach (array_keys($this->filters) as $key) {
                if ($key == 'city') {
                    $this->filters['city'] = $record?->cities?->pluck('id')->toArray();
                } else {
                    $this->filters[$key] = $record->{$key . '_id'} ?? null;
                }

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
        if ($value) {
            $this->loadNext($key, $value);
        }
    }

    protected function loadNext(string $key, int|array|string $id)
    {
        $this->dispatch('select-options-updated', true);
        if (!isset($this->map[$key]))
            return;
        $id = (int) $id;
        $config = $this->map[$key];

        if (is_array($id)) {
            $this->options[$config['target']] = $config['model']::whereIn($config['foreign'], $id)->orderBy('name')->get(['id', 'name']);
        } else {
            $this->options[$config['target']] = $config['model']::where($config['foreign'], $id)->orderBy('name')->get(['id', 'name']);
        }
    }

    protected function resetBelow(string $key)
    {
        $order = ['country', 'city'];
        $optionKeys = ['country' => 'countries', 'city' => 'cities'];
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
        return view('livewire.regions.location-to-state');
    }
}
