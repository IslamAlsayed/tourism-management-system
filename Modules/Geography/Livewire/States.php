<?php

namespace Modules\Geography\Livewire;

use Modules\Geography\Entities\State;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;
use App\Traits\CustomPagination;

class States extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $filterActive = '';
    public $filterCountryId = '';
    public $filterRegionId = '';
    public $filterSubregionId = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function updatingFilterCountryId()
    {
        $this->resetPage();
    }

    public function updatingFilterRegionId()
    {
        $this->resetPage();
    }

    public function updatingFilterSubregionId()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(State::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, State::class, 'state');
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
        $query = State::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterCountryId && $this->filterCountryId !== 'all') {
            $query->where('country_id', $this->filterCountryId);
        }

        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->whereHas('country', function ($q) {
                $q->where('region_id', $this->filterRegionId);
            });
        }

        if ($this->filterSubregionId && $this->filterSubregionId !== 'all') {
            $query->whereHas('country', function ($q) {
                $q->where('subregion_id', $this->filterSubregionId);
            });
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations
        );

        $query->withCount([
            'cities',
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
        State::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        State::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) return;
        State::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(State::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        State::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(State::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function clearSelected()
    {
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], State::class, $cols, 'states');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], State::class, $cols, 'states', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterCountryId', 'filterRegionId', 'filterSubregionId']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $data = $this->buildQuery()->paginate(getPaginate());

        return view('geography::livewire.states', [
            'data'        => $data,
            'selectedIds' => $this->selectedIds,
            'countries'   => \Modules\Geography\Entities\Country::pluck('name', 'id')->toArray(),
            'regions'     => \Modules\Geography\Entities\Region::pluck('name', 'id')->toArray(),
            'subregions'  => \Modules\Geography\Entities\Subregion::pluck('name', 'id')->toArray(),
        ]);
    }
}
