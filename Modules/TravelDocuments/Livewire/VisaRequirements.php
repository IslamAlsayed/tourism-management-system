<?php

namespace Modules\TravelDocuments\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\TravelDocuments\Entities\VisaRequirement;

class VisaRequirements extends Component
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

    public function refreshData()
    {
        $this->resetPage();
        $this->reset('search', 'totalCount');
        $this->render();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.data_refreshed_successfully')
        ]);
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(VisaRequirement::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, VisaRequirement::class, 'visa-requirement');
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
        $paginator = VisaRequirement::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        VisaRequirement::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(VisaRequirement::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.visa-requirements'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], VisaRequirement::class, $cols, 'visa-requirements');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], VisaRequirement::class, $cols, 'visa-requirements', $extension);
    }

    protected function getCacheKey()
    {
        return 'visa-requirements_list:' . md5(json_encode([
            'search' => $this->search,
            'page' => request()->get('page', 1),
            'sort' => $this->sortField ?? null,
            'dir' => $this->sortDirection ?? null,
            'perPage' => getPaginate(),
            'user_id' => getActiveUserId(),
        ]));
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();
        $data = Cache::remember($cacheKey, now()->addMinutes(1), function () {
            $query = VisaRequirement::query(); // Add relations if needed: with('currency', 'country')

            $query->searchWithRelations(
                search: $this->search,
                selectedColumns: $this->columns,
                availableRelations: $this->relations ?? [] // Should define relations in VisaRequirement model
            );
            $this->applySorting($query);
            return $query->paginate(getPaginate());
        });

        return view('traveldocuments::livewire.visa-requirements', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: VisaRequirement::count(),
            'selectedIds' => $this->selectedIds
        ]);
    }
}

