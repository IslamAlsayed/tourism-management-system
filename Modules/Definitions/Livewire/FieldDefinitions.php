<?php

namespace Modules\Definitions\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Definitions\Entities\FieldDefinition;

class FieldDefinitions extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterModule = '';
    public $filterFieldType = '';
    public $filterStatus = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterModule($value)
    {
        $this->filterModule = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterFieldType($value)
    {
        $this->filterFieldType = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterStatus($value)
    {
        $this->filterStatus = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(FieldDefinition::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, FieldDefinition::class, 'field_definition');
    }

    public function updatedSelectPage($value)
    {
        $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
    }

    protected function currentPageDataIds()
    {
        $paginator = FieldDefinition::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        FieldDefinition::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(FieldDefinition::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.field-definitions'), 'count' => $count]),
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterModule', 'filterFieldType', 'filterStatus']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = FieldDefinition::query();

        if ($this->filterModule && $this->filterModule !== 'all') {
            $query->where('module_name', $this->filterModule);
        }
        if ($this->filterFieldType && $this->filterFieldType !== 'all') {
            $query->where('field_type', $this->filterFieldType);
        }
        if ($this->filterStatus && $this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active' ? true : false);
        }

        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        $totalCount = FieldDefinition::count();

        return view('definitions::livewire.field-definitions', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: $totalCount,
            'selectedIds' => $this->selectedIds,
        ]);
    }
}

