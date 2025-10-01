<?php

namespace App\Excels\TransportationCompaniesDepartments;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTransportationCompaniesDepartments implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->department,
                $data->contact_person,
                $data->mobile,
                $data->phone_01,
                $data->phone_02,
                $data->email_01,
                $data->email_02,
                $data->fax,
                $data->address,
                $data->website,
                $data->transportation_company_id,
                $data->country_id,
                $data->state_id,
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
            'department',
            'contact_person',
            'mobile',
            'phone_01',
            'phone_02',
            'email_01',
            'email_02',
            'fax',
            'address',
            'website',
            'transportation_company_id',
            'country_id',
            'state_id',
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