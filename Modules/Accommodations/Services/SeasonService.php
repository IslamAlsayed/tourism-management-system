<?php

namespace Modules\Accommodations\Services;

use App\Services\BaseService;
use Modules\Accommodations\Repositories\SeasonRepository;

class SeasonService extends BaseService
{
    public function getRepository()
    {
        return new SeasonRepository();
    }

    // Get seasons for a model
    public function getByModel($modelId, $modelType)
    {
        return $this->repository->getByModel($modelId, $modelType);
    }

    // Create multiple seasons for a model@return mixed
    public function createMultiple(array $seasonsData, $modelId, $modelType)
    {
        return $this->repository->createMultiple($seasonsData, $modelId, $modelType);
    }

    // Delete seasons for a model
    public function deleteByModel($modelId, $modelType)
    {
        return $this->repository->deleteByModel($modelId, $modelType);
    }
}
