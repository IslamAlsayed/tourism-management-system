<?php

namespace App\Excels\TourGuidesTypes;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTourGuidesTypes implements FromArray, WithHeadings, WithCustomCsvSettings
{
    protected $arrayData;

    public function __construct($arrayData)
    {
        $this->arrayData = $arrayData;
    }

    public function array(): array
    {
        $list = [];
        foreach ($this->arrayData as $data) {
            $list[] = [
                $data->type,
                $data->price,
                $data->currency_id,
                $data->country_id,
                $data->city_id,
                $data->state_id,
                $data->region_id,
                $data->subregion_id,
                $data->multi_states,
                $data->multi_cities,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'type',
            'price',
            'currency_id',
            'country_id',
            'city_id',
            'state_id',
            'region_id',
            'subregion_id',
            'multi_states',
            'multi_cities',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => true, // <--- دي مهمة جداً للغة العربية
        ];
    }
}