<?php

namespace App\Excels\Cities;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCities implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new City())->getFillable();
        $headers = $rows->first()->toArray();

        $cityData = [];

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            $data = [];

            foreach ($fillable as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);
                    // if ($excelKey !== false && isset($row[$excelKey])) {
                    //     $data[$column] = $row[$excelKey];
                    // }

                    if ($column == 'state_id') {
                        $state_id = $row[$excelKey];
                        // تحقق إذا كان `state_id` موجودًا في جدول `states`
                        $state = State::find($state_id);
                        if (!$state) {
                            // إذا لم توجد `state_id`، اجعلها NULL
                            $data['state_id'] = null;
                        } else {
                            // إذا كانت موجودة، قم بتعيين القيمة الصحيحة
                            $data['state_id'] = $state_id;
                        }
                    } else if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    }
                }
            }

            $cityData[] = $data;

            // إدخال دفعة من البيانات
            if (count($cityData) >= 1000) {
                City::insert($cityData);
                $this->rowCount += count($cityData);
                $cityData = [];
            }
        }

        if (count($cityData) > 0) {
            City::insert($cityData);
        }
    }
}