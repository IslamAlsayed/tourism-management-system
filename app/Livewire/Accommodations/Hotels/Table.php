<?php

namespace App\Livewire\Accommodations\Hotels;

use App\Models\Hotel;
use Livewire\Component;
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
        $this->columns = ['id', 'name', 'name_ar', 'created_at', 'updated_at'];
    }

    public function resetFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->totalCount = Hotel::count();

        $data = Hotel::query()
            ->when($this->search, function ($query) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            })
            ->paginate($this->perPage);

        return view('livewire.accommodations.hotels.table', [
            'data' => $data,
            'totalCount' => $this->totalCount,
        ]);
    }

    // Toggle active status for a region
    public function toggleActive($id)
    {
        $hotel = Hotel::find($id);
        if ($hotel) {
            $hotel->is_active = !$hotel->is_active;
            $hotel->save();
            session()->flash('message', __('تم تحديث حالة العملة بنجاح.'));
        }
    }
}