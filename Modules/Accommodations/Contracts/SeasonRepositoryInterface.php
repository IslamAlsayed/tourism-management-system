<?php

namespace Modules\Accommodations\Contracts;

use App\Contracts\RepositoryInterface;

interface SeasonRepositoryInterface extends RepositoryInterface
{
    // Get seasons for a specific model
    public function getByModel($modelId, $modelType);

    // Delete seasons for a specific model
    public function deleteByModel($modelId, $modelType);

    // Create multiple seasons
    public function createMultiple(array $seasonsData, $modelId, $modelType);
}
