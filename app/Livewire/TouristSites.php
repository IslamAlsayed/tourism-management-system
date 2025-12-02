<?php

namespace App\Livewire;

use App\Models\TouristSite;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class TouristSites extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely, ExportsData;

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
        $this->mountWithCustomColumns(TouristSite::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'tourist-site');
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
        $paginator = TouristSite::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TouristSite::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('tourist_site.tourist_sites'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], TouristSite::class, $cols, 'tourist_sites');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], TouristSite::class, $cols, 'tourist_sites', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function render()
    {
        $query = TouristSite::with(['region', 'subregion', 'country', 'state', 'city', 'creator', 'updater']);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('name_ar', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%')
                    ->orWhere('site_code', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }
        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterFeatured !== '') {
            $query->where('is_featured', $this->filterFeatured);
        }
        if ($this->filterFreeEntry !== '') {
            $query->where('is_free_entry', $this->filterFreeEntry);
        }
        $query = $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        $this->totalCount = $data->total();
        return view('livewire.tourist-sites', [
            'data' => $data,
            'siteTypes' => TouristSite::getSiteTypes(),
            'categories' => TouristSite::getCategories(),
            'statuses' => TouristSite::getStatuses(),
        ]);
    }
}