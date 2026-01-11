<?php

namespace App\Livewire\Transportations;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Models\TransportationRouteAssignment;

class RouteAssignments extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterDay = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterDay()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TransportationRouteAssignment::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, TransportationRouteAssignment::class, 'transportations-route-assignment');
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
        $paginator = TransportationRouteAssignment::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TransportationRouteAssignment::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.transportations-route-assignments'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], TransportationRouteAssignment::class, $cols, 'transportations-route-assignments');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], TransportationRouteAssignment::class, $cols, 'transportations-route-assignments', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterDay']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }


    public function render()
    {
        $query = TransportationRouteAssignment::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterDay && $this->filterDay['payload']['value'] !== 'all') {
            $query->where('available_days', 'like', '%' . $this->filterDay['payload']['value'] . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.transportations.route-assignments', ['data' => $data, 'totalCount' => $this->totalCount ?: TransportationRouteAssignment::count(), 'selectedIds' => $this->selectedIds]);
    }
}