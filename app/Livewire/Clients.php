<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\WithSorting;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Clients extends Component
{
    use WithPagination, CustomPagination, CustomColumns, WithSorting, HandlesCrudSafely;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterClientGender = '';
    public $filterClientStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterClientType()
    {
        $this->resetPage();
    }

    public function updatingFilterClientStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
        $this->mountWithCustomColumns(Client::class);
        $this->resetPage();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, 'client');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterClientGender', 'filterClientStatus']);
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function render()
    {
        $query = Client::query();
        $query->searchWithRelations(search: $this->search, selectedColumns: $this->columns, availableRelations: $this->relations);
        if ($this->filterClientGender) {
            $query->where('gender', $this->filterClientGender);
        }
        if ($this->filterClientStatus) {
            $query->where('client_status', $this->filterClientStatus);
        }
        $data = $this->paginate != 'all' ? $query->paginate(getPaginate()) : $query->get();
        $this->applySorting($query);
        return view('livewire.clients', ['data' => $data, 'totalCount' => $this->totalCount ?: Client::count()]);
    }
}