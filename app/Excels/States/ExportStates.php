<?php

namespace App\Excels\States;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportStates implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->iso2,
                $data->iso3,
                $data->fips_code,
                $data->type,
                $data->level,
                $data->latitude,
                $data->longitude,
                $data->timezone,
                $data->parent_id,
                $data->country_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'iso2',
            'iso3',
            'fips_code',
            'type',
            'level',
            'latitude',
            'longitude',
            'timezone',
            'parent_id',
            'country_id',
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