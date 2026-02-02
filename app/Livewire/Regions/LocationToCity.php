<?php

namespace App\Livewire\Regions;

use App\Models\Country;
use App\Models\State;
use App\Models\Region;
use Livewire\Component;
use App\Models\Subregion;

class LocationToCity extends Component
{
    public $record;
    public $multiple;
    public $selectedStates = [];
    public $filters = ['country' => null, 'state' => null];
    public $options = ['countries' => [], 'states' => []];
    protected array $map = [
        'country' => ['model' => State::class, 'foreign' => 'country_id', 'target' => 'states'],
    ];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
        $this->selectedStates = $record?->states?->pluck('id')->toArray() ?? [];
        $this->options['countries'] = Country::orderBy('name')->get(['id', 'name']);
        if ($record) {
            foreach (array_keys($this->filters) as $key) {
                if ($key == 'state') {
                    $this->filters['state'] = $record?->states?->pluck('id')->toArray();
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
        $order = ['country', 'state'];
        $optionKeys = ['country' => 'countries', 'state' => 'states'];
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
        return view('livewire.regions.location-to-city');
    }
}
