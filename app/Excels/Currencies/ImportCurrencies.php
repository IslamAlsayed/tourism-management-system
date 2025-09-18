<?php

namespace App\Excels\Currencies;

use App\Models\Currency;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCurrencies implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Currency())->getFillable();
        $headers = $rows->first()->toArray();

        $currencyData = [];

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

            $currencyData[] = $data;

            if (count($currencyData) >= 1000) {
                Currency::insert($currencyData);
                $this->rowCount += count($currencyData);
                $currencyData = [];
            }
        }

        if (count($currencyData) > 0) {
            Currency::insert($currencyData);
            $this->rowCount += count($currencyData);
        }
    }
}