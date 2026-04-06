<?php

namespace Modules\Definitions\Livewire;

use Livewire\Component;
use App\Traits\ExportsData;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use App\Traits\CustomColumnsLivewireLegacy;
use Modules\Definitions\Entities\PricingDefinition;

class PricingDefinitions extends Component
{
    use WithPagination, CustomPagination, CustomColumnsLivewireLegacy, WithSorting, HandlesCrudSafely, ExportsData;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $category = null;
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterModule = 'all';
    
    // Quick Edit Properties
    public $quickEditId = null;
    public $quickEditModules = [];
    public $isQuickEditModalOpen = false;

    protected $listeners = ['recordUpdated' => '$refresh', 'closeModal' => 'closeQuickEdit'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory($value)
    {
        $this->filterCategory = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function updatingFilterStatus($value)
    {
        $this->filterStatus = is_array($value) && isset($value['payload']['value']) ? $value['payload']['value'] : $value;
        $this->resetPage();
    }

    public function mount($category = null)
    {
        $this->category = request()->query('category', $category);
        $this->filterCategory = $this->category ?: 'all';
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(PricingDefinition::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, PricingDefinition::class, 'pricing_definition');
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
        $paginator = PricingDefinition::paginate(getPaginate());
        return $paginator->getCollection()->pluck('id');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        PricingDefinition::whereIn('id', $this->selectedIds)->delete();
        $this->resetAutoIncrementIfEmpty(PricingDefinition::class);
        $count = count($this->selectedIds);
        $this->selectedIds = [];

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_deleted_count', ['type' => __('main.pricing-definitions'), 'count' => $count]),
        ]);
    }

    // --- Quick Edit Methods ---

    public function openQuickEdit($id)
    {
        $definition = PricingDefinition::with('moduleAssignments')->findOrFail($id);
        $this->quickEditId = $id;
        // Pre-fill existing modules
        $this->quickEditModules = $definition->moduleAssignments->pluck('module_name')->toArray();
        $this->isQuickEditModalOpen = true;
    }

    public function closeQuickEdit()
    {
        $this->isQuickEditModalOpen = false;
        $this->quickEditId = null;
        $this->quickEditModules = [];
    }

    public function saveQuickEdit()
    {
        if (!$this->quickEditId) return;

        $definition = PricingDefinition::findOrFail($this->quickEditId);
        
        // Delete existing module assignments for this definition
        \Modules\Definitions\Entities\PricingDefinitionModule::where('pricing_definition_id', $definition->id)->delete();
        
        // Insert new ones
        $newAssignments = [];
        // Ensure we handle case where no modules were selected (empty array)
        $modulesToSave = is_array($this->quickEditModules) ? $this->quickEditModules : [];
        foreach ($modulesToSave as $moduleName) {
            $newAssignments[] = [
                'pricing_definition_id' => $definition->id,
                'module_name' => $moduleName,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        if (!empty($newAssignments)) {
            \Modules\Definitions\Entities\PricingDefinitionModule::insert($newAssignments);
        }

        $this->closeQuickEdit();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.quick_edit_saved', ['type' => __('main.module_assignments')]),
        ]);
    }

    // --- Bulk Action Methods ---

    public function activateSelected()
    {
        if (empty($this->selectedIds)) return;
        
        PricingDefinition::whereIn('id', $this->selectedIds)->update(['is_active' => true]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.pricing-definitions'), 'count' => count($this->selectedIds)]),
        ]);
    }

    public function deactivateSelected()
    {
        if (empty($this->selectedIds)) return;
        
        PricingDefinition::whereIn('id', $this->selectedIds)->update(['is_active' => false]);
        $this->clearSelected();
        $this->dispatch('refresh-page');
        
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.type_updated_count', ['type' => __('main.pricing-definitions'), 'count' => count($this->selectedIds)]),
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
        return $this->exportSelectedPdfForModel($this->selectedIds ?? [], PricingDefinition::class, $cols, 'pricing-definitions');
    }

    public function exportSelectedExcel($extension)
    {
        $cols = !empty($this->pendingColumns) ? $this->pendingColumns : ($this->columns ?? null);
        return $this->exportSelectedExcelForModel($this->selectedIds ?? [], PricingDefinition::class, $cols, 'pricing-definitions', $extension);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCategory', 'filterStatus', 'filterModule']);
        $this->resetSort();
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = PricingDefinition::with('moduleAssignments');
        
        $activeCategory = ($this->filterCategory && $this->filterCategory !== 'all') ? $this->filterCategory : (($this->filterCategory === 'all') ? null : $this->category);
        
        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }
        
        if ($this->filterStatus && $this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active' ? true : false);
        }
        
        if ($this->filterModule && $this->filterModule !== 'all') {
            $query->whereHas('moduleAssignments', function ($q) {
                $q->where('module_name', $this->filterModule);
            });
        }
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        $data = $query->paginate(getPaginate());
        $totalCount = $this->category ? PricingDefinition::where('category', $this->category)->count() : PricingDefinition::count();
        $categories = PricingDefinition::getCategories();
        return view('definitions::livewire.pricing-definitions', [
            'data' => $data, 
            'totalCount' => $this->totalCount ?: $totalCount, 
            'selectedIds' => $this->selectedIds,
            'allColumns' => $this->allColumns,
            'categories' => $categories
        ]);
    }
}

