<?php

namespace App\Livewire\Accommodations;

use App\Models\Currency;
use Livewire\Component;

class RoomForm extends Component
{
    public $rooms = [];
    public $showForm = false;
    public $currencies = [];
    public $accommodation = null;

    protected $listeners = ['recordUpdated' => '$refresh'];

    public function mount($accommodation = null)
    {
        $this->accommodation = $accommodation;
        $this->currencies = Currency::pluck('code', 'id')->toArray();
        
        // If editing and has existing rooms, load them
        if ($accommodation && $accommodation->roomRates()->exists()) {
            $existingRooms = $accommodation->roomRates()
                ->with('room')
                ->get()
                ->groupBy('room_id')
                ->map(function($rates, $roomId) {
                    $firstRate = $rates->first();
                    $room = $firstRate->room;
                    return [
                        'id' => uniqid(),
                        'room_id' => $room->id,
                        'name' => $room->name,
                        'name_ar' => $room->name_ar,
                        'max_occupancy' => $room->max_occupancy,
                        'currency_id' => $firstRate->currency_id,
                        'price_per_person_double' => $firstRate->price_per_person_double,
                        'single_room_supplement' => $firstRate->single_room_supplement,
                        'triple_room_discount' => $firstRate->triple_room_discount,
                        'third_person_price' => $firstRate->third_person_price,
                        'extra_bed_price' => $firstRate->extra_bed_price,
                        'sea_view_supplement' => $firstRate->sea_view_supplement,
                        'occupancy_details' => $room->occupancy_details,
                        'notes' => $room->notes,
                        'is_active' => $room->is_active,
                    ];
                })->values()->toArray();
            
            if (!empty($existingRooms)) {
                $this->rooms = $existingRooms;
            }
        }
        
        // Initialize with one empty room if none exist
        if (empty($this->rooms)) {
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
                'notes' => '',
            ];
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
            'notes' => '',
        ];
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
        return view('livewire.accommodations.room-form');
    }
}