<?php

namespace App\Excels\Restaurants;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportRestaurants implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->type_id,
                $data->country_id,
                $data->city_id,
                $data->region_id,
                $data->subregion_id,
                $data->rating,
                $data->company_name_ar,
                $data->specialty,
                $data->phone_01,
                $data->phone_02,
                $data->fax,
                $data->contact_person,
                $data->email_01,
                $data->email_02,
                $data->box,
                $data->postal_code,
                $data->street,
                $data->mobile,
                $data->website,
                $data->notes,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'type_id',
            'country_id',
            'city_id',
            'region_id',
            'subregion_id',
            'rating',
            'company_name_ar',
            'specialty',
            'phone_01',
            'phone_02',
            'fax',
            'contact_person',
            'email_01',
            'email_02',
            'box',
            'postal_code',
            'street',
            'mobile',
            'website',
            'notes',
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