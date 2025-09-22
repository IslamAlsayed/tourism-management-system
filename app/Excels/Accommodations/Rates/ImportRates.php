<?php

namespace App\Excels\Accommodations\Rates;

use App\Models\Rate;
use App\Models\Currency;
use App\Models\Season;
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

            Rate::create($data);
            $this->rowCount++;
        }
    }
}