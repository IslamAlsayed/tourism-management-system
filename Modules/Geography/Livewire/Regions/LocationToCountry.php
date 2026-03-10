<?php

namespace Modules\Geography\Livewire\Regions;

use Livewire\Component;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Subregion;

class LocationToCountry extends Component
{
    public $record;
    public $multiple;
    public $selectedStates = [];
    public $selectedCities = [];
    public $filters = ['region' => null, 'subregion' => null];
    public $options = ['regions' => [], 'subregions' => []];
    protected array $map = [
        'region' => ['model' => Subregion::class, 'foreign' => 'region_id', 'target' => 'subregions'],
        'subregion' => ['model' => State::class, 'foreign' => 'subregion_id', 'target' => 'states'],
    ];

    public function mount($record = null, $multiple = null)
    {
        $this->record = $record;
        $this->multiple = $multiple;
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

        $this->loadNext($key, $value);
    }

    protected function loadNext(string $key, int|array|string $id)
    {
        if (!isset($this->map[$key])) {
            return;
        }
        $config = $this->map[$key];
        $query = $config['model']::query();
        $this->options[$config['target']] = $query->orderBy('name')->get(['id', 'name']);
        $this->dispatch('select-options-updated', true);
    }

    protected function resetBelow(string $key)
    {
        $order = ['region', 'subregion'];
        $optionKeys = ['region' => 'regions', 'subregion' => 'subregions'];
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
        return view('geography::livewire.regions.location-to-country');
    }
}
