<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Language;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Languages extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
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
        return view('livewire.languages', [
            'data' => Language::query()->with($this->relations)->orderBy('name')->search($this->search)->paginate(getPaginate()),
            'totalCount' => Language::count(),
        ]);
    }
}