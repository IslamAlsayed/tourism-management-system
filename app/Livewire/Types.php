<?php

namespace App\Livewire;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Types extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterStatus = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Type::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'type');
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
        $paginator = Type::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Type::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('type.types'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Type::class, $cols, 'types');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Type::class, $cols, 'types', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Type::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.types', ['data' => $data, 'totalCount' => $this->totalCount ?: Type::count(), 'selectedIds' => $this->selectedIds]);
    }
}