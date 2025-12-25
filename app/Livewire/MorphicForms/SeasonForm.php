<?php

namespace App\Livewire\MorphicForms;

use Livewire\Component;

class SeasonForm extends Component
{
    public $seasons = [];
    public $showForm = false;
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;

        if ($record) {
            if (method_exists($record, 'rooms') && $record->rooms()->exists()) {
                $existingSeasons = $record->rooms()
                    ->with('season')
                    ->get()
                    ->pluck('season')
                    ->unique('id')
                    ->map(function ($season) {
                        // ...existing code...
                    })->toArray();
            } elseif (method_exists($record, 'seasons') && $record->seasons()->exists()) {
                $existingSeasons = $record->seasons()
                    ->get()
                    ->unique('id')
                    ->map(function ($season) {
                        return [
                            'id' => uniqid(),
                            'season_id' => $season->id,
                            'name' => $season->name,
                            'name_ar' => $season->name_ar,
                            'season_from' => $season->season_from ? \Carbon\Carbon::parse($season->season_from)->format('Y-m-d') : '',
                            'season_to' => $season->season_to ? \Carbon\Carbon::parse($season->season_to)->format('Y-m-d') : '',
                            'is_active' => $season->is_active,
                            'description' => $season->description,
                        ];
                    })->toArray();
            }
            if (!empty($existingSeasons ?? [])) {
                $this->seasons = $existingSeasons;
            }
        }

        // Initialize with one empty season if none exist
        // if (empty($this->seasons)) {
        //     $this->seasons[] = [
        //         'id' => uniqid(),
        //         'name' => '',
        //         'name_ar' => '',
        //         'season_from' => '',
        //         'season_to' => '',
        //         'is_active' => 1,
        //         'description' => '',
        //     ];
        // }
    }

    public function addSeason()
    {
        $this->seasons[] = [
            'id' => uniqid(),
            'name' => '',
            'name_ar' => '',
            'season_from' => '',
            'season_to' => '',
            'is_active' => 1,
            'description' => '',
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
        return view('livewire.morphic-forms.season-form');
    }
}