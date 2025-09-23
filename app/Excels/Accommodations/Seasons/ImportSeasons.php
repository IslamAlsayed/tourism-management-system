<?php

namespace App\Excels\Accommodations\Seasons;

use App\Models\Season;
use App\Models\Accommodation;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportSeasons implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Season())->getFillable();
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
                    if (in_array($column, ['season_from', 'season_to'])) {
                        if (!empty($row[$excelKey])) {
                            if (is_numeric($row[$excelKey])) {
                                $data[$column] = Date::excelToDateTimeObject($row[$excelKey])->format('Y-m-d');
                            } else {
                                $data[$column] = date('Y-m-d', strtotime($row[$excelKey]));
                            }
                        } else {
                            $data[$column] = null;
                        }
                    } else if ($column == 'accommodation_name') {
                        if ($accommodation = Accommodation::where('name', 'like', '%' . $row[$excelKey] . '%')->first()) {
                            $data['accommodation_id'] = $accommodation?->id ?? null;
                        } else {
                            $data['accommodation_id'] = null;
                        }
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
                // ImportDataToDBJob::dispatch(Season::class, $batchData);
                foreach ($batchData as $item) {
                    Season::create($item);
                }
                $this->rowCount += count($batchData);
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            // ImportDataToDBJob::dispatch(Season::class, $batchData);
            foreach ($batchData as $item) {
                Season::create($item);
            }
            $this->rowCount += count($batchData);
        }
    }
}