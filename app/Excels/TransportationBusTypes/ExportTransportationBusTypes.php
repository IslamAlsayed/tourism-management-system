<?php

namespace App\Excels\TransportationBusTypes;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTransportationBusTypes implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->category,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'category',
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