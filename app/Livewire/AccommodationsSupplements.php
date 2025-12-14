<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\AccommodationSupplement;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Models\Type;
use App\Traits\HandlesCrudSafely;

class AccommodationsSupplements extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $types = [];
    public $filterStatus = '';
    public $filterPerPerson = '';
    public $filterMandatory = '';
    public $filter = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(AccommodationSupplement::class);
        $this->types = Type::pluck('name', 'id')->toArray();
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'accommodation-supplement');
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
        $paginator = AccommodationSupplement::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        AccommodationSupplement::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.accommodation-supplements'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], AccommodationSupplement::class, $cols, 'accommodations-supplements');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], AccommodationSupplement::class, $cols, 'accommodations-supplements', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterStatus', 'filterPerPerson', 'filterMandatory']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = AccommodationSupplement::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        if ($this->filterPerPerson && $this->filterPerPerson['payload']['value'] !== 'all') {
            $query->where('is_per_person', $this->filterPerPerson['payload']['value'] === 'yes' ? true : false);
        }
        if ($this->filterMandatory && $this->filterMandatory['payload']['value'] !== 'all') {
            $query->where('is_mandatory', $this->filterMandatory['payload']['value'] === 'yes' ? true : false);
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('livewire.accommodations-supplements', ['data' => $data, 'totalCount' => $this->totalCount ?: AccommodationSupplement::count(), 'selectedIds' => $this->selectedIds]);
    }
}