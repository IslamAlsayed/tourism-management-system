<?php

namespace App\Excels\TransportationCompanyBusTypes;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTransportationCompanyBusTypes implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->min_seats,
                $data->max_seats,
                $data->seats,
                $data->company_id,
                $data->bus_type_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'min_seats',
            'max_seats',
            'seats',
            'company_id',
            'bus_type_id',
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