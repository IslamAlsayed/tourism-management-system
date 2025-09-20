<?php

namespace App\Excels\Accommodations\Seasons;

use App\Models\AccommodationSeason;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportSeasons implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new AccommodationSeason())->getFillable();
        $headers = $rows->first()->toArray();

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            $data = [];

            foreach ($fillable as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);
                    if ($column == 'season_from' && isset($row[$excelKey])) {
                        $data['season_from'] = date('Y-m-d', strtotime($row[$excelKey]));
                    } else if ($column == 'season_to' && isset($row[$excelKey])) {
                        $data['season_to'] = date('Y-m-d', strtotime($row[$excelKey]));
                    } else if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    } else {
                        $data[$column] = null;
                    }
                }
            }

            AccommodationSeason::create($data);
            $this->rowCount++;
        }
    }
}