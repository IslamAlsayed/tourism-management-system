<?php

namespace App\Livewire;

use App\Models\TravelPass;
use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;
use App\Traits\CustomColumnsLivewireLegacy;

class TravelPasses extends Component
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
        $this->mountWithCustomColumns(TravelPass::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, TravelPass::class, 'travel-pass');
        Cache::tags(['travel-pass'])->flush();
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
        $paginator = TravelPass::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        TravelPass::whereIn('id', $this->selectedIds)->delete();
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.travel-pass'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedPdfForModel($this->selectedIds ?? [], TravelPass::class, $cols, 'travel-pass');
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        $result = $this->exportSelectedExcelForModel($this->selectedIds ?? [], TravelPass::class, $cols, 'travel-pass', $extension);
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
        return $result;
    }

    protected function getCacheKey()
    {
        return 'travel-pass_list:' . md5(json_encode([
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
            $query = TravelPass::query(); // Add relations if needed: with('currency', 'country')

            $query->searchWithRelations(
                search: $this->search,
                selectedColumns: $this->columns,
                availableRelations: $this->relations ?? [] // Should define relations in TravelPass model
            );
            $this->applySorting($query);
            return $query->paginate(getPaginate());
        });

        return view('livewire.travel-passes', [
            'data' => $data,
            'totalCount' => $this->totalCount ?: TravelPass::count(),
            'selectedIds' => $this->selectedIds
        ]);
    }
}
