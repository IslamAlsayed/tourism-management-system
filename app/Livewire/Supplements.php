<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\Supplement;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Models\Type;
use App\Traits\HandlesCrudSafely;

class Supplements extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $types = [];
    public $filterPriceType = '';
    public $filterMandatory = '';
    public $filterActive = '';
    public $filter = '';
    public $type = null;
    protected $queryString = ['type'];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPriceType()
    {
        $this->resetPage();
    }

    public function updatingFilterMandatory()
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
        $this->mountWithCustomColumns(Supplement::class);
        $this->types = Type::pluck('name', 'id')->toArray();
        $this->type = request()->query('type');
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'supplement');
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
        $paginator = Supplement::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Supplement::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.supplements'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Supplement::class, $cols, 'accommodations-supplements');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Supplement::class, $cols, 'accommodations-supplements', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterPriceType', 'filterMandatory', 'filterActive']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Supplement::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterPriceType && $this->filterPriceType !== 'all') {
            $query->where('price_type', $this->filterPriceType);
        }
        if ($this->filterMandatory && $this->filterMandatory !== 'all') {
            $query->where('is_mandatory', $this->filterMandatory === 'yes' ? true : false);
        }
        if ($this->filterActive && $this->filterActive !== 'all') {
            $query->where('is_active', $this->filterActive === 'active' ? true : false);
        }
        if ($this->type) {
            $query->where('model_type', 'like', '%' . $this->type . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.supplements', ['data' => $data, 'totalCount' => $this->totalCount ?: Supplement::count(), 'selectedIds' => $this->selectedIds]);
    }
}