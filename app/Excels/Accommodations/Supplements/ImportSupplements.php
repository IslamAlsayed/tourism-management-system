<?php

namespace App\Excels\Accommodations\Supplements;

use App\Models\Supplement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportSupplements implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Supplement())->getFillable();
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

            Supplement::create($data);
            $this->rowCount++;
        }
    }
}