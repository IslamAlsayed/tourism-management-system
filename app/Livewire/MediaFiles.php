<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MediaFile;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class MediaFiles extends Component
{
    use WithPagination, CustomColumns, WithSorting, CustomPagination, HandlesCrudSafely;

    public $search = '';
    public $filterType = '';
    public $filterCollection = '';
    public $filterActive = '';
    public $selectedIds = [];
    public $selectAll = false;
    public $view = 'grid'; // or table
    public $gridLength = 5;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(MediaFile::class);

        // display view mode [ grid | table ]
        $this->view = session('media_files_view', 'grid');
        $this->gridLength = session('grid_length_media_files', 5);
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterCollection()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterCollection', 'filterActive']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function updatedSelectAll($value)
    {
        $this->selectedIds = $value ? $this->getQuery()->pluck('id')->toArray() : [];
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'media_file');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $files = MediaFile::whereIn('id', $this->selectedIds)->get();

        foreach ($files as $file) {
            $file->deleteFile();
            $file->delete();
        }

        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('main.messages.type_deleted_count', ['type' => __('main.files'), 'count' => count($files)]),
        ]);
        $this->dispatch('refreshComponent');
    }

    private function getQuery()
    {
        $query = MediaFile::query()->with('uploader');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('file_name', 'like', '%' . $this->search . '%')
                    ->orWhere('collection_name', 'like', '%' . $this->search . '%')
                    ->orWhere('alt_text', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by type
        if ($this->filterType) {
            $query->where('file_type', $this->filterType);
        }

        // Filter by collection
        if ($this->filterCollection) {
            $query->where('collection_name', $this->filterCollection);
        }

        // Filter by active status
        if ($this->filterActive !== '') {
            $query->where('is_active', $this->filterActive);
        }

        // Sorting
        $sortField = $this->sortField ?: 'created_at';
        $sortDirection = $this->sortDirection ?: 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query;
    }

    public function toggleView()
    {
        $this->view = $this->view === 'table' ? 'grid' : 'table';
        session(['media_files_view' => $this->view]);
    }

    public function toggleGridLength($length, $models)
    {
        session(['grid_length_' . $models => $length ?? 5]);
    }

    public function render()
    {
        $mediaFiles = $this->paginate != 'all' ? $this->getQuery()->paginate(getPaginate()) : $this->getQuery()->get();
        $collections = MediaFile::select('collection_name')->whereNotNull('collection_name')->distinct()->pluck('collection_name');
        return view('livewire.media-files', ['data' => $mediaFiles, 'collections' => $collections]);
    }
}