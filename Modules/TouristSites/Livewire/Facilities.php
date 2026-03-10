<?php

namespace Modules\TouristSites\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\TouristSites\Entities\Facility;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Facilities extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Facility::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Facility::class, 'facility');
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
        $paginator = Facility::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Facility::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Facility::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.facilities'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Facility::class, $cols, 'facilities');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Facility::class, $cols, 'facilities', $extension);
    }

    public function render()
    {
        $query = Facility::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        $this->totalCount = $data->total();

        return view('touristsites::livewire.facilities', [
            'data' => $data,
            'totalCount' => $this->totalCount,
            'selectedIds' => $this->selectedIds,
        ]);
    }
}

