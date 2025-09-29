<?php

namespace App\Excels\TourGuidesReviews;

use App\Models\TourGuideReview;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTourGuidesReviews implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $allFillable = (new TourGuideReview())->getFillable();
        $relations = method_exists((new TourGuideReview()), 'getRelationshipNames') ? (new TourGuideReview())->getRelationshipNames() : [];
        $fillable = array_filter($allFillable, fn($c) => !in_array($c, $relations));

        $headers = $rows->first()->toArray();

        $batchSize = 1000;
        $batchData = [];

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            // Check if row is empty
            if ($row->filter()->isEmpty()) {
                continue;
            }

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
                // ImportDataToDBJob::dispatch(TourGuideReview::class, $batchData);
                foreach ($batchData as $item) {
                    TourGuideReview::create($item);
                    $this->rowCount++;
                }
                $batchData = [];
            }
        }

        // Send remaining data
        array_splice($batchData, -1);
        if (count($batchData) > 0) {
            // ImportDataToDBJob::dispatch(TourGuideReview::class, $batchData);
            foreach ($batchData as $item) {
                TourGuideReview::create($item);
                $this->rowCount++;
            }
        }
    }
}