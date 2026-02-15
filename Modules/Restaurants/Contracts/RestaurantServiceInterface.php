<?php

namespace Modules\Restaurants\Contracts;

interface RestaurantServiceInterface
{
    public function getAllRestaurants($perPage = 15);

    public function getRestaurantById($id);

    public function createRestaurant(array $data);

    public function updateRestaurant($id, array $data);

    public function deleteRestaurant($id);

    public function searchRestaurants($search, $perPage = 15);
}
