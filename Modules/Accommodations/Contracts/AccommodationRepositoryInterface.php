<?php

namespace Modules\Accommodations\Contracts;

use App\Contracts\RepositoryInterface;

interface AccommodationRepositoryInterface extends RepositoryInterface
{
    // Get accommodation with all relationships
    public function findWithRelationships($id);

    // Get all accommodations with pagination and search
    public function getAllWithSearch($search = null, $perPage = 15);

    // Get accommodations by type
    public function getByType($typeId);

    // Get accommodations with seasons
    public function getWithSeasons($perPage = 15);
}
