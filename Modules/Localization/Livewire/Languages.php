<?php

namespace Modules\Localization\Livewire;

use Livewire\Component;
use Modules\Localization\Entities\Language;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class Languages extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $view = 'grid'; // or table
    public $gridLength = 5;
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Language::class);

        // display view mode [ grid | table ]
        $this->view = session('languages_view', 'grid');
        $this->gridLength = session('grid_length_languages', 5);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Language::class, 'language');
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
        $paginator = Language::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Language::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Language::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.languages'), 'count' => $count]),
        ]);
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Language::class, $cols, 'languages');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Language::class, $cols, 'languages', $extension);
    }

    // Toggle between grid and table view
    public function toggleView()
    {
        $this->view = $this->view === 'table' ? 'grid' : 'table';
        session(['languages_view' => $this->view]);
    }

    public function toggleGridLength($length, $models)
    {
        session(['grid_length_' . $models => $length ?? 5]);
    }

    public function render()
    {
        $query = Language::query()->orderBy('name');
        if (!empty($this->search)) {
            $query->search($this->search);
        }
        if (!empty($this->columns) && !empty($this->relations)) {
            $relationsToLoad = array_intersect($this->relations, $this->columns);
            if (!empty($relationsToLoad)) {
                $query->with($relationsToLoad);
            }
        }
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('localization::livewire.languages', ['data' => $data, 'totalCount' => $this->totalCount ?: Language::count(), 'selectedIds' => $this->selectedIds]);
    }
}

