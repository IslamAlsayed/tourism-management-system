<?php

namespace App\Livewire;

use App\Models\Meal;
use Livewire\Component;
use App\Models\Currency;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Meals extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterCurrencyId = '';
    public $currencies = [];
    public $filterStatus = '';
    public $filterIsIncluded = '';
    public $type = null;
    protected $queryString = ['type'];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCurrencyId()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterIsIncluded()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Meal::class);
        $this->currencies = Currency::whereIn('id', Meal::pluck('currency_id'))->get(['code', 'name', 'id'])->toArray();
        $this->type = request()->query('type');
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Meal::class, 'meal');
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
        $paginator = Meal::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Meal::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.meals'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], Meal::class, $cols, 'meals');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], Meal::class, $cols, 'meals', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCurrencyId', 'filterStatus', 'filterIsIncluded']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Meal::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterCurrencyId && $this->filterCurrencyId != 'all') {
            $query->where('currency_id', $this->filterCurrencyId);
        }
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        if ($this->filterIsIncluded && $this->filterIsIncluded['payload']['value'] !== 'all') {
            $query->where('is_included', $this->filterIsIncluded['payload']['value'] === 'yes' ? true : false);
        }
        if ($this->type) {
            $query->where('model_type', 'like', '%' . $this->type . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.meals', ['data' => $data, 'totalCount' => $this->totalCount ?: Meal::count(), 'selectedIds' => $this->selectedIds]);
    }
}