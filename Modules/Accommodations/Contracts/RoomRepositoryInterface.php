<?php

namespace Modules\Accommodations\Contracts;

use App\Contracts\RepositoryInterface;

interface RoomRepositoryInterface extends RepositoryInterface
{
    // Get rooms by accommodation
    public function getByAccommodation($accommodationId);

    // Delete rooms for accommodation
    public function deleteByModel($accommodationId, $modelType);

    // Create multiple rooms at once
    public function createMultiple(array $roomsData, $accommodationId);
}
