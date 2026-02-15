<?php

namespace Modules\Accommodations\Contracts;

interface AccommodationServiceInterface
{
    public function getAllAccommodations($perPage = 15);

    public function getAccommodationById($id);

    public function createAccommodation(array $data);

    public function updateAccommodation($id, array $data);

    public function deleteAccommodation($id);

    public function searchAccommodations($search, $perPage = 15);
}
