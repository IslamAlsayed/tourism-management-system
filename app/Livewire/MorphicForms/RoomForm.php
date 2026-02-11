<?php

namespace App\Livewire\MorphicForms;

use Modules\Localization\Entities\Currency;
use Livewire\Component;

class RoomForm extends Component
{
    public $rooms = [];
    public $showForm = false;
    public $currencies = [];
    public $record = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($record = null)
    {
        $this->record = $record;
        $this->currencies = Currency::pluck('code', 'id')->toArray();

        if ($record) {
            if (method_exists($record, 'rooms') && $record->rooms()->exists()) {
                $existingRooms = $record->rooms()
                    ->get()
                    ->unique('id')
                    ->map(function ($room) {
                        return [
                            'id' => uniqid(),
                            'room_id' => $room->id,
                            'name' => $room->name,
                            'name_ar' => $room->name_ar,
                            'max_occupancy' => $room->max_occupancy,
                            'currency_id' => $room->currency_id,
                            'price_per_person_double' => $room->price_per_person_double,
                            'single_room_supplement' => $room->single_room_supplement,
                            'triple_room_discount' => $room->triple_room_discount,
                            'third_person_price' => $room->third_person_price,
                            'extra_bed_price' => $room->extra_bed_price,
                            'sea_view_supplement' => $room->sea_view_supplement,
                            'occupancy_details' => $room->occupancy_details,
                            'is_active' => $room->is_active,
                            'description' => $room->description,
                        ];
                    })->toArray();
            }
            if (!empty($existingRooms ?? [])) {
                $this->rooms = $existingRooms;
            }
        }
    }

    public function addRoom()
    {
        $this->rooms[] = [
            'id' => uniqid(),
            'name' => '',
            'name_ar' => '',
            'max_occupancy' => '',
            'occupancy_details' => '',
            'currency_id' => '',
            'price_per_person_double' => '',
            'single_room_supplement' => '',
            'triple_room_discount' => '',
            'third_person_price' => '',
            'extra_bed_price' => '',
            'sea_view_supplement' => '',
            'is_active' => 1,
            'description' => '',
        ];
        $this->dispatch('record-added');
    }

    public function removeRoom($index)
    {
        if (count($this->rooms) > 1) {
            unset($this->rooms[$index]);
            $this->rooms = array_values($this->rooms);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.morphic-forms.room-form');
    }
}
