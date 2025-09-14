<?php

namespace App\Excels\Countries;

use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCountries implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $fillable = (new Country())->getFillable();
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
                    }
                }
            }

            $data['timezone'] = $this->fixTimezone($data['timezone']);

            Country::updateOrCreate(['name' => $data['name']], $data);

            $this->rowCount++;
        }
    }

    /**
     * ✅ function تنظف الـ JSON string
     */
    private function fixTimezone($value)
    {
        // Replace single quotes with double quotes
        $value = str_replace("'", '"', $value);
        $value = str_replace('\/', '/', $value);
        $value = str_replace('zoneName:', '"zoneName":', $value);
        $value = str_replace('gmtOffset:', '"gmtOffset":', $value);
        $value = str_replace('gmtOffsetName:', '"gmtOffsetName":', $value);
        $value = str_replace('abbreviation:', '"abbreviation":', $value);
        $value = str_replace('tzName:', '"tzName":', $value);

        // Decode to test validity
        $decoded = json_decode($value, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            return json_encode([]);
        }

        // رجّعه كـ JSON string valid
        return json_encode($decoded, JSON_UNESCAPED_UNICODE);
    }
}