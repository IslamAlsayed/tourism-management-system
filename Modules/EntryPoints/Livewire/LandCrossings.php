<?php

namespace Modules\EntryPoints\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\EntryPoints\Entities\LandCrossing;

class LandCrossings extends Component
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
        $this->filterType = $filtered;
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(LandCrossing::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, LandCrossing::class, 'entry_point');
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
        $paginator = LandCrossing::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        LandCrossing::whereIn('id', $this->selectedIds)->delete();
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
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], LandCrossing::class, $cols, 'crossings_ports');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], LandCrossing::class, $cols, 'crossings_ports', $extension);
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
        $query = LandCrossing::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);

        if (request()->filtered && request()->filtered !== 'all') {
            $query->where('type', request()->filtered);
        }
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
        return view('entrypoints::livewire.land-crossings', ['data' => $data, 'totalCount' => $this->totalCount ?: LandCrossing::count(), 'selectedIds' => $this->selectedIds]);
    }
}
