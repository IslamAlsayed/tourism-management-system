<?php

namespace App\Excels\Accommodations\Rates;

use App\Models\Rate;
use App\Models\Season;
use App\Models\Currency;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportRates implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Rate())->getFillable();
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

                    if ($column == 'currency_id') {
                        $data['currency_id'] = Currency::where('code', 'like', '%' . $row[$excelKey] . '%')->first()?->id ?? null;
                    } else if ($column == 'season_id') {
                        $data['season_id'] = Season::where('season_from', 'like', '%' . date('Y-m-d', strtotime($row[$excelKey])) . '%')->orWhere('season_to', 'like', '%' . date('Y-m-d', strtotime($row[$excelKey])) . '%')->first()?->id ?? null;
                    } else if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    } else {
                        $data[$column] = null;
                    }
                }
            }

            $batchData[] = $data;

            // Send batch job when full
            if (count($batchData) >= $batchSize) {
                ImportDataToDBJob::dispatch(Rate::class, $batchData);
                $this->rowCount += count($batchData);
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            ImportDataToDBJob::dispatch(Rate::class, $batchData);
            $this->rowCount += count($batchData);
        }
    }
}