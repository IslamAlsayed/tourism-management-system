<?php

namespace Modules\Accommodations\Services;

use App\Services\BaseService;
use Modules\Accommodations\Contracts\AccommodationServiceInterface;
use Modules\Accommodations\Contracts\MealRepositoryInterface;
use Modules\Accommodations\Contracts\RoomRepositoryInterface;
use Modules\Accommodations\Contracts\SeasonRepositoryInterface;
use Modules\Accommodations\Contracts\SupplementRepositoryInterface;
use Modules\Accommodations\Repositories\AccommodationRepository;

class AccommodationService extends BaseService implements AccommodationServiceInterface
{
    protected $roomRepository;
    protected $seasonRepository;
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
        return new AccommodationRepository();
    }

    public function getAllAccommodations($perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function getAccommodationById($id)
    {
        return $this->repository->findWithRelationships($id);
    }

    public function createAccommodation(array $data)
    {
        // Extract nested data
        $seasons = $data['seasons'] ?? [];
        $rooms = $data['rooms'] ?? [];
        $meals = $data['meals'] ?? [];
        $supplements = $data['supplements'] ?? [];

        // Remove nested data from main array
        $accommodationData = collect($data)->except(['seasons', 'rooms', 'meals', 'supplements'])->toArray();

        // Create accommodation
        $accommodation = $this->repository->create($accommodationData);

        // Create related data
        if (!empty($seasons)) {
            $this->seasonRepository->createMultiple($seasons, $accommodation->id, get_class($accommodation));
        }

        if (!empty($rooms)) {
            $this->roomRepository->createMultiple($rooms, $accommodation->id);
        }

        if (!empty($meals)) {
            $this->mealRepository->createMultiple($meals, $accommodation->id, get_class($accommodation));
        }

        if (!empty($supplements)) {
            $this->supplementRepository->createMultiple($supplements, $accommodation->id, get_class($accommodation));
        }

        return $accommodation;
    }

    public function updateAccommodation($id, array $data)
    {
        $accommodation = $this->repository->find($id);
        if (!$accommodation) return null;

        // Extract nested data
        $seasons = $data['seasons'] ?? null;
        $rooms = $data['rooms'] ?? null;
        $meals = $data['meals'] ?? null;
        $supplements = $data['supplements'] ?? null;

        // Remove nested data from main array
        $accommodationData = collect($data)->except(['seasons', 'rooms', 'meals', 'supplements'])->toArray();

        // Update accommodation
        $accommodation = $this->repository->update($id, $accommodationData);

        // Update related data
        if (!is_null($seasons)) {
            $this->seasonRepository->deleteByModel($accommodation->id, get_class($accommodation));
            if (!empty($seasons)) {
                $this->seasonRepository->createMultiple($seasons, $accommodation->id, get_class($accommodation));
            }
        }

        if (!is_null($rooms)) {
            $this->roomRepository->deleteByModel($accommodation->id, get_class($accommodation));
            if (!empty($rooms)) {
                $this->roomRepository->createMultiple($rooms, $accommodation->id);
            }
        }

        if (!is_null($meals)) {
            $this->mealRepository->deleteByModel($accommodation->id, get_class($accommodation));
            if (!empty($meals)) {
                $this->mealRepository->createMultiple($meals, $accommodation->id, get_class($accommodation));
            }
        }

        if (!is_null($supplements)) {
            $this->supplementRepository->deleteByModel($accommodation->id, get_class($accommodation));
            if (!empty($supplements)) {
                $this->supplementRepository->createMultiple($supplements, $accommodation->id, get_class($accommodation));
            }
        }

        return $accommodation;
    }

    public function deleteAccommodation($id)
    {
        $accommodation = $this->repository->find($id);
        if (!$accommodation) return false;

        // Delete related data
        $this->seasonRepository->deleteByModel($accommodation->id, get_class($accommodation));
        $this->roomRepository->deleteByModel($accommodation->id, get_class($accommodation));
        $this->mealRepository->deleteByModel($accommodation->id, get_class($accommodation));
        $this->supplementRepository->deleteByModel($accommodation->id, get_class($accommodation));

        // Delete accommodation
        return $this->repository->delete($id);
    }

    public function searchAccommodations($search, $perPage = 15)
    {
        return $this->repository->getAllWithSearch($search, $perPage);
    }
}
