<?php

namespace App\Livewire;

use App\Models\CrossingPort;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class CrossingsPorts extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterIsActive = '';
    public $filterOperatingDays = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterIsActive()
    {
        $this->resetPage();
    }

    public function updatingFilterOperatingDays()
    {
        $this->resetPage();
    }

    public function mount($filtered = null)
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(CrossingPort::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, CrossingPort::class, 'crossing_port');
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
            'message' => __('messages.type_deleted_count', ['type' => __('main.crossings_ports'), 'count' => $count]),
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
        $this->reset(['search', 'filterType', 'filterIsActive', 'filterOperatingDays']);
        $this->resetSort();
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
        if ($this->filterIsActive && $this->filterIsActive !== 'all') {
            $query->where('is_active', $this->filterIsActive === 'active' ? true : false);
        }
        if ($this->filterOperatingDays && $this->filterOperatingDays !== 'all') {
            $day = is_array($this->filterOperatingDays)
                ? ($this->filterOperatingDays['payload']['value'] ?? $this->filterOperatingDays)
                : $this->filterOperatingDays;

            if ($day && $day !== 'all') {
                $query->where(function ($q) use ($day) {
                    $q->whereJsonContains('operating_days', $day)
                        ->orWhereRaw("JSON_SEARCH(operating_days, 'one', ?) IS NOT NULL", [$day]);
                });
            }
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.crossings-ports', ['data' => $data, 'totalCount' => $this->totalCount ?: CrossingPort::count(), 'selectedIds' => $this->selectedIds]);
    }
}
