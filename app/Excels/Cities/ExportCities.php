<?php

namespace App\Excels\Cities;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportCities implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->name,
                $data->name_ar,
                $data->state_id,
                $data->country_id,
                $data->latitude,
                $data->longitude,
                $data->timezone,
                $data->wikiDataId,
                $data->population,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'state_id',
            'country_id',
            'latitude',
            'longitude',
            'timezone',
            'wikiDataId',
            'population',
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