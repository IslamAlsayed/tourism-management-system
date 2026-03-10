<?php

namespace Modules\TouristServices\Livewire;

use Modules\TouristServices\Entities\TouristService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class TouristServices extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterFeatured = '';
    public $filterFreeEntry = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterFeatured()
    {
        $this->resetPage();
    }

    public function updatingFilterFreeEntry()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(TouristService::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, TouristService::class, 'tourist-service');
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
        $paginator = TouristService::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TouristService::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(TouristService::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('tourist-service.tourist-services'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], TouristService::class, $cols, 'tourist-services');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], TouristService::class, $cols, 'tourist-services', $extension);
    }

    public function render()
    {
        $query = TouristService::with((new TouristService)->getRelationshipNames());
        // $query = TouristService::query();

        // Apply search
        // if ($this->search) {
        //     $query->where(function ($q) {
        //         $q->where('name', 'like', '%' . $this->search . '%')
        //             ->orWhere('name_ar', 'like', '%' . $this->search . '%')
        //             ->orWhere('description', 'like', '%' . $this->search . '%')
        //             ->orWhere('address', 'like', '%' . $this->search . '%')
        //             ->orWhere('code', 'like', '%' . $this->search . '%');
        //     });
        // }

        // Apply filters
        if ($this->filterType)
            $query->where('type', $this->filterType);
        if ($this->filterCategory)
            $query->where('category', $this->filterCategory);
        if ($this->filterStatus)
            $query->where('status', $this->filterStatus);
        if ($this->filterFeatured)
            $query->where('is_featured', $this->filterFeatured);
        if ($this->filterFreeEntry)
            $query->where('is_free_entry', $this->filterFreeEntry);
        $query = $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        // dd($data->toArray());

        $this->totalCount = $data->total();
        return view('touristservices::livewire.services', ['data' => $data]);
    }
}

