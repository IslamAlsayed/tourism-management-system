<?php

namespace Modules\Localization\Livewire;

use Livewire\Component;
use Modules\Localization\Entities\Currency;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Currencies extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;
    public $search = '';
    public $totalCount = '';
    public $filterActive = '';
    public $filterBaseCurrency = '';
    public $filterMajorCurrency = '';
    public $filterAutoUpdate = '';
    public $message = [];
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function syncRates()
    {
        try {
            $exitCode = Artisan::call('sync:currencies');
            $output = Artisan::output();

            if ($exitCode === 0) {
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => 'Currency exchange rates have been synchronized successfully.'
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'Failed to synchronize rates. Make sure a Base Currency is defined.'
                ]);
                Log::error('Currency Sync UI Trigger Failed: ' . $output);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Unexpected error occurred during synchronization.'
            ]);
            Log::error('Currency Sync UI Trigger Error: ' . $e->getMessage());
        }
        $this->dispatch('refresh-page');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterActive($value)
    {
        $this->filterActive = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterBaseCurrency($value)
    {
        $this->filterBaseCurrency = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterMajorCurrency($value)
    {
        $this->filterMajorCurrency = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterAutoUpdate($value)
    {
        $this->filterAutoUpdate = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Currency::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Currency::class, 'currency');
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
        $paginator = Currency::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    public function enableAutoUpdateSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_auto_update' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.currencies'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function disableAutoUpdateSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_auto_update' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.currencies'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function markMajorSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_major_currency' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.currencies'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function unmarkMajorSelected()
    {
        if (empty($this->selectedIds)) return;
        Currency::whereIn('id', $this->selectedIds)->update(['is_major_currency' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.currencies'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function markBaseSelected()
    {
        if (empty($this->selectedIds)) return;
        
        // Usually there can only be one base currency, but if business logic allows multiple, or we just update them:
        // If only one is allowed, we'd need to unmark all others first. Assuming it just sets the flag here.
        // Let's unmark all currencies first, then mark the selected ones as base.
        Currency::query()->update(['is_base_currency' => false]);
        Currency::whereIn('id', $this->selectedIds)->update(['is_base_currency' => true]);
        
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.currencies'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function clearSelected()
    {
        $this->selectedIds = [];
        $this->selectPage = false;
        $this->dispatch('reset-checkout-boxes');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        Currency::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(Currency::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.currencies'), 'count' => $count]),
        ]);
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, Currency::class, 'currency');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $count = count($this->selectedIds);
        Currency::whereIn('id', $this->selectedIds)->each(function ($currency) {
            $currency->forceDelete();
        });
        $this->resetAutoIncrementIfEmpty(Currency::class);
        $this->clearSelected();

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.currencies'), 'count' => $count]),
        ]);
    }

    public function exportSelectedPDF()
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], Currency::class, $cols, 'currencies');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], Currency::class, $cols, 'currencies', $extension);
    }

    public function render()
    {
        $query = Currency::query();

        if ($this->filterActive === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterActive === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterBaseCurrency === 'yes') {
            $query->where('is_base_currency', true);
        } elseif ($this->filterBaseCurrency === 'no') {
            $query->where('is_base_currency', false);
        }

        if ($this->filterMajorCurrency === 'yes') {
            $query->where('is_major_currency', true);
        } elseif ($this->filterMajorCurrency === 'no') {
            $query->where('is_major_currency', false);
        }

        if ($this->filterAutoUpdate === 'yes') {
            $query->where('is_auto_update', true);
        } elseif ($this->filterAutoUpdate === 'no') {
            $query->where('is_auto_update', false);
        }

        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        return view('localization::livewire.currencies', [
            'data' => $data, 
            'totalCount' => $query->count(), 
            'selectedIds' => $this->selectedIds
        ]);
    }
}

