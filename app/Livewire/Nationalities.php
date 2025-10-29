<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Nationality;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Nationalities extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;
    public $search = '';
    public $totalCount = '';
    public $message = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Nationality::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'nationality');
    }

    public function render()
    {
        return view('livewire.nationalities', [
            'data' => Nationality::query()->with($this->relations)->search($this->search)->paginate(getPaginate()),
            'totalCount' => Nationality::count(),
        ]);
    }
}