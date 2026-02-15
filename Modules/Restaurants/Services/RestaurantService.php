<?php

namespace Modules\Restaurants\Services;

use App\Services\BaseService;
use Modules\Accommodations\Contracts\MealRepositoryInterface;
use Modules\Accommodations\Contracts\RoomRepositoryInterface;
use Modules\Accommodations\Contracts\SeasonRepositoryInterface;
use Modules\Accommodations\Contracts\SupplementRepositoryInterface;
use Modules\Restaurants\Contracts\RestaurantServiceInterface;
use Modules\Restaurants\Repositories\RestaurantRepository;

class RestaurantService extends BaseService implements RestaurantServiceInterface
{
    protected $seasonRepository;
    protected $roomRepository;
    protected $mealRepository;
    protected $supplementRepository;

    public function __construct(
        RoomRepositoryInterface $roomRepository,
        SeasonRepositoryInterface $seasonRepository,
        MealRepositoryInterface $mealRepository,
        SupplementRepositoryInterface $supplementRepository
    ) {
        parent::__construct();
        $this->roomRepository = $roomRepository;
        $this->seasonRepository = $seasonRepository;
        $this->mealRepository = $mealRepository;
        $this->supplementRepository = $supplementRepository;
    }

    public function getRepository()
    {
        return new RestaurantRepository();
    }

    public function getAllRestaurants($perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function getRestaurantById($id)
    {
        return $this->repository->findWithRelationships($id);
    }

    public function createRestaurant(array $data)
    {
        $seasons = $data['seasons'] ?? [];
        $rooms = $data['rooms'] ?? [];
        $meals = $data['meals'] ?? [];
        $supplements = $data['supplements'] ?? [];

        $restaurantData = collect($data)->except(['seasons', 'rooms', 'meals', 'supplements'])->toArray();
        $restaurant = $this->repository->create($restaurantData);

        if (!empty($seasons)) {
            $seasons = $this->seasonRepository->createMultiple($seasons, $restaurant->id, get_class($restaurant));
        }

        if (!empty($rooms)) {
            $rooms = $this->roomRepository->createMultiple($rooms, $restaurant->id, get_class($restaurant));
        }

        if (!empty($meals)) {
            $meals = $this->mealRepository->createMultiple($meals, $restaurant->id, get_class($restaurant));
        }

        if (!empty($supplements)) {
            $supplements = $this->supplementRepository->createMultiple($supplements, $restaurant->id, get_class($restaurant));
        }

        return $restaurant;
    }

    public function updateRestaurant($id, array $data)
    {
        $restaurant = $this->repository->find($id);
        if (!$restaurant) return null;

        $seasons = $data['seasons'] ?? [];
        $rooms = $data['rooms'] ?? [];
        $meals = $data['meals'] ?? [];
        $supplements = $data['supplements'] ?? [];

        $restaurantData = collect($data)->except(['seasons', 'rooms', 'meals', 'supplements'])->toArray();
        $restaurant = $this->repository->update($id, $restaurantData);

        if (!is_null($seasons)) {
            $this->seasonRepository->deleteByModel($restaurant->id, get_class($restaurant));
            if (!empty($seasons)) {
                $seasons = $this->seasonRepository->createMultiple($seasons, $restaurant->id, get_class($restaurant));
            }
        }

        if (!is_null($rooms)) {
            $this->roomRepository->deleteByModel($restaurant->id, get_class($restaurant));
            if (!empty($rooms)) {
                $rooms = $this->roomRepository->createMultiple($rooms, $restaurant->id, get_class($restaurant));
            }
        }

        if (!is_null($meals)) {
            $this->mealRepository->deleteByModel($restaurant->id, get_class($restaurant));
            if (!empty($meals)) {
                $meals = $this->mealRepository->createMultiple($meals, $restaurant->id, get_class($restaurant));
            }
        }

        if (!is_null($supplements)) {
            $this->supplementRepository->deleteByModel($restaurant->id, get_class($restaurant));
            if (!empty($supplements)) {
                $supplements = $this->supplementRepository->createMultiple($supplements, $restaurant->id, get_class($restaurant));
            }
        }

        return $restaurant;
    }

    public function deleteRestaurant($id)
    {
        $restaurant = $this->repository->find($id);
        if (!$restaurant) return false;

        $this->seasonRepository->deleteByModel($restaurant->id, get_class($restaurant));
        $this->roomRepository->deleteByModel($restaurant->id, get_class($restaurant));
        $this->mealRepository->deleteByModel($restaurant->id, get_class($restaurant));
        $this->supplementRepository->deleteByModel($restaurant->id, get_class($restaurant));

        return $this->repository->delete($id);
    }

    public function searchRestaurants($search, $perPage = 15)
    {
        return $this->repository->getAllWithSearch($search, $perPage);
    }
}
