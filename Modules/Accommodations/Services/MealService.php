<?php

namespace Modules\Accommodations\Services;

use App\Services\BaseService;
use Modules\Accommodations\Repositories\MealRepository;

class MealService extends BaseService
{
    public function getRepository()
    {
        return new MealRepository();
    }

    // Get meals for a model
    public function getByModel($modelId, $modelType)
    {
        return $this->repository->getByModel($modelId, $modelType);
    }

    // Create multiple meals for a model
    public function createMultiple(array $mealsData, $modelId, $modelType)
    {
        return $this->repository->createMultiple($mealsData, $modelId, $modelType);
    }

    // Delete meals for a model
    public function deleteByModel($modelId, $modelType)
    {
        return $this->repository->deleteByModel($modelId, $modelType);
    }
}
