<?php

namespace App\Livewire;

use App\Models\UiIcon;
use Livewire\Component;
use Livewire\WithPagination;

class UiIconsManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 30;
    
    // View state
    public $viewMode = 'grid'; // 'grid' or 'table'
    
    // Icon state for editing
    public $editingIconId = null;
    public $editingIcon = [
        'field_key' => '',
        'icon_class' => '',
        'bg_color_light' => '#ffffff',
        'bg_color_dark' => '#1e1e2d',
        'border_color_light' => '#e4e6ef',
        'border_color_dark' => '#2b2b40',
        'shape' => 'rounded-sm',
        'weight' => 'regular',
        'size' => 'base',
        'is_active' => true,
    ];

    // Smart Bulk Assignment
    public $selectedIds = [];
    public $selectAll = false;

    // Bulk action state
    public $bulkState = [
        'bg_color_light' => null,
        'bg_color_dark' => null,
        'shape' => null,
        'size' => null,
        'weight' => null,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'viewMode' => ['except' => 'grid']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Select all on current page
            $this->selectedIds = $this->getFilteredIconsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function resetSelection()
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    public function editIcon($id)
    {
        $icon = UiIcon::findOrFail($id);
        $this->editingIconId = $id;
        $this->editingIcon = [
            'field_key' => $icon->field_key,
            'icon_class' => $icon->icon_class,
            'bg_color_light' => $icon->bg_color_light ?? '#ffffff',
            'bg_color_dark' => $icon->bg_color_dark ?? '#1e1e2d',
            'border_color_light' => $icon->border_color_light ?? '#e4e6ef',
            'border_color_dark' => $icon->border_color_dark ?? '#2b2b40',
            'shape' => $icon->shape ?? 'rounded-sm',
            'weight' => $icon->weight ?? 'regular',
            'size' => $icon->size ?? 'base',
            'is_active' => $icon->is_active,
        ];
        
        $this->dispatch('open-edit-modal');
    }

    public function saveIcon()
    {
        $this->validate([
            'editingIcon.field_key' => 'required|string|max:255',
            'editingIcon.icon_class' => 'required|string|max:255',
        ]);

        if ($this->editingIconId) {
            $icon = UiIcon::findOrFail($this->editingIconId);
            $icon->update($this->editingIcon);
            $this->dispatch('notify', ['type' => 'success', 'message' => __('Icon updated successfully.')]);
        }
        
        $this->dispatch('close-edit-modal');
        $this->editingIconId = null;
    }

    public function toggleActive($id)
    {
        $icon = UiIcon::findOrFail($id);
        $icon->is_active = !$icon->is_active;
        $icon->save();
        
        $this->dispatch('notify', [
            'type' => 'success', 
            'message' => $icon->is_active ? __('Icon activated.') : __('Icon deactivated.')
        ]);
    }

    public function applyBulkChanges()
    {
        if (empty($this->selectedIds)) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => __('No icons selected.')]);
            return;
        }

        $updates = [];
        foreach ($this->bulkState as $key => $value) {
            if ($value !== null && $value !== '') {
                $updates[$key] = $value;
            }
        }

        if (empty($updates)) {
            $this->dispatch('notify', ['type' => 'info', 'message' => __('No specific changes selected for bulk update.')]);
            return;
        }

        UiIcon::whereIn('id', $this->selectedIds)->update($updates);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Bulk changes applied successfully to ' . count($this->selectedIds) . ' icons.')]);
        $this->dispatch('close-bulk-modal');
        $this->resetSelection();
    }

    public function prepareBulkEdit()
    {
        if (empty($this->selectedIds)) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => __('Please select at least one icon first.')]);
            return;
        }
        $this->dispatch('open-bulk-modal');
    }

    public function addIcon()
    {
        $this->editingIconId = null;
        $this->editingIcon = [
            'field_key' => '',
            'icon_class' => 'fas fa-star',
            'bg_color_light' => '#ffffff',
            'bg_color_dark' => '#1e1e2d',
            'border_color_light' => '#e4e6ef',
            'border_color_dark' => '#2b2b40',
            'shape' => 'rounded-sm',
            'weight' => 'regular',
            'size' => 'base',
            'is_active' => true,
        ];
        $this->dispatch('open-edit-modal');
    }

    public function saveNewIcon()
    {
        $this->validate([
            'editingIcon.field_key' => 'required|string|max:255|unique:ui_icons,field_key',
            'editingIcon.icon_class' => 'required|string|max:255',
        ]);

        UiIcon::create($this->editingIcon);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => __('New icon created successfully.')]);
        $this->dispatch('close-edit-modal');
    }

    protected function getFilteredIconsQuery()
    {
        return UiIcon::query()
            ->when($this->search, function ($query) {
                $query->where('field_key', 'like', '%' . $this->search . '%')
                      ->orWhere('icon_class', 'like', '%' . $this->search . '%');
            })
            ->orderBy('field_key');
    }

    protected function getFilteredIcons()
    {
        return $this->getFilteredIconsQuery()->get();
    }

    public function render()
    {
        $iconsQuery = $this->getFilteredIcons();
        
        // Group by the first part of the field_key (e.g., 'sidebar', 'action', 'module')
        $groupedIcons = $iconsQuery->groupBy(function($icon) {
            $parts = explode('_', $icon->field_key);
            // Ignore small prefixes if needed, but usually the first part is the category
            return count($parts) > 1 ? ucfirst($parts[0]) : 'General';
        });

        return view('livewire.ui-icons-manager', [
            'groupedIcons' => $groupedIcons,
        ])->layout('layouts.master');
    }
}
