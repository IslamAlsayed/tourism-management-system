<?php

namespace Modules\Accommodations\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accommodations\Contracts\AccommodationRepositoryInterface;
use Modules\Accommodations\Entities\Accommodation;

class AccommodationRepository extends BaseRepository implements AccommodationRepositoryInterface
{
    public function getModel()
    {
        return Accommodation::class;
    }

    public function findWithRelationships($id)
    {
        $accommodation = Accommodation::find($id);

        if ($accommodation) {
            // Load all relationships
            return $accommodation->load('type', 'seasons', 'rooms', 'meals', 'supplements');
        }

        return null;
    }

    public function getAllWithSearch($search = null, $perPage = 15)
    {
        $query = Accommodation::query()->with('type', 'seasons', 'rooms', 'media');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function getByType($typeId)
    {
        return Accommodation::where('type_id', $typeId)->with('type', 'rooms', 'seasons')->get();
    }

    public function getWithSeasons($perPage = 15)
    {
        return Accommodation::with('seasons', 'type')->paginate($perPage);
    }
}
