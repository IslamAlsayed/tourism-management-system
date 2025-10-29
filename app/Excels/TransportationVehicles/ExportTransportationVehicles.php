<?php

namespace App\Excels\TransportationVehicles;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTransportationVehicles implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->route,
                $data->route_ar,
                $data->duration,
                $data->distance,
                $data->car_route->id,
                $data->seats,
                $data->currency->id,
                $data->price,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'route',
            'route_ar',
            'duration',
            'distance',
            'car_route_id',
            'seats',
            'currency_id',
            'price',
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