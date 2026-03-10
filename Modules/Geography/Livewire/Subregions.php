<?php

namespace Modules\Geography\Livewire;

use Livewire\Component;
use Modules\Geography\Entities\Subregion;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Subregions extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $message = [];
    public $filterActive = '';
    public $filterRegionId = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function updatingFilterRegionId()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Subregion::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Subregion::class, 'subregion');
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
        return $this->buildQuery()->paginate(getPaginate())->getCollection()->pluck('id');
    }

    protected function buildQuery()
    {
        $query = Subregion::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->where('region_id', $this->filterRegionId);
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations
        );

        $query->withCount([
            'countries',
            'accommodations',
            'restaurants',
            'transportationCompanies'
        ]);

        $this->applySorting($query);

        return $query;
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        Subregion::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        Subregion::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Subregion::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Subregion::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Subregion::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(Subregion::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function clearSelected()
    {
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterRegionId']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Subregion::class, $cols, 'subregions');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Subregion::class, $cols, 'subregions', $extension);
    }

    public function render()
    {
        $data = $this->buildQuery()->paginate(getPaginate());

        $regions = \Modules\Geography\Entities\Region::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('geography::livewire.subregions', [
            'data'        => $data,
            'selectedIds' => $this->selectedIds,
            'regions'     => $regions,
        ]);
    }
}
