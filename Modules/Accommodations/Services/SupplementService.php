<?php

namespace Modules\Accommodations\Services;

use App\Services\BaseService;
use Modules\Accommodations\Repositories\SupplementRepository;

class SupplementService extends BaseService
{
    public function getRepository()
    {
        return new SupplementRepository();
    }

    // Get supplements for a model
    public function getByModel($modelId, $modelType)
    {
        return $this->repository->getByModel($modelId, $modelType);
    }

    // Create multiple supplements for a model
    public function createMultiple(array $supplementsData, $modelId, $modelType)
    {
        return $this->repository->createMultiple($supplementsData, $modelId, $modelType);
    }

    // Delete supplements for a model
    public function deleteByModel($modelId, $modelType)
    {
        return $this->repository->deleteByModel($modelId, $modelType);
    }
}
