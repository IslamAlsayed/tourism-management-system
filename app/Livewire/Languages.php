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
        return view('livewire.languages', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount ?: Language::count()]);
    }
}