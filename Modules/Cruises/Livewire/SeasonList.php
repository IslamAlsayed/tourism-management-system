<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Cruises\Entities\CruiseSeason;

class SeasonList extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($uuid)
    {
        $season = CruiseSeason::where('uuid', $uuid)->firstOrFail();
        $season->delete();
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('main.deleted_successfully'),
        ]);
    }

    public function render()
    {
        $seasons = CruiseSeason::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('name_ar', 'like', '%' . $this->search . '%');
            })
            ->withCount('prices')
            ->latest()
            ->paginate(10);

        return view('cruises::livewire.season-list', [
            'seasons' => $seasons
        ]);
    }
}
