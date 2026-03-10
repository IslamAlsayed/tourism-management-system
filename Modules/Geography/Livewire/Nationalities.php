<?php

namespace Modules\Geography\Livewire;

use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\ExportsData;
use App\Traits\HandlesCrudSafely;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Geography\Entities\Nationality;

class Nationalities extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = 0;
    public $filterActive = '';
    public $filterRegionId = '';
    public $filterSubregionId = '';
    public $filterCountryId = '';
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

    public function updatingFilterCountryId()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Nationality::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Nationality::class, 'nationality');
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, Nationality::class, 'nationality');
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
        $query = Nationality::query();

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

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations
        );

        $this->applySorting($query);

        return $query;
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        Nationality::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        Nationality::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Nationality::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Nationality::class);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) return;
        Nationality::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(Nationality::class);
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Nationality::class, $cols, 'nationalities');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Nationality::class, $cols, 'nationalities', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive', 'filterRegionId', 'filterSubregionId', 'filterCountryId']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = $this->buildQuery();
        $this->totalCount = (clone $query)->count();
        $data = $query->paginate(getPaginate());

        return view('geography::livewire.nationalities', [
            'data'        => $data,
            'totalCount'  => $this->totalCount,
            'selectedIds' => $this->selectedIds,
            'regions'     => \Modules\Geography\Entities\Region::pluck('name', 'id')->toArray(),
            'subregions'  => \Modules\Geography\Entities\Subregion::when($this->filterRegionId && $this->filterRegionId !== 'all', function ($q) {
                $q->where('region_id', $this->filterRegionId);
            })->pluck('name', 'id')->toArray(),
            'countries'   => \Modules\Geography\Entities\Country::query()
                ->when($this->filterSubregionId && $this->filterSubregionId !== 'all', function ($q) {
                    $q->where('subregion_id', $this->filterSubregionId);
                })
                ->when($this->filterRegionId && $this->filterRegionId !== 'all' && empty($this->filterSubregionId), function ($q) {
                    $q->whereHas('subregion', function($q2) {
                        $q2->where('region_id', $this->filterRegionId);
                    });
                })->pluck('name', 'id')->toArray(),
        ]);
    }
}
