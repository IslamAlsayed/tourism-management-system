<?php

namespace App\Livewire\Nationalities;

use App\Models\Nationality;
use Livewire\Component;
use App\Models\Subregion;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $search = '';
    public $totalCount = '';
    public $perPage = 50;
    public array $columns = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->resetPage();
        $this->columns = ['id', 'name', 'name_ar', 'is_active', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Nationality::count();

        $data = Nationality::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate($this->perPage);

        return view('livewire.nationalities.table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }

    // Toggle active status for a region
    public function toggleActive($id)
    {
        $nationality = Nationality::find($id);
        if ($nationality) {
            $nationality->is_active = !$nationality->is_active;
            $nationality->save();
            session()->flash('message', __('تم تحديث حالة الجنسية بنجاح.'));
        }
    }
}