<?php

namespace App\Excels\Accommodations\Accommodations;

use App\Models\City;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportAccommodations implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Accommodation())->getFillable();
        $headers = $rows->first()->toArray();

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            $data = [];

            foreach ($fillable as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);
                    if ($column == 'city_id') {
                        $city_id = $row[$excelKey];
                        $city = City::find($city_id);
                        if (!$city) {
                            $data['city_id'] = null;
                        } else {
                            $data['city_id'] = $city_id;
                        }

                    } else if ($column == 'type') {
                        if ($type = AccommodationType::where('name', 'like', '%' . $row[$excelKey] . '%')->first()) {
                            $data['type_id'] = $type?->id ?? null;
                        } else {
                            $data['type_id'] = null;
                        }
                    } else if ($excelKey !== false && isset($row[$excelKey])) {
                        $data[$column] = $row[$excelKey];
                    } else {
                        $data[$column] = null;
                    }
                }
            }

            Accommodation::create($data);
            $this->rowCount++;
        }
    }
}