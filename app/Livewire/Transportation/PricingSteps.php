<?php

namespace App\Livewire\Transportation;

use App\Models\Season;
use Livewire\Component;
use App\Models\TransportationCompany;
use App\Models\TransportationVehicleType;

class PricingSteps extends Component
{
    public $record;
    public bool $isEdit = false;
    public $filters = ['company' => null, 'vehicle_type' => null, 'season' => null];
    public $options = ['companies' => [], 'vehicle_types' => [], 'seasons' => []];

    protected array $map = [
        'company' => [
            'vehicle_types' => ['model' => TransportationVehicleType::class, 'foreign' => 'company_id'],
            'seasons' => ['model' => Season::class, 'foreign' => 'company_id'],
        ],
    ];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->isEdit = (bool) $record;
        $this->options['companies'] = TransportationCompany::orderBy('name')->get(['id', 'name']);
        if (!$record)
            return;
        $this->filters['company'] = $record->company_id;
        $this->filters['vehicle_type'] = $record->vehicle_type_id;
        $this->filters['season'] = $record->season_id;
        $this->loadNext('company', $record->company_id);
    }

    public function updatedFilters($value, $key)
    {
        if ($this->isEdit)
            return;
        $key = str_replace('filters.', '', $key);
        $this->resetBelow($key);
        if ($value)
            $this->loadNext($key, $value);
    }

    protected function loadNext(string $key, int|array|string $id)
    {
        if (!isset($this->map[$key]))
            return;
        $id = (int) $id;
        $this->dispatch('select-options-updated', true);
        foreach ($this->map[$key] as $target => $config) {
            if ($config['model'] === Season::class) {
                $this->options[$target] = Season::where('model_id', $id)->where('model_type', TransportationCompany::class)->orderBy('name')->get(['id', 'name']);
            } else {
                $this->options[$target] = $config['model']::where($config['foreign'], $id)->orderBy('name')->get(['id', 'name']);
            }
        }
    }

    protected function resetBelow(string $key)
    {
        $order = ['company'];
        $optionKeys = ['company' => 'companies'];
        $index = array_search($key, $order);
        if ($index === false)
            return;
        foreach (array_slice($order, $index + 1) as $lowerKey) {
            $this->filters[$lowerKey] = null;
            $this->options[$optionKeys[$lowerKey]] = [];
        }
    }

    public function render()
    {
        // dd($this->options);
        return view('livewire.transportation.pricing-steps');
    }
}