<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;

class PolymorphicModelSelect extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public string $filterType = '';
    public array $models = [];
    public ?object $record = null;
    public bool $isLoading = false;

    protected $listeners = ['recordUpdated' => '$refresh'];

    protected function config(): array
    {
        return config('polymorphic-selects');
    }

    public function mount($record = null)
    {
        $this->record = $record;

        $types = $this->config();

        $this->filterType = request()->type && isset($types[request()->type])
            ? request()->type
            : array_key_first($types);

        if ($record && $record->model_type) {
            $this->filterType = $this->resolveTypeFromModel($record->model_type);
        }

        $this->loadModels();
    }

    public function updatedFilterType()
    {
        $this->dispatch('select-options-updated', true);
        $this->loadModels();
    }

    protected function loadModels(): void
    {
        $this->isLoading = true;
        $types = $this->config();
        if (!isset($types[$this->filterType])) {
            $this->models = [];
            $this->isLoading = false;
            return;
        }
        $modelClass = $types[$this->filterType]['model'];
        $this->models = $modelClass::orderBy('name')->get(['id', 'name'])->toArray();
        $this->isLoading = false;
    }

    protected function resolveTypeFromModel(string $modelClass): string
    {
        foreach ($this->config() as $key => $item) {
            if ($item['model'] === $modelClass) {
                return $key;
            }
        }

        return array_key_first($this->config());
    }

    public function render()
    {
        return view('livewire.polymorphic-model-select', [
            'types' => $this->config(),
        ]);
    }
}