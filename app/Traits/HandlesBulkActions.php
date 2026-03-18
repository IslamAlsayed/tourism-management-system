<?php

namespace App\Traits;

trait HandlesBulkActions
{
    /**
     * Handles bulk selection checking/unchecking all on page
     */
    public function updatedSelectPage($value)
    {
        \Log::info('updatedSelectPage triggered', ['value' => $value]);
        // Use the existing properties from ExportsData trait
        if (property_exists($this, 'selectedIds')) {
            $this->selectedIds = $value ? $this->currentPageDataIds()->toArray() : [];
            \Log::info('selectedIds updated', ['count' => count($this->selectedIds)]);
        }
    }

    /**
     * Updates the "select all" checkbox state when individual checkboxes are toggled
     */
    public function toggleSelectAll($pageIds = [])
    {
        if (property_exists($this, 'selectPage')) {
            $this->selectPage = !$this->selectPage;
            
            if ($this->selectPage) {
                // If checking select all, use the provided IDs or fallback to the query
                $this->selectedIds = !empty($pageIds) ? $pageIds : $this->currentPageDataIds()->toArray();
            } else {
                // If unchecking, clear selection
                $this->selectedIds = [];
            }
        }
    }

    public function toggleSelection($id, $pageIds = [])
    {
        if (property_exists($this, 'selectedIds')) {
            if (in_array((string)$id, array_map('strval', $this->selectedIds))) {
                $this->selectedIds = array_filter($this->selectedIds, fn($selected) => (string)$selected !== (string)$id);
            } else {
                $this->selectedIds[] = $id;
            }
            $this->selectedIds = array_values($this->selectedIds);
            
            if (property_exists($this, 'selectPage')) {
                // If pageIds is not empty, use that for count, otherwise fallback to DB query
                $pageIdCount = !empty($pageIds) ? count($pageIds) : count($this->currentPageDataIds());
                $this->selectPage = count($this->selectedIds) > 0 && count($this->selectedIds) >= $pageIdCount;
            }
        }
    }

    /**
     * Updates the "select all" checkbox state when individual checkboxes are toggled
     */
    public function updatedSelectedIds()
    {
        if (property_exists($this, 'selectPage') && property_exists($this, 'selectedIds')) {
            $this->selectPage = count($this->selectedIds) === $this->currentPageDataIds()->count();
        }
    }

    /**
     * Get IDs for the current page, applying the same active filters.
     * Assumes the component implements buildQuery()
     */
    protected function currentPageDataIds()
    {
        if (method_exists($this, 'buildQuery')) {
            return $this->buildQuery()->paginate(getPaginate())->getCollection()->pluck('id');
        }
        
        // Fallback if buildQuery doesn't exist but modelClass does
        if (property_exists($this, 'modelClass') && $this->modelClass) {
            return $this->modelClass::paginate(getPaginate())->getCollection()->pluck('id');
        }
        
        return collect();
    }

    /**
     * Bulk Activate selected records
     */
    public function activateSelected()
    {
        $this->performBulkUpdate(['is_active' => true]);
    }

    /**
     * Bulk Deactivate selected records
     */
    public function deactivateSelected()
    {
        $this->performBulkUpdate(['is_active' => false]);
    }

    /**
     * Internal method to safely perform bulk updates
     */
    protected function performBulkUpdate(array $data)
    {
        if (empty($this->selectedIds) || empty($this->modelClass)) {
            return;
        }

        $this->modelClass::whereIn('id', $this->selectedIds)->update($data);
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    /**
     * Bulk soft-delete selected records
     */
    public function deleteSelected()
    {
        if (empty($this->selectedIds) || empty($this->modelClass)) {
            return;
        }

        $this->modelClass::whereIn('id', $this->selectedIds)->delete();
        
        if (method_exists($this, 'resetAutoIncrementIfEmpty')) {
            $this->resetAutoIncrementIfEmpty($this->modelClass);
        }
        
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    /**
     * Bulk force-delete selected records
     */
    public function forceDeleteSelected()
    {
        if (empty($this->selectedIds) || empty($this->modelClass)) {
            return;
        }

        $this->modelClass::whereIn('id', $this->selectedIds)->forceDelete();
        
        if (method_exists($this, 'resetAutoIncrementIfEmpty')) {
            $this->resetAutoIncrementIfEmpty($this->modelClass);
        }
        
        $this->clearSelected();
        $this->dispatch('refresh-page');
    }

    /**
     * Clear all current selections
     */
    public function clearSelected()
    {
        if (property_exists($this, 'selectedIds')) {
            $this->selectedIds = [];
        }
        if (property_exists($this, 'selectPage')) {
            $this->selectPage = false;
        }
        $this->dispatch('reset-checkout-boxes');
    }
}
