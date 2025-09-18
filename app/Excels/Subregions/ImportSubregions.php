<?php

namespace App\Excels\Subregions;

use App\Models\Subregion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportSubregions implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Subregion())->getFillable();
        $headers = $rows->first()->toArray();

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

            Subregion::updateOrCreate(['name' => $data['name']], $data);
            $this->rowCount++;
        }
    }
}