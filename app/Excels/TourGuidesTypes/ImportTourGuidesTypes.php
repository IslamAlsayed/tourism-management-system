<?php

namespace App\Excels\TourGuidesTypes;

use App\Models\TourGuideType;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTourGuidesTypes implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $allFillable = (new TourGuideType())->getFillable();
        $relations = method_exists((new TourGuideType()), 'getRelationshipNames') ? (new TourGuideType())->getRelationshipNames() : [];
        $fillable = array_filter($allFillable, fn($c) => !in_array($c, $relations));

        $headers = $rows->first()->toArray();

        $batchSize = 1000;
        $batchData = [];

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            $data = [];

            foreach ($fillable as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);

                    if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    } else {
                        $data[$column] = null;
                    }
                }
            }

            $batchData[] = $data;

            // Send batch job when full
            if (count($batchData) >= $batchSize) {
                // ImportDataToDBJob::dispatch(TourGuideType::class, $batchData);
                foreach ($batchData as $item) {
                    TourGuideType::updateOrCreate(['type' => $item['type']], $item);
                    $this->rowCount++;
                }
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            // ImportDataToDBJob::dispatch(TourGuideType::class, $batchData);
            foreach ($batchData as $item) {
                TourGuideType::updateOrCreate(['type' => $item['type']], $item);
                $this->rowCount++;
            }
        }
    }
}