<?php

namespace Modules\Geography\Livewire\Regions;

use Livewire\Component;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;

class LocationToState extends Component
{
    public $record;
    public $multiple;
    public $selectedCities = [];
    public $filters = ['country' => null];
    public $options = ['countries' => []];
    protected array $map = [];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
        $this->selectedCities = $record?->cities?->pluck('id')->toArray() ?? [];
        $this->options['countries'] = Country::orderBy('name')->get(['id', 'name']);
        if ($record) {
            foreach (array_keys($this->filters) as $key) {
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
        $order = ['country'];
        $optionKeys = ['country' => 'countries'];
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
        return view('geography::livewire.regions.location-to-state');
    }
}
