<?php

namespace Modules\TourGuides\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\TourGuides\Entities\TourGuide;

class Guides extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = 0;
    public $filterActive = '';
    public $filterRegionId = '';
    public $filterSubregionId = '';
    public $filterCountryId = '';
    public $filterStateId = '';
    public $filterCityId = '';
    public $filterTypeId = '';
    
    protected $listeners = ['recordUpdated' => '$refresh', 'refresh-page' => '$refresh', 'reset-checkout-boxes' => '$refresh', 'filterColumn' => 'filterColumn'];

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

    public function updatingFilterCountryId()
    {
        $this->resetPage();
    }

    public function updatingFilterStateId()
    {
        $this->resetPage();
    }

    public function updatingFilterCityId()
    {
        $this->resetPage();
    }

    public function updatingFilterTypeId()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterRegionId', 'filterSubregionId', 'filterCountryId', 'filterStateId', 'filterCityId', 'filterTypeId']);
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TourGuide::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, TourGuide::class, 'tour_guide');
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, TourGuide::class, 'tour_guide');
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
        $query = TourGuide::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterRegionId && $this->filterRegionId !== 'all') {
            $query->whereHas('country.subregion', function ($q) {
                $q->where('region_id', $this->filterRegionId);
            });
        }
        
        if ($this->filterSubregionId && $this->filterSubregionId !== 'all') {
            $query->whereHas('country', function ($q) {
                $q->where('subregion_id', $this->filterSubregionId);
            });
        }

        if ($this->filterCountryId && $this->filterCountryId !== 'all') {
            $query->where('country_id', $this->filterCountryId);
        }

        if ($this->filterStateId && $this->filterStateId !== 'all') {
            $query->where('state_id', $this->filterStateId);
        }

        if ($this->filterCityId && $this->filterCityId !== 'all') {
            $query->where('city_id', $this->filterCityId);
        }

        if ($this->filterTypeId && $this->filterTypeId !== 'all') {
            $query->where('type_id', $this->filterTypeId);
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations,
            searchColumnsFilters: $this->searchColumns
        );

        $this->applySorting($query);

        return $query;
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TourGuide::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(TourGuide::class);
        $count = count($this->selectedIds);
        $this->clearSelected();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.tour_guides'), 'count' => $count]),
        ]);
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        TourGuide::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(TourGuide::class);
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], TourGuide::class, $cols, 'tour_guides');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], TourGuide::class, $cols, 'tour_guides', $extension);
    }

    public function render()
    {
        $query = $this->buildQuery();
        $data = $query->paginate(getPaginate());
        
        return view('tourguides::livewire.guides', [
            'data' => $data, 
            'totalCount' => TourGuide::count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}

