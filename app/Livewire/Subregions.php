<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Subregions extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Subregion::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'subregion');
    }

    public function render()
    {
        return view('livewire.subregions', [
            'data' => Subregion::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => Subregion::count(),
        ]);
    }
}