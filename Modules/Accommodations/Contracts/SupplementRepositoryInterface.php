<?php

namespace Modules\Accommodations\Contracts;

use App\Contracts\RepositoryInterface;

interface SupplementRepositoryInterface extends RepositoryInterface
{
    // Get supplements for a specific model
    public function getByModel($modelId, $modelType);

    // Delete supplements for a specific model
    public function deleteByModel($modelId, $modelType);

    // Create multiple supplements
    public function createMultiple(array $supplementsData, $modelId, $modelType);
}
