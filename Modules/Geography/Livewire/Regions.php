<?php

namespace Modules\Geography\Livewire;

use Modules\Geography\Entities\Region;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\HandlesBulkActions;

class Regions extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData, HandlesBulkActions;

    public $search = '';
    public $message = [];
    public $filterActive = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Region::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Region::class, 'region');
    }

    protected function buildQuery()
    {
        $query = Region::query();

        if ($this->filterActive === 'active') {
            $query->where('regions.is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('regions.is_active', false);
        }

        $query->searchWithRelations(
            search: $this->search,
            selectedColumns: $this->columns,
            availableRelations: $this->relations
        );

        $query->withCount([
            'subregions',
            'countries',
            'accommodations',
            'restaurants',
            'transportationCompanies'
        ]);

        $this->applySorting($query);

        return $query;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterActive']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Region::class, $cols, 'regions');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Region::class, $cols, 'regions', $extension);
    }

    public function render()
    {
        $data = $this->buildQuery()->paginate(getPaginate());

        return view('geography::livewire.regions', [
            'data'        => $data,
            'selectedIds' => $this->selectedIds,
        ]);
    }
}
