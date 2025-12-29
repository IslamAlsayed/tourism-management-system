<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use Livewire\Component;
use App\Models\subregion;

class RegionsSelects extends Component
{
    public $record;

    public $filters = [
        'region' => null,
        'subregion' => null,
        'country' => null,
        'state' => null,
        'city' => null,
    ];

    public $options = [
        'regions' => [],
        'subregions' => [],
        'countries' => [],
        'states' => [],
        'cities' => [],
    ];

    protected array $map = [
        'region' => ['model' => Subregion::class, 'foreign' => 'region_id', 'target' => 'subregions'],
        'subregion' => ['model' => Country::class, 'foreign' => 'subregion_id', 'target' => 'countries'],
        'country' => ['model' => State::class, 'foreign' => 'country_id', 'target' => 'states'],
        'state' => ['model' => City::class, 'foreign' => 'state_id', 'target' => 'cities'],
    ];

    protected array $fallbacks = [
        'subregion' => [
            ['model' => Country::class, 'foreign' => 'subregion_id', 'target' => 'countries'],
            ['model' => State::class, 'foreign' => 'subregion_id', 'target' => 'states'],
            ['model' => City::class, 'foreign' => 'subregion_id', 'target' => 'cities'],
        ],
        'country' => [
            ['model' => State::class, 'foreign' => 'country_id', 'target' => 'states'],
            ['model' => City::class, 'foreign' => 'country_id', 'target' => 'cities'],
        ],
        'state' => [
            ['model' => City::class, 'foreign' => 'state_id', 'target' => 'cities'],
        ],
    ];

    public function mount($record = null)
    {
        $this->record = $record;
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
        $key = str_replace('filters.', '', $key);
        $this->resetBelow($key);

        if ($value) {
            $this->loadNext($key, $value);
        }
    }

    protected function loadNext(string $key, int $id)
    {
        // 1️⃣ جرّب الـ map الأول
        if (isset($this->map[$key])) {
            $config = $this->map[$key];

            $result = $config['model']
                ::where($config['foreign'], $id)
                ->orderBy('name')
                ->get(['id', 'name']);

            if ($result->isNotEmpty()) {
                $this->options[$config['target']] = $result;
                $this->resetBelowTarget($config['target']);
                $this->dispatch('select-options-updated', target: $config['target']);
                return;
            }
        }

        // 2️⃣ لو مفيش نتيجة، استخدم fallback
        if (!isset($this->fallbacks[$key])) {
            return;
        }

        foreach ($this->fallbacks[$key] as $rule) {
            $result = $rule['model']
                ::where($rule['foreign'], $id)
                ->orderBy('name')
                ->get(['id', 'name']);

            if ($result->isNotEmpty()) {
                $this->options[$rule['target']] = $result;
                $this->resetBelowTarget($rule['target']);
                $this->dispatch('select-options-updated', target: $rule['target']);
                return;
            }
        }
    }

    protected function resetBelowTarget(string $target)
    {
        $order = ['subregions', 'countries', 'states', 'cities'];
        $index = array_search($target, $order);

        foreach (array_slice($order, $index + 1) as $lower) {
            $this->options[$lower] = [];
            $this->filters[rtrim($lower, 's')] = null;
        }
    }

    public function render()
    {
        return view('livewire.regions-selects');
    }
}