<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use App\Traits\CustomPagination;
use App\Traits\HandlesCrudSafely;
use Illuminate\Support\Facades\Cache;

class Permissions extends Component
{
    use WithPagination, CustomPagination, HandlesCrudSafely;

    public $search = '';
    protected $listeners = ['recordUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->mountWithCustomPagination();
    }

    public function destroy($id)
    {
        $this->safeDestroy($id, Permission::class, 'permission');
    }

    protected function getCacheKey()
    {
        return 'permissions_list:' . md5(json_encode([
            'search' => $this->search,
            'page' => request()->get('page', 1),
            'perPage' => getPaginate(),
        ]));
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();
        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $query = Permission::query();
            if ($this->search) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }
            return $query->paginate(getPaginate());
        });
        
        return view('livewire.permissions', ['data' => $data]);
    }
}
