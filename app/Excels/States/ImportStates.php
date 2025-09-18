<?php

namespace App\Excels\States;

use App\Models\State;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportStates implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new State())->getFillable();
        $headers = $rows->first()->toArray();

        $stateData = [];

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

            $stateData[] = $data;

            if (count($stateData) >= 1000) {
                State::insert($stateData);
                $this->rowCount += count($stateData);
                $stateData = [];
            }
        }

        if (count($stateData) > 0) {
            State::insert($stateData);
            $this->rowCount += count($stateData);
        }
    }
}