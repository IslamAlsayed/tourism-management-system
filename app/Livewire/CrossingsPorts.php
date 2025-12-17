<?php

namespace App\Livewire;

use App\Models\CrossingPort;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class CrossingsPorts extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterStatus = '';
    public $filterOperational = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterOperational()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CrossingPort::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'crossing_port');
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
        $paginator = CrossingPort::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        CrossingPort::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('crossing_port.crossings_ports'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], CrossingPort::class, $cols, 'crossings_ports');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], CrossingPort::class, $cols, 'crossings_ports', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterStatus', 'filterOperational']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = CrossingPort::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        if ($this->filterType && $this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }
        if ($this->filterStatus && $this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active' ? true : false);
        }
        if ($this->filterOperational && $this->filterOperational !== 'all') {
            $query->where('is_operational', $this->filterOperational === '1' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.crossings-ports', ['data' => $data, 'totalCount' => $this->totalCount ?: CrossingPort::count(), 'selectedIds' => $this->selectedIds]);
    }
}