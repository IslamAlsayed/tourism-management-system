<?php

namespace Modules\Accommodations\Livewire\Accommodations;

use Livewire\Component;

class SeasonForm extends Component
{
    public $seasons = [];
    public $showForm = false;
    public $accommodation = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($accommodation = null)
    {
        $this->accommodation = $accommodation;
        // dd($this->accommodation?->toArray());

        // If editing and has existing seasons, load them
        if ($accommodation && $accommodation->rooms()->exists()) {
            $existingSeasons = $accommodation->rooms()
                ->with('season')
                ->get()
                ->pluck('season')
                ->unique('id')
                ->map(function ($season) {
                    return [
                        'id' => uniqid(),
                        'season_id' => $season->id,
                        'name' => $season->name,
                        'name_ar' => $season->name_ar,
                        'season_from' => $season->season_from,
                        'season_to' => $season->season_to,
                        'description' => $season->description,
                        'is_active' => $season->is_active,
                    ];
                })->toArray();

            if (!empty($existingSeasons)) {
                $this->seasons = $existingSeasons;
            }
        }

        // Initialize with one empty season if none exist
        if (empty($this->seasons)) {
            $this->seasons[] = [
                'id' => uniqid(),
                'name' => '',
                'name_ar' => '',
                'season_from' => '',
                'season_to' => '',
                'description' => '',
                'is_active' => 1,
            ];
        }
    }

    public function addSeason()
    {
        $this->seasons[] = [
            'id' => uniqid(),
            'name' => '',
            'name_ar' => '',
            'season_from' => '',
            'season_to' => '',
            'description' => '',
            'is_active' => 1,
        ];
    }

    public function removeSeason($index)
    {
        if (count($this->seasons) > 1) {
            unset($this->seasons[$index]);
            $this->seasons = array_values($this->seasons);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('accommodations::livewire.accommodations.season-form');
    }
}
