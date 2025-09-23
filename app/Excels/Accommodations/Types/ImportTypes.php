<?php

namespace App\Excels\Accommodations\Types;

use App\Models\Type;
use Illuminate\Support\Collection;
use App\Jobs\ImportUpdateDataToDBJob;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTypes implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Type())->getFillable();
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
                ImportUpdateDataToDBJob::dispatch(Type::class, $batchData);
                foreach ($batchData as $item) {
                    Type::updateOrCreate(['name' => $item['name']], $item);
                }
                $this->rowCount += count($batchData);
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            // ImportUpdateDataToDBJob::dispatch(Type::class, $batchData);
            foreach ($batchData as $item) {
                Type::updateOrCreate(['name' => $item['name']], $item);
            }
            $this->rowCount += count($batchData);
        }
    }
}