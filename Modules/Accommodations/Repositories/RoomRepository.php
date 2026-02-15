<?php

namespace Modules\Accommodations\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accommodations\Contracts\RoomRepositoryInterface;
use Modules\Accommodations\Entities\Accommodation;
use Modules\Accommodations\Entities\Room;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    public function getModel()
    {
        return Room::class;
    }

    public function getByAccommodation($accommodationId)
    {
        return Room::where('model_id', $accommodationId)
            ->where('model_type', Accommodation::class)
            ->get();
    }

    public function deleteByModel($accommodationId, $modelType)
    {
        return Room::where('model_id', $accommodationId)
            ->where('model_type', $modelType)
            ->delete();
    }

    public function createMultiple(array $roomsData, $accommodationId)
    {
        $createdRooms = [];

        foreach ($roomsData as $roomData) {
            $roomData['model_id'] = $accommodationId;
            $roomData['model_type'] = Accommodation::class;

            $createdRooms[] = Room::create($roomData);
        }

        return $createdRooms;
    }
}
