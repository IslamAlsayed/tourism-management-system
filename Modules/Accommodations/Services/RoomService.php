<?php

namespace Modules\Accommodations\Services;

use App\Services\BaseService;
use Modules\Accommodations\Repositories\RoomRepository;

class RoomService extends BaseService
{
    public function getRepository()
    {
        return new RoomRepository();
    }

    // Get rooms for accommodation
    public function getRoomsForAccommodation($accommodationId)
    {
        return $this->repository->getByAccommodation($accommodationId);
    }

    // Create multiple rooms for accommodation
    public function createMultipleForAccommodation(array $roomsData, $accommodationId)
    {
        return $this->repository->createMultiple($roomsData, $accommodationId);
    }

    // Delete all rooms for accommodation
    public function deleteForAccommodation($accommodationId)
    {
        return $this->repository->deleteByAccommodation($accommodationId);
    }
}
