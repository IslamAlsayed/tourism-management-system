<?php

namespace App\Excels\Accommodations\Hotels;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportHotels implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->description,
                $data->created_by,
                $data->sales_man,
                $data->sales_phone,
                $data->sales_mail,
                $data->reservation_man,
                $data->reservation_phone,
                $data->reservation_mail,
                $data->accounting_person,
                $data->accounting_mail,
                $data->accounting_phone,
                $data->country_id,
                $data->city_id,
                $data->region_id,
                $data->subregion_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'description',
            'created_by',
            'sales_man',
            'sales_phone',
            'sales_mail',
            'reservation_man',
            'reservation_phone',
            'reservation_mail',
            'accounting_person',
            'accounting_mail',
            'accounting_phone',
            'country_id',
            'city_id',
            'region_id',
            'subregion_id',
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