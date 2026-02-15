<?php

namespace Modules\Accommodations\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accommodations\Contracts\MealRepositoryInterface;
use Modules\Accommodations\Entities\Meal;

class MealRepository extends BaseRepository implements MealRepositoryInterface
{
    public function getModel()
    {
        return Meal::class;
    }

    public function getByModel($modelId, $modelType)
    {
        return Meal::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->get();
    }

    public function deleteByModel($modelId, $modelType)
    {
        return Meal::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->delete();
    }

    public function createMultiple(array $mealsData, $modelId, $modelType)
    {
        $createdMeals = [];

        foreach ($mealsData as $mealData) {
            $mealData['model_id'] = $modelId;
            $mealData['model_type'] = $modelType;

            $createdMeals[] = Meal::create($mealData);
        }

        return $createdMeals;
    }
}
