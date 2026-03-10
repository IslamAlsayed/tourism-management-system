<?php

namespace Modules\Geography\Livewire;

use Modules\Geography\Entities\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Countries extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $filterActive = '';
    public $filterRegionId = '';
    public $filterSubregionId = '';
    public $regionsList = [];
    public $subregionsList = [];
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

    public function updatingFilterSubregionId()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Country::class);
        $this->regionsList = \Modules\Geography\Entities\Region::pluck('name', 'id')->toArray();
        $this->subregionsList = \Modules\Geography\Entities\Subregion::pluck('name', 'id')->toArray();
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Country::class, 'country');
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, Country::class, 'country');
    }

    public function updatedSelectPage($value)
    {
        $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
    }

    public function updatedSelectedIds()
    {
        $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
    }

    /**
     * Get IDs for the current page, applying the same active filters.
     */
    protected function currentPageDataIds()
    {
        return $this->buildQuery()->paginate(getPaginate())->getCollection()->pluck('id');
    }

    /**
     * Build the filtered query once — reused in render() and currentPageDataIds().
     */
    protected function buildQuery()
    {
        $query = Country::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->where('region_id', $this->filterRegionId);
        }

        if ($this->filterSubregionId && $this->filterSubregionId !== 'all') {
            $query->where('subregion_id', $this->filterSubregionId);
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations
        );

        // Only count relations whose columns are actually visible
        $countRelations = array_filter([
            'states' => in_array('states_count', $this->columns),
            'cities' => in_array('cities_count', $this->columns),
            'accommodations' => in_array('accommodations_count', $this->columns),
            'restaurants' => in_array('restaurants_count', $this->columns),
            'transportationCompanies' => in_array('transportation_companies_count', $this->columns),
        ]);
        if (!empty($countRelations)) {
            $query->withCount(array_keys($countRelations));
        }

        $this->applySorting($query);

        return $query;
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        Country::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        Country::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Country::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Country::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Country::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(Country::class);
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Country::class, $cols, 'countries');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Country::class, $cols, 'countries', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterRegionId', 'filterSubregionId']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $data = $this->buildQuery()->paginate(getPaginate());

        return view('geography::livewire.countries', [
            'data'        => $data,
            'selectedIds' => $this->selectedIds,
            'regions'     => $this->regionsList,
            'subregions'  => $this->subregionsList,
        ]);
    }
}
