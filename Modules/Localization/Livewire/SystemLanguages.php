<?php

namespace Modules\Localization\Livewire;

use Livewire\Component;
use Modules\Localization\Entities\SystemLanguage;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumnsLivewireLegacy;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\ExportsData;

class SystemLanguages extends Component
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
        $this->mountWithCustomColumns(SystemLanguage::class);
        
        // Force specific columns if they are not correctly fetched or user cleared them
        if (empty($this->columns) || count($this->columns) <= 2) {
            $this->columns = ['id', 'code', 'name', 'photo', 'created_at', 'updated_at'];
            $this->pendingColumns = $this->columns;
        }

        $this->view = session('languages_view', 'grid');
        $this->gridLength = session('grid_length_system_languages', 5);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, SystemLanguage::class, 'system_language');
    }

    public function toggleActive($id)
    {
        $language = SystemLanguage::find($id);
        if ($language) {
            $language->update([
                'is_active' => !$language->is_active
            ]);
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('messages.status_updated', ['type' => __('main.language')]),
            ]);
        }
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
        $paginator = SystemLanguage::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        SystemLanguage::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(SystemLanguage::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.system_languages'), 'count' => $count]),
        ]);
    }

    public function forceDelete($id)
    {
        $this->safeForceDelete($id, SystemLanguage::class, 'system_language');
    }

    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        SystemLanguage::whereIn('id', $this->selectedIds)->forceDelete();
        $this->resetAutoIncrementIfEmpty(SystemLanguage::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_force_deleted_count', ['type' => __('main.system_languages'), 'count' => $count]),
        ]);
        $this->dispatch('reset-checkout-boxes');
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], SystemLanguage::class, $cols, 'system_languages');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], SystemLanguage::class, $cols, 'system_languages', $extension);
    }

    public function bulkActivate()
    {
        if (!empty($this->selectedIds)) {
            SystemLanguage::whereIn('id', $this->selectedIds)->update(['is_active' => 1]);
            $this->selectedIds = [];
            $this->selectPage = false;
            $this->dispatch('reset-checkout-boxes');
            $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.status_updated', ['type' => __('main.languages')])]);
        }
    }

    public function bulkDeactivate()
    {
        if (!empty($this->selectedIds)) {
            SystemLanguage::whereIn('id', $this->selectedIds)->update(['is_active' => 0]);
            $this->selectedIds = [];
            $this->selectPage = false;
            $this->dispatch('reset-checkout-boxes');
            $this->dispatch('show-toast', ['type' => 'success', 'message' => __('messages.status_updated', ['type' => __('main.languages')])]);
        }
    }

    public function toggleView()
    {
        $this->view = $this->view === 'table' ? 'grid' : 'table';
        session(['languages_view' => $this->view]);
    }

    public function setAsDefault($id)
    {
        $language = SystemLanguage::find($id);
        if ($language) {
            // Remove default from all languages
            SystemLanguage::where('is_default', true)->update(['is_default' => false]);
            // Set this as default and ensure it's active
            $language->update([
                'is_default' => true,
                'is_active' => true,
            ]);

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('messages.type_updated', ['type' => __('main.default_language')]),
            ]);
        }
    }

    public function updateOrder($orderedIds)
    {
        if (!is_array($orderedIds)) return;
        
        foreach ($orderedIds as $index => $id) {
            SystemLanguage::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.status_updated', ['type' => __('main.order')]),
        ]);
    }

    public function moveUp($id)
    {
        $language = SystemLanguage::find($id);
        if ($language) {
            $previousLanguage = SystemLanguage::where('sort_order', '<', $language->sort_order)
                ->orderBy('sort_order', 'desc')
                ->first();

            if ($previousLanguage) {
                // Swap sort orders
                $tempOrder = $language->sort_order;
                $language->update(['sort_order' => $previousLanguage->sort_order]);
                $previousLanguage->update(['sort_order' => $tempOrder]);
                
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => __('messages.status_updated', ['type' => __('main.order')]),
                ]);
            }
        }
    }

    public function moveDown($id)
    {
        $language = SystemLanguage::find($id);
        if ($language) {
            $nextLanguage = SystemLanguage::where('sort_order', '>', $language->sort_order)
                ->orderBy('sort_order', 'asc')
                ->first();

            if ($nextLanguage) {
                // Swap sort orders
                $tempOrder = $language->sort_order;
                $language->update(['sort_order' => $nextLanguage->sort_order]);
                $nextLanguage->update(['sort_order' => $tempOrder]);
                
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => __('messages.status_updated', ['type' => __('main.order')]),
                ]);
            }
        }
    }

    public function toggleGridLength($length, $models)
    {
        session(['grid_length_' . $models => $length ?? 5]);
    }

    public function render()
    {
        $query = SystemLanguage::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        
        if (empty($this->sortField)) {
            $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
        } else {
            $this->applySorting($query);
        }
        
        $data = $query->paginate(getPaginate());
        return view('localization::livewire.system-languages', [
            'data' => $data, 
            'totalCount' => $this->totalCount ?: SystemLanguage::count(), 
            'selectedIds' => $this->selectedIds,
            'allColumns' => $this->allColumns,
            'columns' => $this->columns,
        ]);
    }
}

