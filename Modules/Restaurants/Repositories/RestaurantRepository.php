<?php

namespace Modules\Restaurants\Repositories;

use App\Repositories\BaseRepository;
use Modules\Restaurants\Contracts\RestaurantRepositoryInterface;
use Modules\Restaurants\Entities\Restaurant;

class RestaurantRepository extends BaseRepository implements RestaurantRepositoryInterface
{
    public function getModel()
    {
        return Restaurant::class;
    }

    public function findWithRelationships($id)
    {
        $restaurant = Restaurant::find($id);

        if ($restaurant) {
            // Load all relationships
            return $restaurant->load('type', 'seasons', 'meals', 'supplements');
        }

        return null;
    }

    public function getAllWithSearch($search = null, $perPage = 15)
    {
        $query = Restaurant::query()->with('type', 'seasons', 'rooms', 'media');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function getByType($typeId)
    {
        return Restaurant::where('type_id', $typeId)->with('type', 'rooms', 'seasons')->get();
    }

    public function getWithSeasons($perPage = 15)
    {
        return Restaurant::with('seasons', 'type')->paginate($perPage);
    }
}
