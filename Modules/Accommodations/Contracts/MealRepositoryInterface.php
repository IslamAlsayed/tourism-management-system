<?php

namespace Modules\Accommodations\Contracts;

use App\Contracts\RepositoryInterface;

interface MealRepositoryInterface extends RepositoryInterface
{
    // Get meals for a specific model
    public function getByModel($modelId, $modelType);

    // Delete meals for a specific model
    public function deleteByModel($modelId, $modelType);

    // Create multiple meals
    public function createMultiple(array $mealsData, $modelId, $modelType);
}
