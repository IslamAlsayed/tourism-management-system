<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemLanguage;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class SystemLanguages extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $view = 'grid';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(SystemLanguage::class);
        $this->view = session('languages_view', 'grid');
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'system_language');
    }

    public function toggleView()
    {
        $this->view = $this->view === 'table' ? 'grid' : 'table';
        session(['languages_view' => $this->view]);
    }

    public function render()
    {
        $query = SystemLanguage::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        $this->applySorting($query);
        return view('livewire.system-languages', ['data' => $query->paginate(getPaginate()), 'totalCount' => $this->totalCount ?: SystemLanguage::count()]);
    }
}