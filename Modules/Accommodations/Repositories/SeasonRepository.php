<?php

namespace Modules\Accommodations\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accommodations\Contracts\SeasonRepositoryInterface;
use Modules\Accommodations\Entities\Season;

class SeasonRepository extends BaseRepository implements SeasonRepositoryInterface
{
    public function getModel()
    {
        return Season::class;
    }

    public function getByModel($modelId, $modelType)
    {
        return Season::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->get();
    }

    public function deleteByModel($modelId, $modelType)
    {
        return Season::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->delete();
    }

    public function createMultiple(array $seasonsData, $modelId, $modelType)
    {
        $createdSeasons = [];

        foreach ($seasonsData as $seasonData) {
            $seasonData['model_id'] = $modelId;
            $seasonData['model_type'] = $modelType;

            $createdSeasons[] = Season::create($seasonData);
        }

        return $createdSeasons;
    }
}
