<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\CustomColumns;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;

class Clients extends Component
{
    use WithPagination, CustomPagination, CustomColumns, HandlesCrudSafely;

    public $search = '';
    public $totalCount = '';
    public $message = [];
    public $filterClientType = '';
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

    public function render()
    {
        $query = Client::query()->with($this->relations);

        // Apply search
        if ($this->search) {
            $query->search($this->search);
        }

        // Apply client type filter
        if ($this->filterClientType) {
            $query->where('client_type', $this->filterClientType);
        }

        // Apply client status filter
        if ($this->filterClientStatus) {
            $query->where('client_status', $this->filterClientStatus);
        }

        return view('livewire.clients', [
            'data' => $query->paginate(getPaginate()),
            'totalCount' => Client::count(),
        ]);
    }
}
