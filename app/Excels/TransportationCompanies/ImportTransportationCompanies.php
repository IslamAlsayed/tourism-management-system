<?php

namespace App\Excels\TransportationCompanies;

use App\Models\TransportationCompany;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTransportationCompanies implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $allFillable = (new TransportationCompany())->getFillable();
        $relations = method_exists((new TransportationCompany()), 'getRelationshipNames') ? (new TransportationCompany())->getRelationshipNames() : [];
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
                // ImportDataToDBJob::dispatch(TransportationCompany::class, $batchData);
                foreach ($batchData as $item) {
                    TransportationCompany::create($item);
                    $this->rowCount++;
                }
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            // ImportDataToDBJob::dispatch(TransportationCompany::class, $batchData);
            foreach ($batchData as $item) {
                TransportationCompany::create($item);
                $this->rowCount++;
            }
        }
    }
}