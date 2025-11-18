<?php

namespace App\Livewire;

use App\Models\TouristSite;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class TouristSites extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterType = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterFeatured = '';
    public $filterFreeEntry = '';

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
        $data = $this->paginate != 'all' ? $query->paginate(getPaginate()) : $query->get();
        $this->totalCount = $data->total();
        $query = $this->applySorting($query);
        return view('livewire.tourist-sites', [
            'data' => $data,
            'siteTypes' => TouristSite::getSiteTypes(),
            'categories' => TouristSite::getCategories(),
            'statuses' => TouristSite::getStatuses(),
        ]);
    }
}