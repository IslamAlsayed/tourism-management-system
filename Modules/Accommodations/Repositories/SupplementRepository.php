<?php

namespace Modules\Accommodations\Repositories;

use App\Repositories\BaseRepository;
use Modules\Accommodations\Contracts\SupplementRepositoryInterface;
use Modules\Accommodations\Entities\Supplement;

class SupplementRepository extends BaseRepository implements SupplementRepositoryInterface
{
    public function getModel()
    {
        return Supplement::class;
    }

    public function getByModel($modelId, $modelType)
    {
        return Supplement::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->get();
    }

    public function deleteByModel($modelId, $modelType)
    {
        return Supplement::where('model_id', $modelId)
            ->where('model_type', $modelType)
            ->delete();
    }

    public function createMultiple(array $supplementsData, $modelId, $modelType)
    {
        $createdSupplements = [];

        foreach ($supplementsData as $supplementData) {
            $supplementData['model_id'] = $modelId;
            $supplementData['model_type'] = $modelType;

            $createdSupplements[] = Supplement::create($supplementData);
        }

        return $createdSupplements;
    }
}
