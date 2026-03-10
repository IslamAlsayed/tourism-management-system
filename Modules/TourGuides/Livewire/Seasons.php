<?php

namespace Modules\TourGuides\Livewire;

use Modules\Accommodations\Entities\Season;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Seasons extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $accommodationsForSeasons = [];
    public $filterStatus = '';
    public $type = null;
    protected $queryString = ['type'];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Season::class);
        // $this->accommodationsForSeasons = Season::with('accommodation:id,name')->get()->pluck('accommodation')->flatten()->unique('id')->sortBy('name')->values();
        $this->type = request()->query('type');
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Season::class, 'season');
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
        $paginator = Season::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Season::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Season::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.seasons'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Season::class, $cols, 'seasons');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Season::class, $cols, 'seasons', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Season::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterStatus && $this->filterStatus['payload']['value'] !== 'all') {
            $query->where('is_active', $this->filterStatus['payload']['value'] === 'active' ? true : false);
        }
        if ($this->type) {
            $query->where('model_type', 'like', '%' . studlyCaseName($this->type) . '%');
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('tourguides::livewire.seasons', ['data' => $data, 'totalCount' => $this->totalCount ?: Season::count(), 'selectedIds' => $this->selectedIds]);
    }
}

