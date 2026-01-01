<?php

namespace App\Livewire;

use App\Models\Season;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Arr;

class EntitySeasonsSelects extends Component
{
    use WithPagination;

    public string $type = ''; // accommodation | transportation_company
    public $record;

    public $entities = [];
    public $seasons = [];

    public $filterEntityId = '';
    public bool $isEntitySelected = false;
    public bool $isLoading = false;

    protected $config;

    public function mount(string $type, $record = null)
    {
        $this->type = $type;
        $this->record = $record;

        $this->config = config("seasonable.$type");

        if (!$this->config) {
            abort(500, "Invalid seasonable type: {$type}");
        }

        $model = $this->config['model'];
        $foreignKey = $this->config['foreign_key'];

        $this->entities = $model::orderBy('name')->get(['id', 'name']);

        if ($record && $record->{$foreignKey}) {
            $this->filterEntityId = $record->{$foreignKey};
            $this->loadSeasons($this->filterEntityId);
        }
    }

    public function updatedFilterEntityId($value)
    {
        if (!$value) {
            $this->resetSeasons();
            return;
        }
        $this->dispatch('select-options-updated', true);
        $this->loadSeasons($value);
    }

    protected function loadSeasons($entityId): void
    {
        $this->isLoading = true;
        $this->seasons = [];

        $this->seasons = Season::where($this->config['foreign_key'], $entityId)->orderBy('name')->get(['id', 'name']);

        $this->isEntitySelected = true;
        $this->isLoading = false;
    }

    protected function resetSeasons(): void
    {
        $this->filterEntityId = '';
        $this->seasons = [];
        $this->isEntitySelected = false;
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.entity-seasons-selects', [
            'label' => __($this->config['label']),
        ]);
    }
}