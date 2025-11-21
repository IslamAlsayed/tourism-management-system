<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Language;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Languages extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $view = 'grid'; // or table
    public $gridLength = 5;

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
        $this->safeDestroy($id, 'language');
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
        return view('livewire.languages', ['data' => $data, 'totalCount' => $this->totalCount ?: Language::count()]);
    }
}