<?php

namespace App\Excels\Cities;

use App\Models\City;
use App\Models\State;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCities implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new City())->getFillable();
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
                    if ($column == 'state_id') {
                        $state_id = $row[$excelKey];
                        $state = State::find($state_id);
                        if (!$state) {
                            $data['state_id'] = null;
                        } else {
                            $data['state_id'] = $state_id;
                        }
                    } else if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    }
                }
            }

            $batchData[] = $data;

            // Send batch job when full
            if (count($batchData) >= $batchSize) {
                ImportDataToDBJob::dispatch(City::class, $batchData);
                $this->rowCount += count($batchData);
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            ImportDataToDBJob::dispatch(City::class, $batchData);
            $this->rowCount += count($batchData);
        }
    }
}